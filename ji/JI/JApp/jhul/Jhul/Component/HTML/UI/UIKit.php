<?php namespace Jhul\Components\HTML\UI;

/* @Author : Manish Dhruw < 1D3N717Y12@gmail.com >
+=======================================================================================================================
| @Created : 2016-August-04
----------------------------------------------------------------------------------------------------------------------*/

class UIKit
{

	use \Jhul\Core\_AccessKey;

	protected $_html;

	public function __construct( $html )
	{
		$this->_html = $html;
	}

	public function renderFile( $file, $params = [] )
	{
		ob_start();

		extract($params, EXTR_OVERWRITE);


		require($file);

		return ob_get_clean();
	}

	protected $_types =
	[
		'pagination' =>  'makePagination',
	];


	public function html()
	{
		return $this->_html;
	}


	public function makeNav($params )
	{
		return '<style type="text/css">
		.page_nav
		{
			display:block;
			text-align:center;
		}

		.page_nav .previous, .page_nav .next, .page_nav .name
		{
			display:inline-block;
			color:#fff;
			background:blue;
			text-align:center;
			padding:1% 2%;

		}

		.page_nav .name
		{
			margine:auto;
		}

		.page_nav .previous
		{
			float:left;
			min-width:48px;
			line-height:28px;
			min-height:28px;
		}


		.page_nav .next
		{
			float:right;
			min-width:48px;
			min-height:28px;
			line-height:28px;

		}

		</style>
		<div class="page_nav">
		<a href=""><div class="previous" style="background:green;" >next</div></a>
		<div class="name">पृष्ठ</div>
		<a href=""><div class="next" >next</div></a>
		</div>';
	}



	/*
	+
	| @Params : $params =
	| [
	|	'base_url'		=> ?,
	|	'page_size'		=> ?,
	|	'current_page'	=> ?.
	|	'items_per_page'	=> ?,
	| ]
	*/
	public function makePagination($params )
	{

		$pages = ceil( $params['count_items']/$params['items_per_page'] );

		$base_url = FALSE === strpos( $params['base_url'], '?' ) ? $params['base_url'].'?' : $params['base_url'].'&';

		if( !($pages > 1) ) return '';

		$html = '<ul class="uk-pagination" uk-margin>';


		for ( $i=1 ; $i <= $pages ; $i++)
		{
			if( $params['current_page'] == $i  )
			{
				$html .= '<li class="uk-active"><span>'.$i.'</span></li>';
			}
			else
			{
				$html .= ' <li><a href="'.$base_url.'page='.$i.'">'.$i.'</a></li>';
			}
		}

		return $html.'</ul>';
	}



	public function form()
	{

	}
}
