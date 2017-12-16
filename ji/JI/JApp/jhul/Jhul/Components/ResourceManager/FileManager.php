<?php namespace Jhul\Components\ResourceManager;

class FileManager
{

	protected $_map;

	//base path
	protected $_destination ;

	protected $_writer;

	protected $_directory ;

	protected $_handlers =
	[
		'jpg' => 'image',
		'png' => 'image',
		'gif' => 'image',
		'jpeg' => 'image',
		'css' => 'css',
		'js' => 'js',
	];

	public function __construct( $path )
	{
		$this->_destination = $path;

		$this->_directory = substr(  md5( get_called_class().$path ), 0, 6 );
	}

	public function create( $name,  $source_file )
	{
		$ext = pathinfo($source_file, PATHINFO_EXTENSION);

		if( !isset( $this->_handlers[ $ext ] ) )
		{
			throw new \Exception( 'no methods to handle file "'.$source_file.'" ' , 1);

		}
		$handler = 'create'.$this->_handlers[$ext];

		$this->$handler( $name, $source_file );
	}

	public function createCss( $name, $source )
	{
		$extension = pathinfo($source, PATHINFO_EXTENSION );

		$file_name = $this->generateFileName( 'css/'.$name, $extension );

		$this->writer()->write( $this->destination().'/'.$file_name, file_get_contents($source)  );

		$this->_map[$name] = $file_name;

		$this->updateMeta();

	}


	public function createJS( $name, $source )
	{
		$extension = pathinfo($source, PATHINFO_EXTENSION );

		$file_name = $this->generateFileName( 'js/'.$name, $extension );

		$this->writer()->write( $this->destination().'/'.$file_name, file_get_contents($source)  );

		$this->_map[$name] = $file_name;

		$this->updateMeta();

	}



	public function createImage( $name,  $source )
	{
		//$this->writer()->touchDirectory( $this->destination().'/images' );

		$extension = pathinfo($source, PATHINFO_EXTENSION );

		$file_name = $this->generateFileName( 'images/'.$name, $extension );
echo '<pre>';
echo '<br/> File : <br/>'.__FILE__.':'.__LINE__.'</br></br>';
var_dump('break');
echo '</pre>';
exit();
		$this->set( $name, $source ) ;

		return $name;
	}

	public function deleteCache()
	{
		$this->cleanDirectory( $this->destination() ) ;
	}

	public function cleanDirectory( $directory )
	{

		$files = glob( $directory.'/*' );

		foreach($files as $file)
		{
			if(is_file($file))
			{
				unlink($file);
			}
			elseif (is_dir($file))
			{

				$this->cleanDirectory( $file );
				@rmdir($file);
			}
		}
	}

	public function directory()
	{
		return $this->_directory;
	}

	public function rPath( $name )
	{
		if( $this->has($name) )
		{
			return $this->directory().'/'.$this->map()[$name];
		}


		if( 'throw_exception' === $throwException  )
		{
				throw new \Exception( 'Resource with name "'.$name.'" no found ' , 1);
		}

		return $throwException;
	}

	public function has( $name )
	{
		return isset( $this->map()[$name] );
	}


	public function destination()
	{
		return $this->_destination.'/'.$this->_directory;
	}


	public function writer()
	{
		if( empty($this->_writer) )
		{
			$this->_writer = new Writer( $this->destination() );
		}
		return $this->_writer;
	}

	public function generateFileName( $name , $extension )
	{
		$file = $this->destination().'/'.$name.'.'.$extension ;

		if( !file_exists($file) ) return $name.'.'.$extension ;

		$name = $name.'-';

		$unique = FALSE ;

		while( !$unique )
		{
			$name .=  $this->randomKey(1);

			$file = $this->destination().'/'.$name.'.'.$extension ;

			if( !file_exists( $file ) )
			{
				$unique = TRUE;
			}
		}

		return $name.'.'.$extension ;
	}



	public function map()
	{
		if( NULL === $this->_map )
		{
			$file = $this->metaFile();

			if( !file_exists($file) )
			{
				$array = [];
				$this->writer()->write( $file, json_encode( $array )  );
			}

			$this->_map = (array) json_decode(file_get_contents( $file ), TRUE);
		}

		return $this->_map ;
	}

	public function updateMeta()
	{
		if( !empty( $this->_map ) )
		{
			$this->writer()->update( $this->metaFile() , json_encode( $this->_map )  );
		}
	}

	protected function metaFile()
	{
		return  $this->destination().'/'.$this->metaName();
	}

	public function metaName()
	{
		return '_meta.json';
	}

	public function randomKey( $length = 12, $charStrength = 2 )
	{
		$char = '0123456789';

		if( $charStrength > 0 )
		$char .= 'abcdefghijklmnopqrstuvwxyz';

		if( $charStrength > 1 )
		$char .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';


		$char = str_shuffle($char);

		$charactersLength = strlen($char);

		$randomString = '';

		for ($i = 0; $i < $length; $i++)
		{
			$randomString .= $char[ rand( 0, $charactersLength - 1 ) ];
		}

		return $randomString;
	}

	//creates, if upload directory not exists
	private function touchDirectory( $destination )
	{
		if( is_dir( $destination ) || @mkdir( $destination , 0755, true) )
		{
			return TRUE;
		}

		throw new \Exception('Directory "'.$destination.'" Not Exists/Not Creatable ');
	}
}
