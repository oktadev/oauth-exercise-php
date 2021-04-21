OAuth Exercise
==============

`index.php`

This is the main OAuth client code from the demos.

* Fill in the missing parameters in `index.php` to complete the authorization code flow
* As an exercise, modify the code to request an ID token to know who logged in

Run this code from the command line:

```bash
php -S 127.0.0.1:8080
```

`api.php`

This is a minimal API (resource server) that returns a list of photos when presented with a valid access token.

Experiment with different ways to enforce what a "valid" access token is, by using groups and scopes and other claims present in the access token.


`pkce.html`

This is a static HTML page that you can use to complete the authorization code flow with PKCE in pure JavaScript. The code is based off of the code from the blog post [Is the OAuth 2.0 Implicit Flow Dead?](https://developer.okta.com/blog/2019/05/01/is-the-oauth-implicit-flow-dead#start-using-pkce-in-javascript-today)

`client-credentials.php`

Try getting an access token via the Client Credentials grant.

```bash
php client-credentials.php
```
