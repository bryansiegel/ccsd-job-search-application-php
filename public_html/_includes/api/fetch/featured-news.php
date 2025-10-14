<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// echo $_SERVER['PHP_SELF'];

//only run this script if it's a cron job.
if(empty($_SERVER["REMOTE_ADDR"])) {

// //API endpoint
// // $api_url = 'https://comi1.dream.press/wp-json/wp/v2/posts?categories=183';
$api_url = 'https://newsroom.ccsd.net/wp-json/wp/v2/posts?categories=183';

// // Initialize cURL
$curl = curl_init();

// // Set cURL options
curl_setopt($curl, CURLOPT_URL, $api_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPGET, true);

// // Add authentication header (Basic Auth)
// // $username = 'staging_kx7bw2';
// // $password = 'q8pNzMKdVEcH';
// // curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");

// // Execute the request and store the response
$response = curl_exec($curl);

if($response === false) {
    //email if the api response isn't working
    $headers =
        "From: wordpress-support-user@nv.ccsd.net" . "\r\n" .
        "Reply-To: wordpress-support-user@nv.ccsd.net" . "\r\n" .
        "X-Mailer: PHP/" . phpversion();

    // mail("wordpress-support-user@nv.ccsd.net ", "Featured News API From Newsroom is broken", "The Newsroom API is broken for Featured News", $headers);    
} else {
// Decode the JSON response into a PHP array
$posts = json_decode($response, true);

}


$results = array();

if($posts && is_array($posts)) {
    foreach ($posts as $post) {
        $results[] = $post;
        //only loop once
        break;
    }
}


$jsonData = json_encode($results, JSON_PRETTY_PRINT);

// //add post to json file
$file = '/www/apache/htdocs/ccsd/_includes/api/json/featured-news.json';

// //check to see if it works
if (file_put_contents($file, $jsonData)) {
    // echo "Data Successfully written";
} else {
    echo "Error writing to $file";
}

// Close the cURL session
curl_close($curl);
} else {
    //
}

?>