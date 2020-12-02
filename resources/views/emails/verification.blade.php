@component('mail::message')

    Hey,

    Someone tried to sign up/ login for an Meuzm account with {{$data['email']}}.
    If it was you, enter this verification code: {{$data['verification_code']}}
    
    Thank you
    Regards,
    {{ config('app.name') }} Support

@endcomponent