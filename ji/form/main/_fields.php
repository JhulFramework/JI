<?php return
[
	'base_url' =>
	[
		'label' 	=> 'Base URL',
		'view_type' => 'editText',
		'data_type' => 'string',
		'default'	=> \JI::I()->autoBaseURL(),
	],

	'encryption_key' =>
	[
		'label' 	=> 'Encryption Key',
		'view_type' => 'editText',
		'data_type' => 'string',
	],
];
