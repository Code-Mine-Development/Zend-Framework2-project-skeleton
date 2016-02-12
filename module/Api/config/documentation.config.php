<?php
return array(

    'Api\\V1\\Rpc\\Health\\Controller' => array(
        'description' => 'Check system status',
        'GET' => array(
            'description' => 'Returns system status',
            'response' => '{
  "status": "ok"
}',
        ),
    ),

);
