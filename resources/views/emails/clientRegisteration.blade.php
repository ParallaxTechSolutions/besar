<div style="margin:15px">

    <h2>New client has registered.<br/></h2><br>
	<h4>Client Details:</h4>
	Name: {{$formData['billing_first_name']}} {{$formData['billing_last_name']}}<br>
	Address: {{$formData['billing_address']}} {{$formData['billing_city']}}<br>
	{{$formData['billing_state_name']}} {{$formData['billing_country_name']}} {{$formData['billing_post_code']}}<br>
	Telephone: {{$formData['billing_telephone']}}<br>
	Email: {{$formData['billing_email']}} 
<br>
    <img alt="logo" src="{{$formData['url']}}">

</div>