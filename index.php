<?php

// Begin the PHP session so we have a place to store session data
session_start();










// If they click log out, destroy the session and redirect to the home page
if(isset($_GET['logout'])) {
  session_destroy();
  header('Location: /');
  die();
}











// If there is a username, they are logged in, and we'll show a simple logged-in view
if(isset($_SESSION['username'])) {
  echo '<p>Logged in as</p>';
  echo '<p>' . $_SESSION['username'] . '</p>';
  echo '<p><a href="/?logout">Log Out</a></p>';
  die();
}













$client_id = '';
$client_secret = '';
$redirect_uri = 'http://localhost:8080/';

$oauth_server = '';  // This is the issuer URL of your Okta authorization server
$metadata_url = $oauth_server.'/.well-known/oauth-authorization-server';
// Fetch the authorization server metadata which contains a few URLs
// that we need later, such as the authorization and token endpoints
$metadata = http($metadata_url);













// If something went wrong and we didn't get an authorization code, 
// there is probably an error description in the URL.
if(isset($_GET['error'])) {
  echo '<p>Authorization server returned an error: <b>'.htmlspecialchars($_GET['error']).'</b></p>';
  echo '<p>'.htmlspecialchars($_GET['error_description']).'</p>';
  echo '<p><a href="/">Start Over</a></p>';
  die();
}










// If the AS redirected here with a code, we can try to exchange it for an access token
if(isset($_GET['code'])) {



  // Double check the server returned the correct state parameter
  if($_SESSION['state'] != $_GET['state']) {
    die('Authorization server returned an invalid state parameter');
  }



  // Exchange the authorization code now!
  $response = http($metadata->token_endpoint, [
    // TODO: fill in the post body parameters here!
  ]);








  // If the response did not include an access token, show an error
  if(!isset($response->access_token)) {
    echo '<p>Error getting an access token:</p>';
    echo '<pre>';
    print_r($response);
    echo '</pre>';
    echo '<p><a href="/">Start Over</a></p>';
    die();
  }



  echo '<h3>Access Token Response</h3>';
  echo '<pre>'; print_r($response); echo '</pre>';












  // Extract the user's email address from the ID token and save it in the session
  if(property_exists('id_token', $response)) {
    $id_token = $response->id_token;
    $claims_component = explode('.', $id_token)[1];
    $userinfo = json_decode(base64_decode($claims_component));
    $_SESSION['username'] = $userinfo->email;
    echo '<p>Hello '.htmlspecialchars($_SESSION['username']).'</p>';
  }

  

  echo '<p><a href="/">Home Page</a></p>';
  die();





} else {





  // Create the link to send the user to log in

  // Generate a random state parameter for CSRF security
  $_SESSION['state'] = bin2hex(random_bytes(5));

  
  // Build the authorization URL by starting with the authorization endpoint
  // and adding a few query string parameters identifying this application
  $authorize_url = $metadata->authorization_endpoint.'?'.http_build_query([
    // TODO: fill in the query string parameters here!
  ]);

  echo '<p>Not logged in</p>';
  echo '<p><a href="'.$authorize_url.'">Log In</a></p>';






}








// This function generates a base64-url-encoded version of 
// the sha256 hash of the input. This is used to generate the
// PKCE challenge from the PKCE code verifier.
function pkce_challenge($plain) {
  return base64_urlencode(hash('sha256', $plain, true));
}

// Base64-urlencoding is a simple variation on base64-encoding
// Instead of +/ we use -_, and the trailing = are removed.
function base64_urlencode($string) {
  return rtrim(strtr(base64_encode($string), '+/', '-_'), '=');
}



// This helper method makes an HTTP request using GET or POST
// depending on whether $post_params is present.
// The response is assumed to be a JSON body and will be decoded.
function http($url, $post_params=false) {
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  if($post_params)
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_params));
  return json_decode(curl_exec($ch));
}

