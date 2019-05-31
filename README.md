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

`client-credentials.php`

Try getting an access token via the Client Credentials grant.

```bash
php client-credentials.php
```
