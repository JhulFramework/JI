<?php return
[

	'class' => '\\app\\App',

	'init' => function( $app, $config )
	{

		//loading Sesson
		$app->_s( 'session', new \Jhul\Core\Application\Session( $config['session_key_prefix'] ) ) ;

		//loading user
		$app->_s( 'user', new \app\User() );

		//creating module manager
		$app->_s( 'moduleStore', new \Jhul\Core\Application\Module\Manager() );

		return $app;
	},
];
