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

            }
        }
    }
    

?>