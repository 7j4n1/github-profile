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
        }
    }
    

?>