<?php
    namespace RocketAPI;

    class ThreadsAPI extends RocketAPI
    {
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
                    throw new Exceptions\NotFoundException('Threads resource not found');
                } else {
                    throw new Exceptions\BadResponseException('Bad response from Threads');
                }
            } else {
                throw new Exceptions\BadResponseException('Bad response from RocketAPI');
            }
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function searchUsers($query, $rank_token=null, $page_token=null) {
            $payload = [
                'query' => $query,
            ];
            if ($rank_token) {
                $payload['rank_token'] = $rank_token;
            }
            if ($page_token) {
                $payload['page_token'] = $page_token;
            }
            return $this->request('threads/search_users', $payload);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getUserInfo($user_id) {
            return $this->request('threads/user/get_info', [
                'id' => $user_id,
            ]);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getUserFeed($user_id, $max_id=null) {
            $payload = [
                'id' => $user_id,
            ];
            if ($max_id) {
                $payload['max_id'] = $max_id;
            }
            return $this->request('threads/user/get_feed', $payload);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getUserReplies($user_id, $max_id=null) {
            $payload = [
                'id' => $user_id,
            ];
            if ($max_id) {
                $payload['max_id'] = $max_id;
            }
            return $this->request('threads/user/get_replies', $payload);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getUserFollowers($user_id, $max_id=null) {
            $payload = ['id' => $user_id];
            if ($max_id) {
                $payload['max_id'] = $max_id;
            }
            return $this->request('threads/user/get_followers', $payload);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getUserFollowing($user_id, $max_id=null)
        {
            $payload = ['id' => $user_id];
            if ($max_id) {
                $payload['max_id'] = $max_id;
            }
            return $this->request('threads/user/get_following', $payload);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function searchUserFollowers($user_id, $query) {
            return $this->request('threads/user/get_followers', [
                'id' => $user_id,
                'query' => $query,
            ]);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function searchUserFollowing($user_id, $query) {
            return $this->request('threads/user/get_following', [
                'id' => $user_id,
                'query' => $query,
            ]);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getThreadReplies($thread_id, $max_id=null) {
            $payload = ['id' => $thread_id];
            if ($max_id) {
                $payload['max_id'] = $max_id;
            }
            return $this->request('threads/thread/get_replies', $payload);
        }

        /**
         * @throws Exceptions\NotFoundException
         * @throws Exceptions\BadResponseException
         */
        public function getThreadLikes($thread_id) {
            $payload = ['id' => $thread_id];
            return $this->request('threads/thread/get_likes', $payload);
        }
    }
