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
        public function getMediaInfo($media_id) {
            return $this->request('instagram/media/get_info', [
                'id' => $media_id,
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
        public function getCommentLikes($comment_id, $max_id=null) {
            $payload = ['id' => $comment_id];
            if ($max_id) {
                $payload['max_id'] = $max_id;
            }
            return $this->request('instagram/comment/get_likes', $payload);
        }
    }