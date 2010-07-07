<?php
include 'oauth.inc.php';

$access_token = $_COOKIE['oauth_token'];
$access_token_secret = $_COOKIE['oauth_token_secret'];

$oauth = new OAuth(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET,
                   OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);
$oauth->setToken($access_token, $access_token_secret);

if (!empty($_GET) && isset($_GET['method']) && isset($_GET['listing_id'])) {
    try {
        $data = $oauth->fetch("http://openapi.etsy.com/v2/private/users/__SELF__/favorites/listings/".$_GET['listing_id']."?method=".$_GET['method']);
        $json = $oauth->getLastResponse();
        print_r(json_decode($json, true));
    } catch (OAuthException $e) {
        log_fatal_error($e, $oauth);
    }
}

try {
    $data = $oauth->fetch("http://openapi.etsy.com/v2/private/users/__SELF__/favorites/listings?includes=Listing");
    $json = $oauth->getLastResponse();
    $favorites = json_decode($json, true);
    
    $data = $oauth->fetch("http://openapi.etsy.com/v2/private/listings/active?limit=10");
    $json = $oauth->getLastResponse();
    $active = json_decode($json, true);
    
} catch (OAuthException $e) {
    log_fatal_error($e, $oauth);
}

print('<h1>Favorites</h1><ul>');
foreach($favorites['results'] as $listing) {
    print('<li>[<a href="oauth_part3.php?listing_id='.$listing['listing_id'].'&method=DELETE">delete</a>] '
          . get_listing_url($listing['listing_id']) .'  -  '. $listing['Listing']['title'] .'</li>');
}
print('</ul>');


print('<h1>Active Listings</h1><ul>');
foreach($active['results'] as $listing) {
    print('<li>[<a href="oauth_part3.php?listing_id='.$listing['listing_id'].'&method=POST">add</a>] '
         . get_listing_url($listing['listing_id']) .'  -  '. $listing['title'].'</li>');
}
print('</ul>');
