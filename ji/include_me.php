<?php

defined('JI_PATH') or define('JI_PATH', __DIR__);

defined('JI_CI_SYSTEM_PATH') or define('JI_CI_SYSTEM_PATH', __DIR__.'/codeignitor/system');

defined('JI_CI_APPLICATION_PATH') or define('JI_CI_APPLICATION_PATH', __DIR__.'/codeignitor/application');


class Jhul_JI_Loader
{
	public static function autoload( $className )
	{
		if( strpos( $className, 'JI' ) === 0 )
		{
			$file = __DIR__.'/'.str_replace( '\\', '/', $className ).'.php';

			if( file_exists( $file ))
			{
				require( $file ) ;
			}
		}
	}
}

spl_autoload_register(  [ 'Jhul_JI_Loader', 'autoload'] , true);
