<?php namespace Jhul\Core\Application\DataType\Types\Image;


class Attribute extends \Jhul\Core\Application\DataType\_Attribute\_Class
{




	public function allowedTypes()
	{
		return $this->config('allowed_types');
	}

	public function __construct()
	{
		$this->mErrorCode()->add
		([
			'validateImageType'	=> 'IMAGE_TYPE_FAILED',

			'validateMinSize'		=> 'MIN_SIZE_FAILED',
			'validateMaxSize'		=> 'MAX_SIZE_FAILED',

			'validateMinWidth'	=> 'MIN_WIDTH_FAILED',
			'validateMaxWidth'	=> 'MAX_WIDTH_FAILED',

			'validateMinHeight'	=> 'MIN_HEIGHT_FAILED',
			'validateMaxHeight'	=> 'MAX_HEIGHT_FAILED',

			'validateType'		=> 'IMAGE_FAILED',
		]);


		$this->config()->add
		([
			'definition'		=> '',
			'required'			=> 1,
			'allowed_types'		=> ['jpg', 'gif', 'png'],
			'validation_steps'	=> 'type:minSize:maxSize:minWidth:maxWidth:minHeight:maxHeight',

			//6KB
			'min_size'		=> 6000,

			//1MB
			'max_size'		=> 1000000,

			//12px
			'min_height'	=> 16,

			//2400px
			'max_height'	=> 2400,

			//12px;
			'min_width'		=> 16,

			//2400px
			'max_width'		=> 2400,
		]);

		$this->loadDefinition();
	}

	public function loadDefinition()
	{
		$this->config()->add( $this->decodeDefinition( $this->config('definition')  ), TRUE );
	}

	public function decodeDefinition( $definition )
	{
		return Definition::decode( $definition );
	}


	public function valueEntityClass()
	{
		return __NAMESPACE__.'\\Value';
	}

	//Chreck if it png, jpg or gif
	public function validateType( $image )
	{
		return in_array( $image->extension(), $this->allowedTypes() ) ;
	}

	public function type() { return 'image'; }

	public function validateMinSize( $image )
	{
		if( $this->config()->has('min_size') )
		{
		 	return  $image->size() >= $this->config('min_size')  ;
		}
	}

	public function validateMaxSize( $image )
	{
		if( $this->config()->has('max_size') )
		{
		 	return $image->size() <= $this->config('max_size') ;
		}
	}

	public function validateMinWidth( $image )
	{
		if( $this->config()->has('min_width') )
		{
		 	return $image->width() >= $this->config('min_width') ;
		}
	}

	protected function validateMaxWidth( $image )
	{
		if( $this->config()->has('max_width') )
		{
		 	return  $image->width() <= $this->config('max_width') ;
		}
	}

	protected function validateMinHeight( $image )
	{
		if( $this->config()->has('min_height') )
		{
		 	return  $image->height() >= $this->config('min_height') ;
		}
	}

	protected function validateMaxHeight( $image )
	{
		if( $this->config()->has('max_height') )
		{
		 	return   $image->height() <= $this->config('max_height') ;
		}
	}

	public function make( $value )
	{

		$class = $this->valueEntityClass();

		$value = new $class( $value, $this );

		$vMethods = $this->validationSteps();

		foreach ( $vMethods as $vMethod )
		{
			if( FALSE == $this->$vMethod( $value ) )
			{
				$value->addError( $this->mErrorCode()->get( $vMethod ) );

				return $value;
			}
		}

		return $value;
	}


}
