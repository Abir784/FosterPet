@component('mail::message')
# Response to Your Report

Dear {{ $report->reporter->name }},

We have reviewed your report regarding a message in our system. Here is our response:

@component('mail::panel')
{{ $response->response_content }}
@endcomponent

**Action Taken:** {{ $response->action_taken }}

Thank you for helping us maintain a safe and respectful environment on FosterPet.

Best regards,<br>
{{ config('app.name') }} Team
@endcomponent
