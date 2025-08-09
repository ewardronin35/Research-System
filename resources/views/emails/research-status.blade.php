@component('mail::message')
# Research Submission Status Updated

Hello,

This is an update regarding your research paper submission to the repository.

**Title:** {{ $research->title }}

**Status:** @if($research->approval_status == 'approved') <span style="color: green; font-weight: bold;">Approved</span> @else <span style="color: red; font-weight: bold;">Rejected</span> @endif

@if($research->approval_status == 'approved')
Congratulations! Your paper has been approved and is now available in our public repository.
@else
Unfortunately, your paper was not approved at this time. Please contact the administrator if you have any questions.
@endif

Thank you for your contribution.

Regards,<br>
{{ config('app.name') }}
@endcomponent