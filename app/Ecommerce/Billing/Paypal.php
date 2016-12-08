<?php
return array(
    // set your paypal credential
    'client_id' => 'ATswVJCtvlkuEUhfdpXIfFcBTn2_shQyJS9jADqK6Hjf2ZN75UXDaWbeKnsvQNtckUxREj-2c0etq-NZ',
    'secret' => 'ELADrDepz2nnGWTRFurv6Ks7osaS5Ep_6tvVDoJg77-kcBTHBQ4VMCNus5sDJO47H7_8aPnfhok11rLT',
 
    /**
     * SDK configuration 
     */
    'settings' => array(
        /**
         * Available option 'sandbox' or 'live'
         */
        'mode' => 'sandbox',
 
        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => 30,
 
        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => true,
 
        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . '/logs/paypal.log',
 
        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => 'FINE'
    ),
);
