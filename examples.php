<?php
    require('src/RocketAPI.php');
    require('src/Exceptions/NotFoundException.php');
    require('src/Exceptions/BadResponseException.php');
    require('src/InstagramAPI.php');

    use RocketAPI\InstagramAPI;

    $api = new InstagramAPI("put your token here");

    // ===== SEARCH METHODS =====

    // Search for users
    try {
        echo "\n=== Search Users ===\n";
        $results = $api->searchUsers('nike');
        print_r($results);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Search for hashtags
    try {
        echo "\n=== Search Hashtags ===\n";
        $results = $api->searchHashtags('travel');
        print_r($results);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Search for locations
    try {
        echo "\n=== Search Locations ===\n";
        $results = $api->searchLocations('new york');
        print_r($results);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Search for audio tracks
    try {
        echo "\n=== Search Audios ===\n";
        $results = $api->searchAudios('imagine dragons');
        print_r($results);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Search for clips
    try {
        echo "\n=== Search Clips ===\n";
        $results = $api->searchClips('real estate');
        print_r($results);

        // Example with pagination
        if (isset($results['reels_max_id'])) {
            echo "\n=== Search Clips (Page 2) ===\n";
            $max_id = $results['reels_max_id'];
            $nextPageResults = $api->searchClips('real estate', $max_id);
            print_r($nextPageResults);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // ===== USER METHODS =====

    // Get user web profile information by username
    try {
        echo "\n=== Get Web Profile Info ===\n";
        $username = 'kyliejenner';
        $results = $api->getWebProfileInfo($username);
        print_r($results);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Get user information by ID
    try {
        echo "\n=== Get User Info By ID ===\n";
        $user_id = '25025320'; // Example user ID
        $results = $api->getUserInfoById($user_id);
        print_r($results);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Get user media by ID
    try {
        echo "\n=== Get User Media ===\n";
        $user_id = '25025320'; // Example user ID
        $count = 12;
        $results = $api->getUserMedia($user_id, $count);
        print_r($results);

        // Example with pagination
        if (isset($results['next_max_id'])) {
            echo "\n=== Get User Media (Page 2) ===\n";
            $max_id = $results['next_max_id'];
            $nextPageResults = $api->getUserMedia($user_id, $count, $max_id);
            print_r($nextPageResults);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Get user media by username
    try {
        echo "\n=== Get User Media By Username ===\n";
        $username = 'kyliejenner';
        $count = 12;
        $results = $api->getUserMediaByUsername($username, $count);
        print_r($results);

        // Example with pagination
        if (isset($results['next_max_id'])) {
            echo "\n=== Get User Media By Username (Page 2) ===\n";
            $max_id = $results['next_max_id'];
            $nextPageResults = $api->getUserMediaByUsername($username, $count, $max_id);
            print_r($nextPageResults);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Get user clips by ID
    try {
        echo "\n=== Get User Clips ===\n";
        $user_id = '25025320'; // Example user ID
        $count = 12;
        $results = $api->getUserClips($user_id, $count);
        print_r($results);

        // Example with pagination
        if (isset($results['next_max_id'])) {
            echo "\n=== Get User Clips (Page 2) ===\n";
            $max_id = $results['next_max_id'];
            $nextPageResults = $api->getUserClips($user_id, $count, $max_id);
            print_r($nextPageResults);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Get user tags
    try {
        echo "\n=== Get User Tags ===\n";
        $user_id = '25025320'; // Example user ID
        $count = 12;
        $results = $api->getUserTags($user_id, $count);
        print_r($results);

        // Example with pagination
        if (isset($results['next_max_id'])) {
            echo "\n=== Get User Tags (Page 2) ===\n";
            $max_id = $results['next_max_id'];
            $nextPageResults = $api->getUserTags($user_id, $count, $max_id);
            print_r($nextPageResults);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Get user following
    try {
        echo "\n=== Get User Following ===\n";
        $user_id = '25025320'; // Example user ID
        $count = 12;
        $results = $api->getUserFollowing($user_id, $count);
        print_r($results);

        // Example with pagination
        if (isset($results['next_max_id'])) {
            echo "\n=== Get User Following (Page 2) ===\n";
            $max_id = $results['next_max_id'];
            $nextPageResults = $api->getUserFollowing($user_id, $count, $max_id);
            print_r($nextPageResults);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Search user following by query
    try {
        echo "\n=== Search User Following ===\n";
        $user_id = '25025320'; // Example user ID
        $query = 'john';
        $results = $api->searchUserFollowing($user_id, $query);
        print_r($results);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Get user followers
    try {
        echo "\n=== Get User Followers ===\n";
        $user_id = '25025320'; // Example user ID
        $count = 12;
        $results = $api->getUserFollowers($user_id, $count);
        print_r($results);

        // Example with pagination
        if (isset($results['next_max_id'])) {
            echo "\n=== Get User Followers (Page 2) ===\n";
            $max_id = $results['next_max_id'];
            $nextPageResults = $api->getUserFollowers($user_id, $count, $max_id);
            print_r($nextPageResults);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Search user followers by query
    try {
        echo "\n=== Search User Followers ===\n";
        $user_id = '25025320'; // Example user ID
        $query = 'john';
        $results = $api->searchUserFollowers($user_id, $query);
        print_r($results);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Get user stories
    try {
        echo "\n=== Get User Stories ===\n";
        $user_id = '25025320'; // Example user ID
        $results = $api->getUserStories($user_id);
        print_r($results);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Get stories for multiple users at once
    try {
        echo "\n=== Get User Stories Bulk ===\n";
        $user_ids = ['25025320', '18428658']; // Example user IDs
        $results = $api->getUserStoriesBulk($user_ids);
        print_r($results);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Get user highlights
    try {
        echo "\n=== Get User Highlights ===\n";
        $user_id = '25025320'; // Example user ID
        $results = $api->getUserHighlights($user_id);
        print_r($results);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Get user live info
    try {
        echo "\n=== Get User Live ===\n";
        $user_id = '25025320'; // Example user ID
        $results = $api->getUserLive($user_id);
        print_r($results);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Get similar accounts to user
    try {
        echo "\n=== Get User Similar Accounts ===\n";
        $user_id = '25025320'; // Example user ID
        $results = $api->getUserSimilarAccounts($user_id);
        print_r($results);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Get user about info
    try {
        echo "\n=== Get User About ===\n";
        $user_id = '25025320'; // Example user ID
        $results = $api->getUserAbout($user_id);
        print_r($results);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // ===== MEDIA METHODS =====

    // Get media info by ID
    try {
        echo "\n=== Get Media Info ===\n";
        $media_id = '3615001108693103689'; // Example media ID
        $results = $api->getMediaInfo($media_id);
        print_r($results);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Get media info by shortcode
    try {
        echo "\n=== Get Media Info By Shortcode ===\n";
        $shortcode = 'DIrEFryS7RJ'; // Example shortcode
        $results = $api->getMediaInfoByShortcode($shortcode);
        print_r($results);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Get media likes by shortcode
    try {
        echo "\n=== Get Media Likes By Shortcode ===\n";
        $shortcode = 'DIrEFryS7RJ'; // Example shortcode
        $results = $api->getMediaLikesByShortcode($shortcode);
        print_r($results);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Get media likes by ID
    try {
        echo "\n=== Get Media Likes By ID ===\n";
        $media_id = '3615001108693103689'; // Example media ID
        $results = $api->getMediaLikesById($media_id);
        print_r($results);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Get media comments
    try {
        echo "\n=== Get Media Comments ===\n";
        $media_id = '3615001108693103689'; // Example media ID
        $can_support_threading = true;
        $results = $api->getMediaComments($media_id, $can_support_threading);
        print_r($results);

        // Example with pagination
        if (isset($results['min_id'])) {
            echo "\n=== Get Media Comments (Page 2) ===\n";
            $min_id = $results['min_id'];
            $nextPageResults = $api->getMediaComments($media_id, $can_support_threading, $min_id);
            print_r($nextPageResults);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Get media shortcode by ID
    try {
        echo "\n=== Get Media Shortcode By ID ===\n";
        $media_id = '3615001108693103689'; // Example media ID
        $results = $api->getMediaShortcodeById($media_id);
        print_r($results);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Get media ID by shortcode
    try {
        echo "\n=== Get Media ID By Shortcode ===\n";
        $shortcode = 'DIrEFryS7RJ'; // Example shortcode
        $results = $api->getMediaIdByShortcode($shortcode);
        print_r($results);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Get media ID by share code
    try {
        echo "\n=== Get Media ID By Share ===\n";
        $share_code = '_sXbUiogP'; // Example share code
        $results = $api->getMediaIdByShare($share_code);
        print_r($results);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // ===== HASHTAG, LOCATION, GUIDE METHODS =====

    // Get hashtag info
    try {
        echo "\n=== Get Hashtag Info ===\n";
        $hashtag = 'travel'; // Example hashtag (without #)
        $results = $api->getHashtagInfo($hashtag);
        print_r($results);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Get hashtag media
    try {
        echo "\n=== Get Hashtag Media ===\n";
        $hashtag = 'travel'; // Example hashtag (without #)
        $page = null;
        $max_id = null;
        $tab = 'recent'; // Options: recent, top, clips
        $results = $api->getHashtagMedia($hashtag, $page, $max_id, $tab);
        print_r($results);

        // Example with pagination
        if (isset($results['next_page']) && isset($results['next_max_id'])) {
            echo "\n=== Get Hashtag Media (Page 2) ===\n";
            $next_page = $results['next_page'];
            $next_max_id = $results['next_max_id'];
            $nextPageResults = $api->getHashtagMedia($hashtag, $next_page, $next_max_id, $tab);
            print_r($nextPageResults);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Get location info
    try {
        echo "\n=== Get Location Info ===\n";
        $location_id = '212988663'; // Example location id
        $results = $api->getLocationInfo($location_id);
        print_r($results);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Get location media
    try {
        echo "\n=== Get Location Media ===\n";
        $location_id = '212988663'; // Example location id
        $page = null;
        $max_id = null;
        $tab = 'recent'; // Options: recent, top
        $results = $api->getLocationMedia($location_id, $page, $max_id, $tab);
        print_r($results);

        // Example with pagination
        if (isset($results['next_page']) && isset($results['next_max_id'])) {
            echo "\n=== Get Location Media (Page 2) ===\n";
            $next_page = $results['next_page'];
            $next_max_id = $results['next_max_id'];
            $nextPageResults = $api->getLocationMedia($location_id, $next_page, $next_max_id, $tab);
            print_r($nextPageResults);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // ===== HIGHLIGHT, COMMENT, AUDIO METHODS =====

    // Get highlight stories (note: requires a valid highlight ID)
    try {
        echo "\n=== Get Highlight Stories ===\n";
        $highlight_id = '17946349633565357'; // Example highlight ID - you need to get this from getUserHighlights
        $results = $api->getHighlightStories($highlight_id);
        print_r($results);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Get multiple highlights at once
    try {
        echo "\n=== Get Highlight Stories Bulk ===\n";
        $highlight_ids = ['17946349633565357', '17873483110906121']; // Example highlight IDs
        $results = $api->getHighlightStoriesBulk($highlight_ids);
        print_r($results);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Get comment likes
    try {
        echo "\n=== Get Comment Likes ===\n";
        $comment_id = '18098497840546757'; // Example comment ID
        $results = $api->getCommentLikes($comment_id);
        print_r($results);

        // Example with pagination
        if (isset($results['next_max_id'])) {
            echo "\n=== Get Comment Likes (Page 2) ===\n";
            $next_max_id = $results['next_max_id'];
            $nextPageResults = $api->getCommentLikes($comment_id, $next_max_id);
            print_r($nextPageResults);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Get comment replies
    try {
        echo "\n=== Get Comment Replies ===\n";
        $comment_id = '18098497840546757'; // Example comment ID
        $media_id = '3615001108693103689'; // Example media ID
        $results = $api->getCommentReplies($comment_id, $media_id);
        print_r($results);

        // Example with pagination
        if (isset($results['next_max_child_cursor'])) {
            echo "\n=== Get Comment Replies (Page 2) ===\n";
            $next_max_child_cursor = $results['next_max_child_cursor'];
            $nextPageResults = $api->getCommentReplies($comment_id, $media_id, $next_max_child_cursor);
            print_r($nextPageResults);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Get audio media
    try {
        echo "\n=== Get Audio Media ===\n";
        $audio_id = '953905166868649'; // Example audio ID
        $results = $api->getAudioMedia($audio_id);
        print_r($results);

        // Example with pagination
        if (isset($results['next_max_id'])) {
            echo "\n=== Get Audio Media (Page 2) ===\n";
            $next_max_id = $results['next_max_id'];
            $nextPageResults = $api->getAudioMedia($audio_id, $next_max_id);
            print_r($nextPageResults);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Get audio media by canonical id
    try {
        echo "\n=== Get Audio Media By Canonical ID ===\n";
        $audio_canonical_id = '18332183866113637'; // Example canonical ID
        $results = $api->getAudioMediaByCanonicalId($audio_canonical_id);
        print_r($results);

        // Example with pagination
        if (isset($results['next_max_id'])) {
            echo "\n=== Get Audio Media By Canonical ID (Page 2) ===\n";
            $next_max_id = $results['next_max_id'];
            $nextPageResults = $api->getAudioMediaByCanonicalId($audio_canonical_id, $next_max_id);
            print_r($nextPageResults);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    // Get live info (note: requires a valid broadcast id)
    try {
        echo "\n=== Get Live Info ===\n";
        $broadcast_id = '18033634542295083'; // Example broadcast id
        $results = $api->getLiveInfo($broadcast_id);
        print_r($results);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
