<?php
    require('src/RocketAPI.php');
    require('src/Exceptions.php');
    require('src/InstagramAPI.php');

    use RocketAPI\InstagramAPI;

    $api = new InstagramAPI("put your token here");

    // Get user info by username
    $username = 'kanyewest';
    try {
        $user = $api->getUserInfo($username);
        print_r($user);
    } catch (RocketAPI\NotFoundException $e) {
        echo "User $username not found\n";
    } catch (RocketAPI\BadResponseException $e) {
        echo "Can't get $username info from API\n";
    }
