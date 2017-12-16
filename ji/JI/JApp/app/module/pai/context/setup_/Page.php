<?php namespace _m\pai\context\setup_;

class Page extends \Jhul\Core\Application\Page\_Class
{
	use \_m\webpage\view\_HasGenerator;

	public function mField()
	{
		return $this->context()->form()->mField() ;
	}

	public function makeWebPage()
	{

		$params =[ 'form' => $this->context()->form() ];

		foreach ( $this->mField()->keys()  as $key )
		{
			if( $this->mField()->get( $key, 'view_type' ) == 'selectOne' )
			{
				$params[ $key.'Options' ] 		= $this->mField()->get( $key, 'options' );
				$params[ $key.'SelectedValue' ] 	= $this->mField()->get( $key, 'selectedValue' );
			}
		}

		$this->generate();
		$this->cookView( $params );
	}
}
