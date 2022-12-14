<?php
/**
 * ********************************************
 *    HttpClient Class File is used to send 
 *    Http Request to Endpoints using PHP-cURL.
 *    Only GET & POST Methods are  defined
 * ********************************************
 */
    namespace HttpClient;
    
    class HttpClient
    {
        private 
            $_getParam,
            $_postParam,
            $_ch;

        /**
         * Public class default Constructor
         * 
         */
        public function __construct()
        {
            try
            {
                $this->_ch = \curl_init();
            }catch(\Exception $e){
                throw new \Exception("cURL cannot be initiated. Check if cURL is enabled.");
            }

            /**
             * If curl_init() successfully initiated
             * set cURL options
             */
            \curl_setopt($this->_ch, \CURLOPT_RETURNTRANSFER, true);
            \curl_setopt($this->_ch, \CURLOPT_ENCODING, "");
        }

        /**
         *  Function to set cURL Headers
         */
        public function setHeaders($header)
        {
            \curl_setopt($this->_ch, \CURLOPT_HTTPHEADER, $header);
        }
        public function setParams($method, $values, $json = true)
        {
            if ($method == "get") {
                $this->_getParam = $values;
            }elseif ($method == "post") {
                $this->_postParam = $values;

                \curl_setopt($this->_ch, \CURLOPT_PORT, true);
                if ($json) {
                    \curl_setopt($this->_ch, \CURLOPT_PORT, json_encode($this->_postParam));
                }else {
                    \curl_setopt($this->_ch, \CURLOPT_PORT, http_build_query($this->_postParam));
                }
            }
        }

        /**
         * Function for GET Method
         * if the 'GET' parameters are set,
         * construct GET query
         */
        public function get($url)
        {
            if(isset($this->_getParam))
                $url = $url . '?' . http_build_query($this->_getParam);

            \curl_setopt($this->_ch, \CURLOPT_URL, $url);

            $response = $this->exec();

            return $this->getResponse();
        }

        public function post($url)
        {
            \curl_setopt($this->_ch, \CURLOPT_URL, $url);
            \curl_setopt($this->_ch, \CURLOPT_CUSTOMREQUEST, "POST");

            $response = $this->exec();

            return $this->getResponse($response);
        }

        public function exec()
        {
            $response = \curl_exec($this->_ch);

            if (\curl_error($this_ch))
                throw new \RuntimeException("Api request failed: " . curl_error($this->_ch));
    
            return $response;
        }

        public function getResponse($response)
        {
            $status = \curl_getinfo($this->_ch, \CURLINFO_HTTP_CODE);

            $response1 = json_decode($response, true, 512, JSON_BIGINT_AS_STRING);

            if (($status !== 200) || ($status !== 401)) {
                throw new \Exception("Error Occured with status code(".$status.")");
            }

            return $response1;
        }

        public function __destruct()
        {
            \curl_close($this->_ch);
        }
    }
    

?>