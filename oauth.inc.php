<?php
// the key assigned to you for api v2
define('OAUTH_CONSUMER_KEY', getenv('OAUTH_CONSUMER_KEY'));

// the secret assigned along with the key
define('OAUTH_CONSUMER_SECRET', getenv('OAUTH_CONSUMER_SECRET'));

// the url to redirect to after signin to etsy
define('OAUTH_CALLBACK_URL', 'http://'. $_SERVER['HTTP_HOST'] .'/oauth_part2.php');

function log_fatal_error($e, $oauth) {
    error_log($e->getMessage());
    error_log(print_r($oauth->getLastResponse(), true));
    error_log(print_r($oauth->getLastResponseInfo(), true));
    die($oauth->getLastResponse()); 
}

function get_listing_url($listing_id) {
    return "<a href=http://www.etsy.com/listing/$listing_id target=_blank>$listing_id</a>";
}
