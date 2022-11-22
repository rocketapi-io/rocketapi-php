<?php
    namespace RocketAPI;

    class RocketAPI {
        private $base_url = "https://v1.rocketapi.io/";
        private $token;
        private $max_timeout = 30;

        public function __construct($token) {
            $this->token = $token;
        }

        protected function request($method, $data) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->base_url . $method);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Token ' . $this->token,
                'Content-Type: application/json',
            ]);
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->max_timeout);
            $result = curl_exec($ch);
            curl_close($ch);
            return json_decode($result, true);
        }
    }
