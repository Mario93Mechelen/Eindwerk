Hello <i>{{ $demo->receiver }}</i>,
<p>We send you this mail so you can confirm the email address you signed up with.</p>

<a href="{{URL::action('Auth\LoginController@confirmemail', $demo->token)}}">Confirm email</a>

Thank You,
<br/>
<i>{{ $demo->sender }}</i>