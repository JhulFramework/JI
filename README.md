### PHP Application GUI Installer

 - A PHP library To provide GUI installer for you PHP applications
 - Easy to integrate

### Requirement

 - PHP Version >= 5.6
 - ji/\_data directory must be writable by PHP


### How to Integrate Installer in Your PHP Application

 - **Clone or download this repository**
 - **Include it in your project**
 ```php
 require( '/path/to/ji/include_me.php');

 $env = 'test' // enivoronment name, just a unique key to keep configuration seperate

 // passing third parameter true will auto run installation if not installed already
 \JI::run( __DIR__, $env, TRUE ); // It must be created in public root usually in index.php
 ```
 - **Define Required Fields**
 	- By defualt two forms named **main** and **database** are already created
	- To create new configuration fields edit jic/form/main/\_fields.php (sample fields definitions are provided in it)
	- To change form title and description edit file **_config.php**
	- By default all fields are required, To set field optional use 'data_type' => datatype?required=0
		example
		```php
		'last_name' =>
		[
			'data_type' => 'string?required=0'
		],
		```

### Creating new form
 - Create a folder "mynewform" inside jic/form/
 - Create files **_config.php** adn **_fields.php** in it, similar to form "main" and configure it
 - Add it to jic/form/\_map.php

### Access Configuration Values
 - In you configuration files to access values use
 ```php

 	'key' => \JI::I()->config('mynewform.configKey'),

	//main form configuartions can be accessed directly
	'url' => \JI::I()->config('main.url'),

	//or simply
	'url' => \JI::I()->config('url'),
 ```

### Examples
 - **_fields.php**
```php
 <?php return
 [
	'admin_email' =>
	[
		'label' 	=> 'Admin Email',
		'view_type' => 'editText',
		'data_type'	=> 'string', //required field
		'deafult'	=> 'deafult value',
	],

	'last_name' =>
	[
		'label' 	=> 'Last Name',
		'view_type' => 'editText',
		'data_type'	=> 'string?required=0', //optional field
	],

	//example of select fields
	'database_driver' =>
	[
		'label' 	=> 'Database Driver',
		'view_type'	=> 'selectOne',
		'data_type'	=> 'string',
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

 ];
```

### Currently Suported HTML Fields
- text  	= editText
- textarea 	= editTextBig
- select 	= selectOne


### NOTE
 - Actual installer is only loaded during installation, so performance should not be an issue.
 - Before passing code to client OR if you want to reinstall, delete content of directory jic/\_data
