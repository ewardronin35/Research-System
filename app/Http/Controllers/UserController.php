<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('head.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('head.users.create');
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string|in:user,head', // Validate role
            'can_login' => 'sometimes|boolean',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make(substr(md5(time()), 0, 8)), // Generate random password
            'role' => $request->role,
            'can_login' => $request->has('can_login'),
            'last_login_at' => null, // This triggers reset on first login
        ]);
        Password::sendResetLink(['email' => $user->email]);

        return redirect()->route('head.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('head.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                Rule::unique('users')->ignore($user->id)
            ],
            'role' => 'required|string|in:user,head', // Validate role
            'can_login' => 'sometimes|boolean',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'can_login' => $request->has('can_login'),
        ]);

        return redirect()->route('head.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // Don't allow deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('head.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();
        return redirect()->route('head.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Show form for importing users from CSV.
     *
     * @return \Illuminate\Http\Response
     */
    public function importForm()
    {
        return view('head.users.import');
    }

    /**
     * Import users from CSV file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   /**
 * Import users from CSV file.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
public function import(Request $request)
{
    $request->validate([
        'csv_file' => 'required|file|mimes:csv,txt|max:10240',
    ]);

    $file = $request->file('csv_file');
    $path = $file->getRealPath();
    $handle = null;
    
    try {
        // Open the file
        $handle = fopen($path, 'r');
        if (!$handle) {
            return redirect()->back()->with('error', 'Could not open file.');
        }
        
        // Read the header row
        $header = fgetcsv($handle);
        if (!$header) {
            fclose($handle);
            return redirect()->back()->with('error', 'CSV file is empty or malformed.');
        }
        
        // Check if the required columns exist
        $requiredColumns = ['name', 'email', 'role'];
        $headerMap = array_flip($header);
        
        foreach ($requiredColumns as $column) {
            if (!isset($headerMap[$column])) {
                fclose($handle);
                return redirect()->back()->with('error', "Missing required column: {$column}");
            }
        }
        
        $successCount = 0;
        $errorRows = [];
        $rowNumber = 1; // Start at 1 for the header row
        
        DB::beginTransaction();
        
        // Process each row
        while (($row = fgetcsv($handle)) !== false) {
            $rowNumber++;
            
            // Skip empty rows
            if (count(array_filter($row)) === 0) {
                continue;
            }
            
            // Map CSV columns to data array
            $data = [];
            foreach ($header as $index => $columnName) {
                if (isset($row[$index])) {
                    $data[$columnName] = trim($row[$index]);
                }
            }
            
            // Set can_login
            if (isset($data['can_login'])) {
                $data['can_login'] = in_array(strtolower($data['can_login']), ['yes', 'true', '1']);
            } else {
                $data['can_login'] = true; // Default to true if not specified
            }
            
            // Validate the data manually
            $rowErrors = [];
            
            if (empty($data['name'])) {
                $rowErrors[] = "Name is required";
            }
            
            if (empty($data['email'])) {
                $rowErrors[] = "Email is required";
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $rowErrors[] = "Email is invalid";
            } elseif (User::where('email', $data['email'])->exists()) {
                $rowErrors[] = "Email already exists";
            }
            
            if (empty($data['role'])) {
                $rowErrors[] = "Role is required";
            } elseif (!in_array($data['role'], ['admin', 'researcher', 'head', 'faculty'])) {
                $rowErrors[] = "Role must be admin, researcher, head, or faculty";
            }
            
            if (!empty($rowErrors)) {
                $errorRows[] = "Row {$rowNumber}: " . implode(', ', $rowErrors);
                continue;
            }
            
            // Create the user
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make(substr(md5(time() . rand()), 0, 8)),
                'role' => $data['role'],
                'can_login' => $data['can_login'] ?? true,
                'password_changed' => false, // New users need to change their password
            ]);
            
            $successCount++;
            $successfulEmails[] = $data['email']; // Collect the email

        }
        
        fclose($handle);
        
        if ($successCount > 0) {
            DB::commit();
            
            // Send password reset links to all successfully imported users
            foreach ($successfulEmails as $email) {
                \Illuminate\Support\Facades\Password::sendResetLink(['email' => $email]);
            }
            
            return redirect()->route('head.users.index')
                ->with('success', "{$successCount} users imported successfully. Password reset links have been sent to all users.")
                ->with('import_errors', $errorRows);
                
        } else {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'No users were imported.')
                ->with('import_errors', $errorRows); // Changed key name to avoid conflicts
        }
        
    } catch (\Exception $e) {
        DB::rollBack();
        if (isset($handle) && is_resource($handle)) {
            fclose($handle);
        }
        return redirect()->back()->with('error', 'Error importing users: ' . $e->getMessage());
    }
}
    /**
     * Toggle the login status for a user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function toggleLogin(User $user)
    {
        // Don't allow disabling login for yourself
        if ($user->id === auth()->id()) {
            return redirect()->back()
                ->with('error', 'You cannot disable login for your own account.');
        }

        $user->update([
            'can_login' => !$user->can_login,
        ]);

        $status = $user->can_login ? 'enabled' : 'disabled';
        return redirect()->back()
            ->with('success', "Login {$status} for {$user->name}.");
    }

    /**
     * Reset a user's password to a random string.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(User $user)
    {
        $password = substr(str_shuffle(MD5(microtime())), 0, 8);
        
        $user->update([
            'password' => Hash::make($password),
        ]);

        return redirect()->back()
            ->with('success', "Password for {$user->name} has been reset to: {$password}");
    }
}