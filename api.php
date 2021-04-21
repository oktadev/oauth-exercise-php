<?php
// A minimal example of building a resource server (API) that validates access tokens and returns data
header('Content-type: application/json');


// This is a "database"
$photos = ['cat.jpg', 'dog.jpg'];


// Require an access token is sent in the HTTP Authorization header
if(!isset($_SERVER['HTTP_AUTHORIZATION'])) {
	die('Forbidden');
}


$accessToken = explode(' ', $_SERVER['HTTP_AUTHORIZATION'])[1];


// The resource server will need its own credentials to use the introspection endpoint
$client_id = '';
$client_secret = '';


// Make an introspection request to validate the token
$response = http('https://dev-xxxxxxxx.okta.com/oauth2/default/v1/introspect', [
	'client_id' => $client_id,
	'client_secret' => $client_secret,
	'token' => $accessToken,
]);


if($response['active'] != 1) {
	die('Invalid Token');
}


// Require the user is in certain groups
if(!in_array('PhotoManagers', $response['group'])) {
	die('Only PhotoManagers can see photos');
}

// Require the token was issued with certain scopes
$scopes = explode(' ', $response['scope']);
if(!in_array('photos', $scopes)) {
	die('Token does not contain "photos" scope');
}


// Return the API response
echo json_encode(['photos' => $photos]);






















function http($url, $post_params=false) {
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  if($post_params)
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_params));
  return json_decode(curl_exec($ch), true);
}

