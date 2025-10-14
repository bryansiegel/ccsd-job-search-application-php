<?php

//API endpoint
// $api_url = 'https://comi1.dream.press/wp-json/wp/v2/posts?categories=183';
$api_url = 'https://newsroom.ccsd.net/wp-json/wp/v2/posts?categories=183';

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

        
        ?>
    
<div id="news_box">
            <?php
            if($posts && is_array($posts)) {
            foreach ($posts as $post) { ?>

                <a href="<?php echo $post['link']; ?>" id="news_item_1" data-item="1" class="current news-item-wrap clearfix"
                    style="top: 0; opacity: 1;text-decoration:none !important;">
                    <!-- <div style="position: relative;width:960px;height:425px;"> -->
                    <div style="position: relative;">
                        <img class="news-img" style="top: 0;" src="<?php echo $post['jetpack_featured_media_url']; ?>"
                            alt="<?php echo $post['title']['rendered']; ?>" />
                        <div class="news-copy-wrap" style="top: 320px !important;">
                            <div class="news-copy">
                                <h3 style="text-decoration:none !important; top:-50px;font-size: 38px !important;"><?php echo $post['title']['rendered']; ?>
                                </h3>
                            </div>
                        </div>
                        <div class="news-shadow"></div>
                    </div>
                </a>
            </div>
            </div>

            <?php
            //loop only once
            break;
            }
    } else { ?>
        
        <a href="" id="news_item_1" data-item="1" class="current news-item-wrap clearfix"
                    style="top: 0; opacity: 1;text-decoration:none !important;">
                    <!-- <div style="position: relative;width:960px;height:425px;"> -->
                    <div style="position: relative;">
                        <img class="news-img" style="top: 0;" src="https://newsroom.ccsd.net/wp-content/uploads//CCSD-Sahara-Exterior_Main-1-1.jpeg"
                            alt="" />
                        <div class="news-copy-wrap" style="top: 320px !important;">
                            <div class="news-copy">
                                <h3 style="text-decoration:none !important; top:-50px;font-size: 38px !important;">
                                </h3>
                            </div>
                        </div>
                        <div class="news-shadow"></div>
                    </div>
                </a>
            </div>
            </div>
   <?php }
    // Close the cURL session
    curl_close($curl);
}
?>