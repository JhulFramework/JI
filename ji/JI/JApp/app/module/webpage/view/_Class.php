<?php namespace _m\webpage\view;


abstract class _Class implements _Interface
{
	private $_style;
	private $_script;
	private $_content;

	private $_name;

	public function __construct( $name )
	{
		$this->_name = $name;
	}

	public function content()
	{
		return $this->_content;
	}

	public function show()
	{
		return '<pre>'.htmlspecialchars( $this->asHTML(), ENT_QUOTES, 'utf-8' ).'</pre>';
	}

	public function styleAsHTML()
	{
		if( strlen( $this->style() ) > 10 )
		{
			return '<style>'.$this->style().'</style>' ;
		}
	}

	public function scriptAsHTML()
	{
		if( strlen($this->script()) > 10 )
		{
			return '<script>'.$this->script().'</script>' ;
		}
	}

	public function asHTML()
	{
		return $this->styleAsHTML().$this->content().$this->scriptAsHTML();
	}

	public function style()
	{
		return $this->_style ;
	}

	public function script()
	{
		return $this->_script;
	}

	public function name()
	{
		return $this->_name ;
	}

	final public function compile()
	{
		$this->setContent( $this->compileContent() );
		$this->setStyle( $this->compileStyle() );
		$this->setScript( $this->compileScript());
	}

	public function setContent( $content )
	{
		$this->_content = $content;
		return $this ;
	}

	public function setStyle( $style )
	{
		$this->_style = $style;
		return $this ;
	}

	public function setScript( $script )
	{
		$this->_script = $script;
		return $this ;
	}

}
