@component('mail::message')

    <img src="{{ $data['logo'] }}" width="100" height="100"/> 

    Hey, {{ $data['to_user']['username'] }}

    The artist {{ $data['by_user']['username'] }} is sendeing you a Special Invite to view their private Gallery: {{ $data['gallery_name'] }}.
    Log in to Meuzm to view these exclusive exhibits. You may even Fave this private Gallery to have the latest exhibits from this Gallery display in your Lobby feed.
    
    Thank you
    Regards,
    {{ config('app.name') }} Support

@endcomponent