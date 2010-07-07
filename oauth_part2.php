<?php

include 'oauth.inc.php';

$request_token = $_GET['oauth_token'];
$request_token_secret = $_COOKIE['request_secret'];
$verifier = $_GET['oauth_verifier'];

$oauth = new OAuth(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET);

$oauth->setToken($request_token, $request_token_secret);

try {
    $acc_token = $oauth->getAccessToken("http://openapi.etsy.com/v2/oauth/access_token", null, $verifier);
} catch (OAuthException $e) {
    log_fatal_error($e, $oauth);
}

// set the oauth token and secret for later retrieval
setcookie("oauth_token", $acc_token['oauth_token']);
setcookie("oauth_token_secret", $acc_token['oauth_token_secret']);

header('Location: oauth_part3.php');
