<?php echo $header; ?>
	<div id="content">
		<?php echo $column_left; ?> 
		<?php echo $content_top; ?>
		<?php echo $content_bottom; ?>
		<?php echo $column_right; ?>
	</div>
	<?php
// keys from your app
$oauth_access_token = "2644316399-LmM1IMjnG8a4C90IxnUU5FnQovXcloZ7YGxOSDS";
$oauth_access_token_secret = "mOc74P0vFYrgGJGiFmDlp5mPnYRCtFeblJFgNXNsUoCqy";
$consumer_key = "yM5WuRKK7ZOctjbgTmZggdrDm";
$consumer_secret = "XwszDzmWt6F8hSyXhqjSe5PL5SkfKcPn7HlseIe4PVZ54qZjCq";
 
// we are going to use "user_timeline"
$twitter_timeline = "user_timeline";
 
// specify number of tweets to be shown and twitter username
// for example, we want to show 20 of Taylor Swift's twitter posts
$request = array(
    'count' => '10',
    'screen_name' => 'saravana32cse'
);

// put oauth values in one oauth array variable
$oauth = array(
    'oauth_consumer_key' => $consumer_key,
    'oauth_nonce' => time(),
    'oauth_signature_method' => 'HMAC-SHA1',
    'oauth_token' => $oauth_access_token,
    'oauth_timestamp' => time(),
    'oauth_version' => '1.0'
);
 
// combine request and oauth in one array
$oauth = array_merge($oauth, $request);
 
// make base string
$baseURI="https://api.twitter.com/1.1/statuses/$twitter_timeline.json";
$method="GET";
$params=$oauth;
 
$r = array();
ksort($params);
foreach($params as $key=>$value){
    $r[] = "$key=" . rawurlencode($value);
}
$base_info = $method."&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
$composite_key = rawurlencode($consumer_secret) . '&' . rawurlencode($oauth_access_token_secret);
 
// get oauth signature
$oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
$oauth['oauth_signature'] = $oauth_signature;

// make request
// make auth header
$r = 'Authorization: OAuth ';
 
$values = array();
foreach($oauth as $key=>$value){
    $values[] = "$key=\"" . rawurlencode($value) . "\"";
}
$r .= implode(', ', $values);
 
// get auth header
$header = array($r, 'Expect:');
 
// set cURL options
$options = array(
    CURLOPT_HTTPHEADER => $header,
    CURLOPT_HEADER => false,
    CURLOPT_URL => "https://api.twitter.com/1.1/statuses/$twitter_timeline.json?". http_build_query($request),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => true
);

// retrieve the twitter feed
$feed = curl_init();
curl_setopt_array($feed, $options);
$json = curl_exec($feed);
curl_close($feed);
 
// decode json format tweets
$tweets=json_decode($json, true);

// show user information
echo "<div class='overflow-hidden'>";
 
    // user data
    $profile_photo=str_replace("normal", "400x400", $tweets[0]['user']['profile_image_url_https']);
    $name=$tweets[0]['user']['name'];
    $screen_name=$tweets[0]['user']['screen_name'];
     
    // show profile photo
    echo "<img src='{$profile_photo}' class='img-thumbnail' />";
     
    // show other information about the user
    echo "<div class='text-align-center'>";
        echo "<div><h2>{$name}</h2></div>";
        echo "<div><a href='https://twitter.com/{$screen_name}' target='_blank'>@{$screen_name}</a></div>";
    echo "</div>";
     
    echo "<hr />";
echo "</div>";

$statuses_count=$tweets[0]['user']['statuses_count'];
$followers_count=$tweets[0]['user']['followers_count'];
 
// show numbers
echo "<div class='overflow-hidden'>";
 
    // show number of tweets
    echo "<div class='float-left margin-right-2em text-align-center'>";
        echo "<div class='color-gray'>Tweets</div>";
        echo "<div class='badge font-size-20px'>" . number_format($statuses_count, 0, '.', ',') . "</div>";
    echo "</div>";
     
    // show number of followers
    echo "<div class='float-left margin-right-2em text-align-center'>";
        echo "<div class='color-gray'>Followers</div>";
        echo "<div class='badge font-size-20px'>" . number_format($followers_count, 0, '.', ',') . "</div>";
    echo "</div>";
     
echo "</div>";
 
echo "<hr />";

// show tweets
foreach($tweets as $tweet){
     
    // show a tweet
    echo "<div class='overflow-hidden'>";
         
        // show picture
        echo "<div class='tweet-image'>";
            echo "<img src='{$profile_photo}' class='img-thumbnail' />";
        echo "</div>";
         
        // show tweet content
        echo "<div class='tweet-text'>";
             
            // show name and screen name
            echo "<h4 class='margin-top-4px'>";
                echo "<a href='https://twitter.com/{$screen_name}'>{$name}</a> ";
                echo "<span class='color-gray'>@{$screen_name}</span>";
            echo "</h4>";
             
            // show tweet text
            echo "<div class='margin-zero'>";
             
                // get tweet text
                $tweet_text=$tweet['text'];
                 
                // make links clickable
                $tweet_text=preg_replace('@(https?://([-\w\.]+)+(/([\w/_\.]*(\?\S+)?(#\S+)?)?)?)@', '<a href="$1" target="_blank">$1</a>', $tweet_text);
                 
                // output
                echo $tweet_text;
            echo "</div>";
        echo "</div>";
         
    echo "</div>";
    echo "<hr />";
}
?>
<?php echo $footer; ?>