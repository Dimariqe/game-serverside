<?php
return array(
	'social'=>array(
		'fb'=>array(
			'id'=>'359404394139121',
			'key'=>'6d51c6297b087e84210b28588c744ced',
			'alias'=>'shatotest',
			'swf'=>'/swf/chateau.swf'
		),
		'vk'=>array(
			'id'=>'',
			'key'=>''
		),
		'ok'=>array(
			'id'=>'',
			'key'=>''
		),
	),
	'servers' => array(
		'static'=> 'http://chateau.oskolkov.nsk.arvara.org'
	),
	'database' => array(

		'session' => array(#MongoDB
			'server' => 'localhost',
			'database' => 'session',
      'table'=> 'session'
		),
    'queue' => array(#MongoDB
      'server' => 'localhost',
      'database' => 'objects',
      'table'=> 'queue'
    ),
		'admin_session' => array(#MongoDB
				'server' => 'localhost',
				'database' => 'admin_session'
		),
    'objects' => array(#MongoDB
      'server' => 'localhost',
      'database' => 'objects'
    ),
    'user' => array(#MongoDB
      'server' => 'localhost',
      'database' => 'user',
      'table' => 'data'
    ),
		'logs' => array(#MySQL
			'server' => 'localhost',
			'database' => '.'
		),
    'payments' => array(#MySQL
      'host' => 'localhost',
      'database' => 'newshato_base',
      'user' =>'newshato',
      'password' => '45b6UwG8mxynMLL5',
    ),
		'admin' => array(#MySQL
			'host' => 'localhost',
			'database' => 'newshato_base',
			'user' =>'newshato',
			'password' => '45b6UwG8mxynMLL5',
		)
	),
	'path' => array(
		'public' => PATH_TO_GAME.'/../public'
	)
);