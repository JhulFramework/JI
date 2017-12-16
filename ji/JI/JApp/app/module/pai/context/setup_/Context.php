<?php namespace _m\pai\context\setup_;

class Context extends \Jhul\Core\Application\Module\Context\_Class
{
	private $_formKey;
	private $_formConfig =
	[
		'required' => TRUE,
	];


	public function formConfig( $key )
	{
		return isset($this->_formConfig[$key]) ? $this->_formConfig[$key] : '' ;
	}

	public function setFormConfig( $key, $config )
	{
		$this->_formKey = $key;
		$this->_formConfig = $this->_formConfig + $config;


		return $this ;
	}

	public function isSkipped()
	{
		if( FALSE == $this->_formConfig['required']  )
		{
			return isset( $_GET['skip'] ) &&  ($this->_formKey == $_GET['skip'] )  ;
		}

		return FALSE ;
	}

	public function isAccessible() { return TRUE ; }
}
