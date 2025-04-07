<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://your-app-url.com/images/logo.png" class="logo" alt="Your App Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>