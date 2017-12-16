<?php namespace Jhul\Core;

use \Jhul\Components\EX\EX ;

class _Assembler
{
	public static function I()
	{
		return new static();
	}

	public function assemble( &$j, $config )
	{
		if( empty($config['base_url']) )
		{
			$config['base_url'] = trim(  $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], '/' );
		}

		//Settting up Exception Handler
		$j->s( 'ex', EX::I() );

		$j->s( 'baseURL', $config['base_url'] );

		$j->s( 'publicRoot', $config['public_root'] );

	//	$j->s( 'dataStoreDirectoryPath', $config['data_store_directory_path'] );
		$j->s( 'mSysFileStore', new FileStore\Sys($config['data_store_directory_path']) );

		//$j->s( 'publicCacheDirectory', $config['public_cache_directory'] );
		$j->s( 'mPubFileStore', new FileStore\Pub( $config['public_cache_directory'], $j->publicRoot(), $j->baseURL() ) );

		if( JHUL_ENABLE_EX_HANDLER )
		{
			if( JHUL_IF_ENABLE_DEBUG )
			{
				$j->ex()->setDebug( TRUE );
			}

			$j->ex()->activate();

			if( JHUL_DISABLE_FRAMEWORK_ERROR === TRUE) $this->ex()->removeTracesFrom( JHUL_FRAMEWORK_PATH );
		}


		//Settting up FileSystem
		$j->s( 'fx' ,  new FX ) ;

		$j->fx()->add( 'Jhul', JHUL_FRAMEWORK_PATH.'/Jhul' ) ;


		// // //Setting up Config Container
		// $j->s( 'mBag', new Bags\Manager );

		//Setting up Component Loader
		$j->s( 'cx', new CX );


		//register manager
		$j->s( 'mRegister', new \Jhul\Core\Register\Manager() );
	}


}
