@component('mail::message')

    <img src="{{ $data['logo'] }}" width="100" height="100"/> 

    Hey, {{ $data['to_user']['username'] }}

    The artist {{ $data['by_user']['username'] }} has requested to be added to your SPRFVS list.
    Please log in to your account to accept or deny this request. By accepting this request you are granting and recieving mutual access to all areas of eacother’s Studios, Galleries, StrqChatting, and MzFlash.
    This level of access excludes any Special Invite set areas.
    
    Thank you
    Regards,
    {{ config('app.name') }} Support

@endcomponent