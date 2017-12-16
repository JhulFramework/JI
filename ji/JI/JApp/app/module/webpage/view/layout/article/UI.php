<?php namespace _m\webpage\view\layout\article;

class UI
{
	protected $_entity;

	public function __construct( $entity )
	{
		$this->_entity = $entity;
	}

	public function encode( $str )
	{
		return htmlspecialchars( $str, ENT_QUOTES, 'utf-8' ) ;
	}

	public function entity()
	{
		return $this->_entity;
	}

	public function makeElement( $element, $params = [], $content = '' )
	{
		$attributes = '';

		foreach ( $params as $key => $value)
		{
			$attributes .= ' '.$key.'="'.$value.'"';
		}

		return '<'.$element.$attributes.' >'.$content.'</'.$element.'>' ;
	}

	public function plusAction()
	{
		return ( NULL == $this->entity()->siuPlus() ) ? 'add_plus' : 'remove_plus' ;
	}

	public function minusAction()
	{
		return ( NULL == $this->entity()->siuMinus() ) ? 'add_minus' : 'remove_minus' ;
	}

	public function plusButton()
	{
		$params =
		[

			'href'	=> '',
			'id' 		=> $this->plusButtonID(),
			'class' 	=> 'button',
			'item_key'	=> $this->entity()->key(),
			'link_key'	=> $this->plusButtonID(),
		];

		return $this->makeElement( 'button', $params, $this->plusButtonContent() );
	}

	public function minusButton()
	{
		$params =
		[

			'href'	=> '',
			'id' 		=> $this->minusButtonID(),
			'class' 	=> 'button',
			'item_key'	=> $this->entity()->key(),
			'link_key'	=> $this->minusButtonID(),
		];


		return $this->makeElement( 'button', $params, $this->minusButtonContent() );
	}

	public function plusButtonID()
	{
		return 'plus_'.$this->entity()->key();
	}

	public function minusButtonID()
	{
		return  'minus_'.$this->entity()->key();
	}

	public function key()
	{
		return $this->entity()->key();
	}

	public function plusButtonContent()
	{
		$c = '<span link_key="'.$this->plusButtonId().'" class="icon"><i class="icon-heart" link_key="'.$this->plusButtonId().'" ></i></span><span link_key="'.$this->plusButtonId().'" class="count">'.$this->entity()->countPlus().'</span>';

		$class = 'content plus_active';

		if( NULL == $this->entity()->siuPlus() )
		{
			$class = 'content';
		}

		return '<span action="'.$this->plusAction().'" class="'.$class.'">'.$c.'</span>';
	}

	public function minusButtonContent()
	{
		$c = '<span link_key="'.$this->minusButtonId().'" class="icon"><i class="icon-heart-broken" link_key="'.$this->minusButtonId().'" ></i></span><span link_key="'.$this->minusButtonId().'"  class="count">'.$this->entity()->countMinus().'</span>';

		$class = ' minus_active';

		if( NULL == $this->entity()->siuMinus() )
		{
			$class = '';
		}

		return '<span action="'.$this->minusAction().'"  class="content'.$class.'">'.$c.'</span>';
	}

	public function editButton()
	{
		if( $this->entity()->isEditable() )
		{
			return '<a class="edit" href="'.$this->entity()->editURL().'"><b><i class="icon-feather"></i> सम्पादित करें</b></a>' ;
		}
	}

	public function readButton()
	{
		return '<a href="'.$this->entity()->url().'" class="read_button">पूरा पढ़ें</a>' ;
	}
}
