<?php return
[
	'forms' =>
	[
		'login' => 11,

		'email_verifcation' => 12,
	],

	'delay_threshold' =>
	[
		6 => 2, // 2 sec on 6 failed attempts

		12 => 3, // 3 sec on 12 failed attempts

		20 => 5,

		50 => 6,

		100 => 10,

		200 => 20, // 20 sec on 200 failed attempts
	],
];
