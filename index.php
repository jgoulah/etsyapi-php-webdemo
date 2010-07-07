<?php
require 'oauth.inc.php';

$oauth = new OAuth(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET);
try {
    $req_token = $oauth->getRequestToken("http://openapi.etsy.com/v2/oauth/request_token", OAUTH_CALLBACK_URL);
} catch(OAuthException $e) {
    log_fatal_error($e, $oauth);
}

$login_url = sprintf(
    "%s?oauth_consumer_key=%s&oauth_token=%s",
    $req_token['login_url'],
    $req_token['oauth_consumer_key'],
    $req_token['oauth_token']
);

// put the request secret into a cookie
setcookie("request_secret", $req_token['oauth_token_secret']);

print "<h1>Etsy OAuth Sample App</h1>";
print "Please connect with Etsy <a href=$login_url target=_blank>here</a>";
