<?php namespace Jhul\Core\Application\Response\WebPage;

/* @Author : Manish Dhruw [1D3N717Y12@gmail.com]
+=======================================================================================================================
| @Created : Wed 06 Apr 2016 01:59:09 PM IST
| Script Manager
+---------------------------------------------------------------------------------------------------------------------*/

class Script
{

	use \Jhul\Core\_AccessKey;

	public $publicJS = [];

	protected $_linked = [] ;

	protected $_embedded = [];

	public function link( $name , $file = NULL )
	{

		if( !empty($file) )
		{
			$this->_linked[$name] = $this->_link($file);

			return;
		}

		if( !isset( $this->_linked[$name] ) )
		{

			if( !isset( $this->publicJS[$name] ) )
			{
				throw new \Exception('Public JS '.$name.' not Mapped ', 1);
			}

			$this->_linked[$name] = $this->_link( $this->getApp()->URL().'/'.$this->getApp()->publicResDir().'/'.$this->publicJS[$name].'.js' );
		}
	}

	private function _link( $url )
	{
		return '<script src="'.$url.'.js"></script>' ;
	}

	public function links()
	{
		return implode( '', $this->_linked );
	}

	public function makeEmbedded()
	{
		return '<script>'.implode( ' ', $this->_embedded).'</script>';
	}

	public function toString()
	{
		return $this->__toString();
	}

	public function __toString()
	{
		return $this->links().$this->makeEmbedded();
	}

	public function embed( $script, $key = NULL )
	{
		if( empty($key) )
		{
			$key = mb_substr( $script, 0, 12 );
		}

		if( !isset($this->_embedded[$key]) )
		{
			$this->_embedded[$key] = $script;
		}
	}
}
