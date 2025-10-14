<?php

// Define the API endpoint
// $api_url = 'https://comi1.dream.press/wp-json/wp/v2/posts?categories=185';
$api_url = 'https://newsroom.ccsd.net/wp-json/wp/v2/posts?categories=185';

// Initialize cURL
$curl = curl_init();

// Set cURL options
curl_setopt($curl, CURLOPT_URL, $api_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPGET, true);

// Add authentication header (Basic Auth)
// $username = 'staging_kx7bw2';
// $password = 'q8pNzMKdVEcH';
// curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");

// Execute the request and store the response
$response = curl_exec($curl);

// Check if the request was successful
if ($response === false) {
    echo 'cURL Error: ' . curl_error($curl);
} else {
    // Decode the JSON response into a PHP array
    $posts = json_decode($response, true);

    // Check if decoding was successful
    // if (json_last_error() === JSON_ERROR_NONE) {
        // Process the posts

        // var_dump($posts);

        if($posts && is_array($posts)) {
        foreach ($posts as $post) { ?>

            <div id="news_story_2">
                <a href="<?php echo $post['link']; ?>">
                    <div class="story-img">
                        <img src="<?php echo $post['jetpack_featured_media_url']; ?>" alt="<?php echo $post['title']['rendered']; ?>" height="169" width="310">
                    </div>
                    <div class="story-headline">
                        <?php echo $post['title']['rendered']; ?>
                    </div>
                </a>
            </div>


        <?php
        //loop only once
        break;
        }
    } else { ?>
        <div id="news_story_2">
                <!-- <a href=""> -->
                    <div class="story-img">
                        <img src="https://newsroom.ccsd.net/wp-content/uploads//CCSD-Sahara-Exterior_Main-1-1.jpeg" alt="" height="169" width="310">
                    </div>
                    <!-- <div class="story-headline"> -->
                        
                    <!-- </div> -->
                <!-- </a> -->
            </div>
    <?php }

    // Close the cURL session
    curl_close($curl);
}
?>