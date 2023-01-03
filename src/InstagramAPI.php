<?php
    namespace RocketAPI;

    class InstagramAPI extends RocketAPI {
        public function __construct($token)
        {
            parent::__construct($token);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        protected function request($method, $data)
        {
            $response = parent::request($method, $data);
            if ($response['status'] == 'done') {
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
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function search($query) {
            return $this->request('instagram/search', [
                'query' => $query,
            ]);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getUserInfo($username) {
            return $this->request('instagram/user/get_info', [
                'username' => $username,
            ]);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getUserInfoById($user_id) {
            return $this->request('instagram/user/get_info_by_id', [
                'id' => $user_id,
            ]);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getUserMedia($user_id, $count=12, $max_id=null) {
            $payload = ['id' => $user_id, 'count' => $count];
            if ($max_id) {
                $payload['max_id'] = $max_id;
            }
            return $this->request('instagram/user/get_media', $payload);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getUserClips($user_id, $max_id=null) {
            $payload = ['id' => $user_id];
            if ($max_id) {
                $payload['max_id'] = $max_id;
            }
            return $this->request('instagram/user/get_clips', $payload);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getUserGuides($user_id, $max_id=null) {
            $payload = ['id' => $user_id];
            if ($max_id) {
                $payload['max_id'] = $max_id;
            }
            return $this->request('instagram/user/get_guides', $payload);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getUserTags($user_id, $count=12, $max_id=null) {
            $payload = ['id' => $user_id, 'count' => $count];
            if ($max_id) {
                $payload['max_id'] = $max_id;
            }
            return $this->request('instagram/user/get_tags', $payload);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getUserFollowing($user_id, $count=12, $max_id=null) {
            $payload = ['id' => $user_id, 'count' => $count];
            if ($max_id) {
                $payload['max_id'] = $max_id;
            }
            return $this->request('instagram/user/get_following', $payload);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
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
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function searchUserFollowers($user_id, $query) {
            return $this->request('instagram/user/get_followers', [
                'id' => $user_id,
                'query' => $query,
            ]);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getUserStoriesBulk($user_ids) {
            return $this->request('instagram/user/get_stories', [
                'ids' => $user_ids,
            ]);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getUserStories($user_id) {
            return $this->getUserStoriesBulk([$user_id]);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getUserHighlights($user_id) {
            return $this->request('instagram/user/get_highlights', [
                'id' => $user_id,
            ]);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getUserLive($user_id) {
            return $this->request('instagram/user/get_live', [
                'id' => $user_id,
            ]);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getUserSimilarAccounts($user_id) {
            return $this->request('instagram/user/get_similar_accounts', [
                'id' => $user_id,
            ]);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getMediaInfo($media_id) {
            return $this->request('instagram/media/get_info', [
                'id' => $media_id,
            ]);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getMediaInfoByShortcode($shortcode) {
            return $this->request('instagram/media/get_info_by_shortcode', [
                'shortcode' => $shortcode,
            ]);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getMediaLikes($shortcode, $count=12, $max_id=null) {
            $payload = ['shortcode' => $shortcode, 'count' => $count];
            if ($max_id) {
                $payload['max_id'] = $max_id;
            }
            return $this->request('instagram/media/get_likes', $payload);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getMediaComments($media_id, $can_support_threading=true, $min_id=null) {
            $payload = ['id' => $media_id, 'can_support_threading' => $can_support_threading];
            if ($min_id) {
                $payload['min_id'] = $min_id;
            }
            return $this->request('instagram/media/get_comments', $payload);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getMediaShortcodeById($media_id) {
            return $this->request('instagram/media/get_shortcode_by_id', [
                'id' => $media_id,
            ]);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getMediaIdByShortcode($shortcode) {
            return $this->request('instagram/media/get_id_by_shortcode', [
                'shortcode' => $shortcode,
            ]);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getGuideInfo($guide_id) {
            return $this->request('instagram/guide/get_info', [
                'id' => $guide_id,
            ]);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getLocationInfo($location_id) {
            return $this->request('instagram/location/get_info', [
                'id' => $location_id,
            ]);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getLocationMedia($location_id, $page=null, $max_id=null) {
            $payload = ['id' => $location_id];
            if ($page) {
                $payload['page'] = $page;
            }
            if ($max_id) {
                $payload['max_id'] = $max_id;
            }
            return $this->request('instagram/location/get_media', $payload);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getHashtagInfo($name) {
            return $this->request('instagram/hashtag/get_info', [
                'name' => $name,
            ]);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getHashtagMedia($name, $page=null, $max_id=null) {
            $payload = ['name' => $name];
            if ($page) {
                $payload['page'] = $page;
            }
            if ($max_id) {
                $payload['max_id'] = $max_id;
            }
            return $this->request('instagram/hashtag/get_media', $payload);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getHighlightStoriesBulk($highlight_ids) {
            return $this->request('instagram/highlight/get_stories', [
                'ids' => $highlight_ids,
            ]);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getHighlightStories($highlight_id) {
            return $this->getHighlightStoriesBulk([$highlight_id]);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getCommentLikes($comment_id, $max_id=null) {
            $payload = ['id' => $comment_id];
            if ($max_id) {
                $payload['max_id'] = $max_id;
            }
            return $this->request('instagram/comment/get_likes', $payload);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getAudioMedia($audio_id, $max_id=null) {
            $payload = ['id' => $audio_id];
            if ($max_id) {
                $payload['max_id'] = $max_id;
            }
            return $this->request('instagram/audio/get_media', $payload);
        }
    }
