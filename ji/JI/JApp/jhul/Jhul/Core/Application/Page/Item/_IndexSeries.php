<?php namespace Jhul\Core\Application\Page\Item;

abstract class _IndexSeries extends _Index
{

	protected $_lastItemKey;
	protected $_currentPageKey;

	private $_itemKeys = [];

	const INVALID_PAGE_KEY = -1 ;

	public function __construct()
	{
		$this->_initialize();
	}

	final private function _initialize()
	{
		if( empty($this->_currentPageKey) )
		{
			if( isset($_GET['page'])  )
			{
				$this->_currentPageKey = (int) $_GET['page'];

				if( $this->_currentPageKey < 0 || $this->_currentPageKey > $this->countPages() )
				{
					$this->_currentPageKey = static::INVALID_PAGE_KEY ;
				}

				if( $this->_currentPageKey == 0  )
				{
					$this->_currentPageKey = $this->countPages();
				}
			}
			else
			{
				$this->_currentPageKey = $this->countPages();
			}
		}

		$this->_itemKeys = $this->calculateItemKeys();
	}

	private function calculateItemKeys()
	{
		if( $this->currentPageKey() != static::INVALID_PAGE_KEY  )
		{
			$max = $this->currentPageKey()*$this->itemsPerPage();

			$keys[] = $max;

			for ( $i = 1 ; $i < $this->itemsPerPage()  ; $i++)
			{
				$key = $max - $i ;

				if( $key > 0 )
				{
					$keys[$i] = $key;
				}
			}

			return  $keys;
		}

		return [];
	}

	public function currentPageKey()
	{
		return $this->_currentPageKey ;
	}

	public function itemKeys()
	{
		return $this->_itemKeys;
	}

	public function ifPageKeyValid()
	{
		return  $this->currentPageKey() > -1;
	}

	public function items()
	{
		return $this->itemDispenser()->findByKeys($this->itemKeys()) ;
	}

	public function endKey()
	{
		return $this->lastItemKey() ;
	}


	public function lastItemKey()
	{
		if( empty($this->_lastItemKey) )
		{
			$item = $this->itemDispenser()->orderBy( $this->itemKeyName(), 'DESC' )->fetch() ;

			if( !empty($item) )
			{
				$this->_lastItemKey = $item->key();
			}
		}

		return $this->_lastItemKey;
	}


}
