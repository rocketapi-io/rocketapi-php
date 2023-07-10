<?php
    require('src/RocketAPI.php');
    require('src/Exceptions/NotFoundException.php');
    require('src/Exceptions/BadResponseException.php');
    require('src/ThreadsAPI.php');

    use RocketAPI\ThreadsAPI;

    $api = new ThreadsAPI("put your token here");

    // Get user feed by user id
    $user_id = 35670846775;
    try {
        $user = $api->getUserFeed($user_id);
        print_r($user);
    } catch (RocketAPI\Exceptions\NotFoundException $e) {
        echo "User $user_id not found\n";
    } catch (RocketAPI\Exceptions\BadResponseException $e) {
        echo "Can't get $user_id feed from API\n";
    }
