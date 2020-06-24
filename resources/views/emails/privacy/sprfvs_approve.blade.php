@component('mail::message')

    <img src="{{ $data['logo'] }}" width="100" height="100"/> 

    Hey, {{ $data['by_user']['username'] }}

    The artist {{ $data['to_user']['username'] }} as just accepted your friend request. Log in to Meuzm to view {{ $data['by_user']['username'] }}’s latest Exhibits, MzFlashes, and more.
    This access excludes any Special Invite set areas.
    
    Thank you
    Regards,
    {{ config('app.name') }} Support

@endcomponent