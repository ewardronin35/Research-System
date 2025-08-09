<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('research_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // The unique code for access
$table->foreignId('research_id')->nullable()->constrained('researches')->onDelete('cascade');
            $table->timestamp('expires_at')->nullable(); // Optional: sets an expiration date
            $table->boolean('is_used')->default(false); // Tracks if the code has been used
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('research_codes');
    }
};