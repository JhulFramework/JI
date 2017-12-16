<?php namespace Jhul\Core\Application\Page\Item;

abstract class _Index extends \Jhul\Core\Application\Page\_Class
{
	protected $_current_page ;

	public abstract function countItems();
	public abstract function itemDispenser();
	public abstract function itemKeyName();
	public abstract function url();

	public function currentPageKey()
	{
		if( empty($this->_current_page) )
		{
			if( isset($_GET['page']) && ctype_digit( $_GET['page'] ) )
			{
				$this->_current_page = $_GET['page'];
			}

			if( $this->_current_page < 1 || $this->_current_page > $this->countPages() )
			{
				$this->_current_page = 1;
			}
		}

		return $this->_current_page ;
	}

	public function getOffSet()
	{
		$offset = ($this->currentPageKey() - 1)*$this->itemsPerPage();

		if( $offset < 0 ) $offset = 0;

		return $offset;
	}

	private $_count_pages ;

	public function countPages()
	{
		if( empty($this->_count_pages) )
		{
			$this->_count_pages = ceil( $this->countItems()/$this->itemsPerPage() );
		}

		return $this->_count_pages;
	}

	public function items()
	{
	 	return $this->itemDispenser()->offset( $this->getOffSet() )->limit( $this->itemsPerPage() )->orderBy( $this->itemKeyName(),  $this->orderBy() )->fetchAll();
	}

	public function itemsPerPage(){ return 10 ; }

	public function orderBy()
	{
		return 'DESC';
	}

	public function pageNav()
	{
		return $this->j()->cx('html')->uikit()->makeNav
		([
			'items_per_page'	=> $this->itemsPerPage(),

			'count_items'	=> $this->countItems(),

			'current_page'	=> $this->currentPageKey(),

			'base_url'		=> $this->url(),
		]);
	}

	//next page number
	protected $_next_page;
	protected $_previous_page;

	public function nextPage()
	{
		if( empty($this->_next_page) )
		{
			$this->_next_page = $this->currentPageKey() + 1;

			if( $this->_next_page > $this->countPages() )
			{
				$this->_next_page = 1;
			}
		}

		return $this->_next_page ;
	}

	public function previousPage()
	{
		if( empty($this->_previous_page) )
		{
			$this->_previous_page = $this->currentPageKey() - 1;

			if( $this->_previous_page < 1 )
			{
				$this->_previous_page = $this->countPages();
			}
		}

		return $this->_previous_page ;
	}


	public function pagination()
	{
		return $this->j()->cx('html')->uikit()->makePagination
		([
			'items_per_page'	=> $this->itemsPerPage(),

			'count_items'	=> $this->countItems(),

			'current_page'	=> $this->currentPageKey(),

			'base_url'		=> $this->url(),
		]);
	}

	public function nextPageURL()
	{
		if( strpos( $this->url(), '?' ) )
		{
			return $this->url().'&page='.$this->nextPage();
		}

		return $this->url().'?page='.$this->nextPage();
	}

	public function previousPageURL()
	{
		if( strpos( $this->url(), '?' ) )
		{
			return $this->url().'&page='.$this->previousPage();
		}

		return $this->url().'?page='.$this->previousPage();
	}


	protected $_end_key;

	public function endKey()
	{
		if( empty($this->_end_key) )
		{
			$item = $this->itemDispenser()->orderBy( $this->itemKeyName(), 'DESC' )->fetch() ;

			if( !empty($item) )
			{
				$this->_end_key = $item->key();
			}
		}

		return $this->_end_key;
	}


}
