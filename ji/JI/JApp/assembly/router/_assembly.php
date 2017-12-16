<?php return
[
	'class'	=> '\\Jhul\\Core\\Application\\Router\\Router',

	'create'	=> function( $router, $params )
	{
		$router->add( $params['routes'] );
		return $router;
	}
];
