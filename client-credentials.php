<?php

$client_id = '';
$client_secret = '';
$redirect_uri = 'http://localhost:8080/';

$oauth_server = '';
$metadata_url = $oauth_server.'/.well-known/oauth-authorization-server';
// Fetch the authorization server metadata which contains a few URLs
// that we need later, such as the authorization and token endpoints
$metadata = http($metadata_url);



$response = http($metadata->token_endpoint, [
	'grant_type' => 'client_credentials',
	'client_id' => $client_id,
	'client_secret' => $client_secret,
]);


echo '<h3>Access Token Response</h3>';
echo '<pre>'; print_r($response); echo '</pre>';









function http($url, $params=false) {
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  if($params)
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
  return json_decode(curl_exec($ch));
}
