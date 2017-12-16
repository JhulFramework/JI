<?php return
[
	'driver' =>
	[
		'label' 	=> 'Database Driver',
		'view_type' => 'selectOne',
		'data_type' => 'string',
		'options'	=>
		[
			'mysqli'	=> 'MYSQL(mysqli)',
			'mysql'	=> 'MYSQL(mysql)',
			'oci8' 	=> 'Oracle(oci8)',
			'postgre' 	=> 'PostgreSQL(postgre)',
			'cubrid'	=> 'CUBRID(cubrid)',
		],

		'selectedValue' => 'oci8',
	],

	'name' =>
	[
		'label' 	=> 'Database Name',
		'view_type' => 'editText',
		'data_type' => 'string',
	],

	'host' =>
	[
		'label' 	=> 'Host',
		'view_type' => 'editText',
		'data_type' => 'string',
		'default'	=> 'localhost'
	],

	'username' =>
	[
		'label' 	=> 'Username',
		'view_type' => 'editText',
		'data_type' => 'string',
	],

	'password' =>
	[
		'label' 	=> 'Password',
		'view_type' => 'editText',
		'data_type' => 'string',
	],

	'prefix' =>
	[
		'label' 	=> 'Databse Table Prefix',
		'view_type' => 'editText',
		'data_type' => 'string?required=0',
	],

];
