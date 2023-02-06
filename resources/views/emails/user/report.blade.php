@component('mail::message')

    <img src="{{ $data['logo'] }}" width="100" height="100"/> 

    Hey, {{ $data['to_user']['username'] }}

    The artist {{ $data['by_user']['username'] }} as just reported your account.
    The reason behind the report submited by user was "{{$data['report_reason']}}".
    Please be careful next time your account might be freeze.
    
    Thank you
    Regards,
    {{ config('app.name') }} Support

@endcomponent