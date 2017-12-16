<?php require_once( __DIR__.'/jhul/autoloader.php' );


function createJApp( $publicRoot )
{
	$config =
	[
		'public_root' => $publicRoot,

		//if not defined, it will auto resolve
		'base_url' => '',

		'data_store_directory_path' => __DIR__.'/_data',

		//relative to public_root
		'public_cache_directory' => 'jcache',
	];

	\Jhul::create( $config );

	//providing patt to look for compoenet component configuration //PRIMARY
	\Jhul::I()->cx()->setServerConfigPath( __DIR__.'/server' );

	//providing path to look for component configuration
	\Jhul::I()->cx()->setAppConfigPath( __DIR__.'/app/_config' ) ;

	\Jhul::I()->cx()->setAssemblyPath( __DIR__.'/assembly' );

	\Jhul::I()->fx()->add( 'app', __DIR__.'/app' ) ;

	//setting namespace for modules
	\Jhul::I()->fx()->add( '_m', __DIR__.'/app/module' ) ;
}
