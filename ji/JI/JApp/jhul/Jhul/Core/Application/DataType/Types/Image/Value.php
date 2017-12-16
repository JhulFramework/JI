<?php namespace Jhul\Core\Application\DataType\Types\Image ;


class Value extends \Jhul\Core\Application\DataType\_Value\_Class
{

	protected $_width;
	protected $_height;
	protected $_size;
	protected $_mime;
	protected $_type;
	protected $_extension;


	public function value()
	{
		if( $this->isValid() )
		{
			return $this->source();
		}
	}

	public function __construct( $file, &$dataType )
	{
		if( 0 != $file['error'] )
		{
			$this->addError( 'Error While Uploading Image' );
		}

		$this->_input = $file['tmp_name'];

		$this->_dataType = $dataType;

		if( $this->isValid() ){ $this->loadImageInfo(); }
	}

	public function height()
	{
		return $this->_height;
	}

	private function loadImageInfo()
	{
		if( FALSE != ( $info = getimagesize( $this->source() ) ) )
		{
			$this->_width	= $info[0];
			$this->_height	= $info[1];
			$this->_type	= $info[2];
			$this->_extension	= image_type_to_extension( $info[2], FALSE );
			$this->_mime	= $info['mime'];
			$this->_size	= filesize( $this->source() );

			if( 'jpeg' == $this->_extension  )
			{
				$this->_extension = 'jpg';
			}
		}
	}

	public function mime()
	{
		return $this->_mime ;

	}

	public function size()
	{
		return $this->_size;
	}

	public function source()
	{
		return $this->inputValue();
	}

	public function __toString()
	{
		if( $this->isValid() )
		{
			return $this->inputValue();
		}
	}

	public function type()
	{
		return $this->_type;
	}

	public function extension()
	{
		return $this->_extension;
	}

	public function isImage()
	{
		return !empty($this->_type);
	}

	public function width()
	{
		return $this->_width;
	}

	public function encode64()
	{
		return base64_encode( $this->value() );
	}

	public function embed()
	{
		return 'data:image/'.$this->type().';base64,'.$this->encode64();
	}
}
