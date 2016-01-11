<?php
return [ 

    /*
    |--------------------------------------------------------------------------
    | oAuth Config
    |--------------------------------------------------------------------------
    */

    /**
     * Storage
     */
    'storage' => 'Session', 

    /**
     * Consumers
     */
    'consumers' => [

        'Google' => [
		    'client_id'     => '1098774181169-98m7i4ue1eimq7s2ucg47e72hbhna6mo.apps.googleusercontent.com',
		    'client_secret' => 'xZTyRJngO2ShQvKR4YnOMtas',
		    'scope'         => ['userinfo_email','analytics_read_only','analytics'],
		]

    ]

];