<p>Dear {{ $consignor->name }} </p><br>
<p>
    Your password on {{ get_settings()->site_name }} has been changed successfully. Here are your new login credentials:
    <br>
    <b>Login ID: </b> {{ isset($consignor->username) ? $consignor->username. ' or ' : '' }} {{ $consignor->email }}
    <br>
    <b>Password: {{ $new_password }}</b>
</p>
<br>
Please, keep your credentials confidential. Your Login ID and password are your own credentials and you should never share them with anybody else.

<p>
    {{ get_settings()->site_name }} will not liable for any mis use of your login id or password.
</p>
<br>
----------------------------------------------
<p>
    This email was automatically sent by {{ get_settings()->site_name }}. Do not reply to it.
</p>
