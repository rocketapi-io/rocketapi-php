<?php
    namespace RocketAPI;

    class InstagramAPI extends RocketAPI {
        public function __construct($token)
        {
            parent::__construct($token, true);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        protected function request($method, $data)
        {
            $response = parent::request($method, $data);
            if ($response['status'] == 'done') {
                if (in_array($method, ['instagram/media/get_shortcode_by_id', 'instagram/media/get_id_by_shortcode'])) {
                    return $response;
                }

                if ($response['response']['status_code'] == 200 && $response['response']['content_type'] == 'application/json') {
                    return $response['response']['body'];
                } else if ($response['response']['status_code'] == 404) {
                    throw new Exceptions\NotFoundException('Instagram resource not found');
                } else {
                    throw new Exceptions\BadResponseException('Bad response from Instagram');
                }
            } else {
                throw new Exceptions\BadResponseException('Bad response from RocketAPI');
            }
        }

        /**
         * Search for users, hashtags, and locations by query.
         *
         * @param string $query The search query
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * As of September 2024, we no longer recommend using this method, as it now only returns a maximum of 5 users and leaves the places and hashtags arrays empty. Instead, please use the following separate methods:
         * - searchUsers
         * - searchHashtags
         * - searchLocations
         * - searchAudios
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/search
         */
        public function search($query) {
            return $this->request('instagram/search', [
                'query' => $query,
            ]);
        }

        /**
         * Retrieve user web profile information by username.
         *
         * @param string $username Username
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/user/get_web_profile_info
         */
        public function getWebProfileInfo($username) {
            return $this->request('instagram/user/get_web_profile_info', [
                'username' => $username,
            ]);
        }

        /**
         * Retrieve user web profile information by username.
         *
         * This is an alias for getWebProfileInfo to maintain backward compatibility.
         *
         * @param string $username Username
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/user/get_web_profile_info
         */
        public function getUserInfo($username) {
            return $this->getWebProfileInfo($username);
        }

        /**
         * Retrieve user information by id.
         *
         * @param int $user_id User id
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/user/get_info_by_id
         */
        public function getUserInfoById($user_id) {
            return $this->request('instagram/user/get_info_by_id', [
                'id' => $user_id,
            ]);
        }

        /**
         * Retrieve user media by id.
         *
         * @param int $user_id User id
         * @param int $count Number of media to retrieve (max: 12)
         * @param string|null $max_id Use for pagination
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * You can use the `max_id` parameter to paginate through the media (take from the `next_max_id` field of the response).
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/user/get_media
         */
        public function getUserMedia($user_id, $count=12, $max_id=null) {
            $payload = ['id' => $user_id, 'count' => $count];
            if ($max_id) {
                $payload['max_id'] = $max_id;
            }
            return $this->request('instagram/user/get_media', $payload);
        }

        /**
         * Retrieve user media by username.
         *
         * @param string $username Username
         * @param int $count Number of media to retrieve (max: 12)
         * @param string|null $max_id Use for pagination
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * You can use the `max_id` parameter to paginate through the media (take from the `next_max_id` field of the response).
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/user/get_media_by_username
         */
        public function getUserMediaByUsername($username, $count=12, $max_id=null) {
            $payload = ['username' => $username, 'count' => $count];
            if ($max_id) {
                $payload['max_id'] = $max_id;
            }
            return $this->request('instagram/user/get_media_by_username', $payload);
        }

        /**
         * Retrieve user clips by id.
         *
         * @param int $user_id User id
         * @param int $count Number of clips to retrieve (max: 12)
         * @param string|null $max_id Use for pagination
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * You can use the `max_id` parameter to paginate through the clips (take from the `max_id` field of the response).
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/user/get_clips
         */
        public function getUserClips($user_id, $count=12, $max_id=null) {
            $payload = ['id' => $user_id, 'count' => $count];
            if ($max_id) {
                $payload['max_id'] = $max_id;
            }
            return $this->request('instagram/user/get_clips', $payload);
        }

        /**
         * Retrieve user guides by id.
         *
         * @param int $user_id User id
         * @param string|null $max_id Use for pagination
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * You can use the `max_id` parameter to paginate through the guides (take from the `next_max_id` field of the response).
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/user/get_guides
         */
        public function getUserGuides($user_id, $max_id=null) {
            $payload = ['id' => $user_id];
            if ($max_id) {
                $payload['max_id'] = $max_id;
            }
            return $this->request('instagram/user/get_guides', $payload);
        }

        /**
         * Retrieve media where user is tagged.
         *
         * @param int $user_id User id
         * @param int $count Number of tagged media to retrieve (max: 12)
         * @param string|null $max_id Use for pagination
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * You can use the `max_id` parameter to paginate through the tagged media (take from the end_cursor field of the response).
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/user/get_tags
         */
        public function getUserTags($user_id, $count=12, $max_id=null) {
            $payload = ['id' => $user_id, 'count' => $count];
            if ($max_id) {
                $payload['max_id'] = $max_id;
            }
            return $this->request('instagram/user/get_tags', $payload);
        }

        /**
         * Retrieve list of users that a specific user is following.
         *
         * @param int $user_id User id
         * @param int $count Number of followings to retrieve (max: 12)
         * @param string|null $max_id Use for pagination
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * You can use the `max_id` parameter to paginate through the following list (take from the `next_max_id` field of the response).
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/user/get_following
         */
        public function getUserFollowing($user_id, $count=12, $max_id=null) {
            $payload = ['id' => $user_id, 'count' => $count];
            if ($max_id) {
                $payload['max_id'] = $max_id;
            }
            return $this->request('instagram/user/get_following', $payload);
        }

        /**
         * Retrieve list of users that follow a specific user.
         *
         * @param int $user_id User id
         * @param int $count Number of followers to retrieve (max: 12)
         * @param string|null $max_id Use for pagination
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * You can use the `max_id` parameter to paginate through the followers list (take from the `next_max_id` field of the response).
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/user/get_followers
         */
        public function getUserFollowers($user_id, $count=12, $max_id=null)
        {
            $payload = ['id' => $user_id, 'count' => $count];
            if ($max_id) {
                $payload['max_id'] = $max_id;
            }
            return $this->request('instagram/user/get_followers', $payload);
        }

        /**
         * Search for specific followers of a user by query.
         *
         * @param int $user_id User id
         * @param string $query The search query
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/user/get_followers
         */
        public function searchUserFollowers($user_id, $query) {
            return $this->request('instagram/user/get_followers', [
                'id' => $user_id,
                'query' => $query,
            ]);
        }

        /**
         * Search for specific following of a user by query.
         *
         * @param int $user_id User id
         * @param string $query The search query
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/user/get_following
         */
        public function searchUserFollowing($user_id, $query) {
            return $this->request('instagram/user/get_following', [
                'id' => $user_id,
                'query' => $query,
            ]);
        }

        /**
         * Retrieve stories for multiple users at once.
         *
         * @param array $user_ids Array of user IDs
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/user/get_stories
         */
        public function getUserStoriesBulk($user_ids) {
            return $this->request('instagram/user/get_stories', [
                'ids' => $user_ids,
            ]);
        }

        /**
         * Retrieve stories for a single user.
         *
         * @param int $user_id User ID
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/user/get_stories
         */
        public function getUserStories($user_id) {
            return $this->getUserStoriesBulk([$user_id]);
        }

        /**
         * Retrieve highlights for a user profile.
         *
         * @param int $user_id User ID
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/user/get_highlights
         */
        public function getUserHighlights($user_id) {
            return $this->request('instagram/user/get_highlights', [
                'id' => $user_id,
            ]);
        }

        /**
         * Retrieve information about user's live broadcast if available.
         *
         * @param int $user_id User ID
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/user/get_live
         */
        public function getUserLive($user_id) {
            return $this->request('instagram/user/get_live', [
                'id' => $user_id,
            ]);
        }

        /**
         * Retrieve similar accounts to a specific user.
         *
         * @param int $user_id User ID
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/user/get_similar_accounts
         */
        public function getUserSimilarAccounts($user_id) {
            return $this->request('instagram/user/get_similar_accounts', [
                'id' => $user_id,
            ]);
        }

        /**
         * Retrieve media information by ID.
         *
         * @param string $media_id Media ID
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/media/get_info
         */
        public function getMediaInfo($media_id) {
            return $this->request('instagram/media/get_info', [
                'id' => $media_id,
            ]);
        }

        /**
         * Retrieve media information by shortcode.
         *
         * @param string $shortcode Media shortcode
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/media/get_info_by_shortcode
         */
        public function getMediaInfoByShortcode($shortcode) {
            return $this->request('instagram/media/get_info_by_shortcode', [
                'shortcode' => $shortcode,
            ]);
        }

        /**
         * Retrieve media likes by shortcode.
         *
         * @param string $shortcode Media shortcode
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/media/get_likes
         */
        public function getMediaLikesByShortcode($shortcode) {
            return $this->request('instagram/media/get_likes_by_shortcode', [
                'shortcode' => $shortcode,
            ]);
        }

        /**
         * Retrieve media likes by shortcode.
         *
         * This is an alias for getMediaLikesByShortcode to maintain backward compatibility.
         * This endpoint does not support pagination (`count` and `max_id` are deprecated).
         *
         * @param string $shortcode Media shortcode
         * @param int $count Number of likes to retrieve (max: 12)
         * @param string|null $max_id Use for pagination
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/media/get_likes
         */
        public function getMediaLikes($shortcode, $count=12, $max_id=null) {
            return $this->getMediaLikesByShortcode($shortcode);
        }

        /**
         * Retrieve media likes by id.
         *
         * This endpoint does not support pagination
         *
         * @param string $media_id Media ID
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/media/get_likes_by_id
         */
        public function getMediaLikesById($media_id) {
            return $this->request('instagram/media/get_likes_by_id', [
                'id' => $media_id,
            ]);
        }

        /**
         * Retrieve comments for a specific media.
         *
         * @param string $media_id Media ID
         * @param bool $can_support_threading Whether threading is supported
         * @param string|null $min_id Use for pagination
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/media/get_comments
         */
        public function getMediaComments($media_id, $can_support_threading=true, $min_id=null) {
            $payload = ['id' => $media_id, 'can_support_threading' => $can_support_threading];
            if ($min_id) {
                $payload['min_id'] = $min_id;
            }
            return $this->request('instagram/media/get_comments', $payload);
        }

        /**
         * Retrieve media shortcode by ID.
         *
         * @param string $media_id Media ID
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/media/get_shortcode_by_id
         */
        public function getMediaShortcodeById($media_id) {
            return $this->request('instagram/media/get_shortcode_by_id', [
                'id' => $media_id,
            ]);
        }

        /**
         * Retrieve media ID by shortcode.
         *
         * @param string $shortcode Media shortcode
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/media/get_id_by_shortcode
         */
        public function getMediaIdByShortcode($shortcode) {
            return $this->request('instagram/media/get_id_by_shortcode', [
                'shortcode' => $shortcode,
            ]);
        }


        /**
         * Retrieve media id by share code (for links like `https://www.instagram.com/share/BA384x3Dn6`)
         *
         * @param string $share Share code
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/media/get_id_by_share
         */
        public function getMediaIdByShare($share) {
            return $this->request('instagram/media/get_id_by_share', [
                'share' => $share,
            ]);
        }

        /**
         * Retrieve guide information by id.
         *
         * @param string $guide_id Guide id
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/guide/get_info
         */
        public function getGuideInfo($guide_id) {
            return $this->request('instagram/guide/get_info', [
                'id' => $guide_id,
            ]);
        }

        /**
         * Retrieve location information by id.
         *
         * @param string $location_id Location id
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/location/get_info
         */
        public function getLocationInfo($location_id) {
            return $this->request('instagram/location/get_info', [
                'id' => $location_id,
            ]);
        }

        /**
         * Retrieve media from a specific location.
         *
         * @param string $location_id Location id
         * @param string|null $page Use for pagination
         * @param string|null $max_id Use for pagination
         * @param string|null $tab Tab (allowed values: recent, top)
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * You can use both the `page` and `max_id` parameters to paginate through the media.
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/location/get_media
         */
        public function getLocationMedia($location_id, $page=null, $max_id=null, $tab=null) {
            $payload = ['id' => $location_id];
            if ($page) {
                $payload['page'] = $page;
            }
            if ($max_id) {
                $payload['max_id'] = $max_id;
            }
            if ($tab) {
                $payload['tab'] = $tab;
            }
            return $this->request('instagram/location/get_media', $payload);
        }

        /**
         * Retrieve hashtag information by name.
         *
         * @param string $name Hashtag name (without #)
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/hashtag/get_info
         */
        public function getHashtagInfo($name) {
            return $this->request('instagram/hashtag/get_info', [
                'name' => $name,
            ]);
        }

        /**
         * Retrieve hashtag media by hashtag name.
         *
         * @param string $name Hashtag name
         * @param string|null $page Use for pagination
         * @param string|null $max_id Use for pagination
         * @param string $tab Tab (allowed values: recent, top or clips)
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/hashtag/get_media
         */
        public function getHashtagMedia($name, $page=null, $max_id=null, $tab=null) {
            $payload = ['name' => $name];
            if ($page) {
                $payload['page'] = $page;
            }
            if ($max_id) {
                $payload['max_id'] = $max_id;
            }
            if ($tab) {
                $payload['tab'] = $tab;
            }
            return $this->request('instagram/hashtag/get_media', $payload);
        }

        /**
         * Retrieve stories from multiple highlights at once.
         *
         * @param array $highlight_ids Array of highlight IDs
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/highlight/get_stories
         */
        public function getHighlightStoriesBulk($highlight_ids) {
            return $this->request('instagram/highlight/get_stories', [
                'ids' => $highlight_ids,
            ]);
        }

        /**
         * Retrieve stories from a single highlight.
         *
         * @param string $highlight_id Highlight ID
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/highlight/get_stories
         */
        public function getHighlightStories($highlight_id) {
            return $this->getHighlightStoriesBulk([$highlight_id]);
        }

        /**
         * Retrieve likes for a specific comment.
         *
         * @param string $comment_id Comment id
         * @param string|null $max_id Use for pagination
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * You can use the `max_id` parameter to paginate through the likes (take from the `next_max_id` field of the response).
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/comment/get_likes
         */
        public function getCommentLikes($comment_id, $max_id=null) {
            $payload = ['id' => $comment_id];
            if ($max_id) {
                $payload['max_id'] = $max_id;
            }
            return $this->request('instagram/comment/get_likes', $payload);
        }

        /**
         * Retrieve replies to a specific comment.
         *
         * @param string $comment_id Comment id
         * @param string $media_id Media id
         * @param string|null $max_id Use for pagination
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * You can use the `max_id` parameter to paginate through the replies (take from the `next_max_child_cursor` field of the response).
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/comment/get_replies
         */
        public function getCommentReplies($comment_id, $media_id, $max_id=null) {
            $payload = ['id' => $comment_id, 'media_id' => $media_id];
            if ($max_id) {
                $payload['max_id'] = $max_id;
            }
            return $this->request('instagram/comment/get_replies', $payload);
        }

        /**
         * Retrieve media using a specific audio track.
         *
         * @param string $audio_id Audio id
         * @param string|null $max_id Use for pagination
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * You can use the `max_id` parameter to paginate through the media (take from the next_max_id field of the response).
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/audio/get_media
         */
        public function getAudioMedia($audio_id, $max_id=null) {
            $payload = ['id' => $audio_id];
            if ($max_id) {
                $payload['max_id'] = $max_id;
            }
            return $this->request('instagram/audio/get_media', $payload);
        }

        /**
         * Retrieve media using a specific audio track by canonical id.
         *
         * @param string $audio_canonical_id Audio canonical id
         * @param string|null $max_id Use for pagination
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * You can use the `max_id` parameter to paginate through the media (take from the `next_max_id` field of the response).
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/audio/get_media_by_canonical_id
         */
        public function getAudioMediaByCanonicalId($audio_canonical_id, $max_id=null) {
            $payload = ['id' => $audio_canonical_id];
            if ($max_id) {
                $payload['max_id'] = $max_id;
            }
            return $this->request('instagram/audio/get_media_by_canonical_id', $payload);
        }

        /**
         * Retrieve information about a live broadcast.
         *
         * @param string $broadcast_id Broadcast id
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/live/get_info
         */
        public function getLiveInfo($broadcast_id) {
            return $this->request('instagram/live/get_info', [
                'id' => $broadcast_id,
            ]);
        }

        /**
         * Retrieve about information for a user.
         *
         * @param int $user_id User ID
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/user/get_about
         */
        public function getUserAbout($user_id) {
            return $this->request('instagram/user/get_about', [
                'id' => $user_id,
            ]);
        }

        /**
         * Search for users by query.
         *
         * @param string $query The search query
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/user/search
         */
        public function searchUsers($query) {
            return $this->request('instagram/user/search', [
                'query' => $query,
            ]);
        }

        /**
         * Search for hashtags by query.
         *
         * @param string $query The search query
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/hashtag/search
         */
        public function searchHashtags($query) {
            return $this->request('instagram/hashtag/search', [
                'query' => $query,
            ]);
        }

        /**
         * Search for locations by query.
         *
         * @param string $query The search query
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/location/search
         */
        public function searchLocations($query) {
            return $this->request('instagram/location/search', [
                'query' => $query,
            ]);
        }

        /**
         * Search for audio tracks by query.
         *
         * @param string $query The search query
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/audio/search
         */
        public function searchAudios($query) {
            return $this->request('instagram/audio/search', [
                'query' => $query,
            ]);
        }


        /**
         * Search for a specific clip with a caption that includes the query.
         *
         * @param string $query The search query
         * @param string|null $max_id Use for pagination
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         *
         * For more information, see documentation: https://docs.rocketapi.io/api/instagram/media/search_clips
         */
        public function searchClips($query, $max_id=null) {
            $payload = ['query' => $query];
            if ($max_id) {
                $payload['max_id'] = $max_id;
            }
            return $this->request('instagram/media/search_clips', $payload);
        }
    }
