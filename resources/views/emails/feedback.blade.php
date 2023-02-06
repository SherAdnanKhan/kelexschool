@component('mail::message')

    Hey,

    Someone with Email:{{$data['email']}} gave a feedback reason: {{$data['feedback']}}
    
    Thank you
    Regards,
    {{ config('app.name') }} Support

@endcomponent