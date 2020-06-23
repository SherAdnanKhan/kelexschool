@component('mail::message')

    <h1>Hey, {{ $reset_details['first_name'] }} {{ $reset_details['last_name'] }}</h1>
        You or someone else has requested your account details. <br/>
        Here is your account information, please keep this as you may need this at a later stage. <br/>
        Your email:  {{ $reset_details['email'] }} <br/>
        Your password:  {{ $reset_details['new_password'] }} <br/> 
        Your password has been reset, please login and change your password to something more rememberable. 
    
    Thank you
    Regards,
    {{ config('app.name') }} Support

@endcomponent