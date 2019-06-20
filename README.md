OAuth Exercise
==============

`index.php`

* Fill in the missing parameters in `index.php` to complete the OAuth flow
* Convert the code to use the PKCE flow
* Add in a request to get an ID token via the authorization code flow to know who logged in

Run this code from the command line:

```bash
php -S 127.0.0.1:8080
```

`implicit.html`

This is a static HTML page that you can use as a template to try out the Implicit flow for OAuth or OpenID Connect.

`pkce.html`

This is a static HTML page that you can use to complete the authorization code flow with PKCE in pure JavaScript. The code is based off of the code from the blog post [Is the OAuth 2.0 Implicit Flow Dead?](https://developer.okta.com/blog/2019/05/01/is-the-oauth-implicit-flow-dead#start-using-pkce-in-javascript-today)

`client-credentials.php`

Try getting an access token via the Client Credentials grant.

```bash
php client-credentials.php
```
