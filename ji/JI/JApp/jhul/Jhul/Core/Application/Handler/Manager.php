<?php namespace Jhul\Core\Application\Handler;

/* @Author Manish Dhruw < 1D3N717Y12@gmail.com >
+=======================================================================================================================
| @Created : 2016-October-16
+---------------------------------------------------------------------------------------------------------------------*/

class Manager
{
	use \Jhul\Core\_AccessKey;

	protected $_trace = [];


	protected $_pointer ;

	public function mModule()
	{
		return $this->app()->m();
	}

	public function pointer()
	{
		if( empty($this->_pointer) )
		{
			$this->_pointer = new Pointer();
		}

		return $this->_pointer;
	}

	protected $_data;

	public function setData( $key, $value )
	{
		$this->_data[$key] = $value;
	}

	//used for auto handleing
	//MUST ONLY BE CALLED BY application
	//auto synced with route segemnts
	public function run( $handler, $params = [] )
	{
		$handler = $this->resolveClass(  $handler ) ;

		$this->_trace[ $this->mPath()->current() ] = $handler;

		$handler = $this->findEndHandler( new $handler );

		if( empty($handler) ) return ;

		if( !$this->mPath()->hasNext() || $handler->canHandleNextNode() )
		{
			return $handler->isAccessible() ? $handler->handle( $this->_data ) : NULL ;
		}
	}


	public function resolveClass( $handler )
	{
		if( !strrpos( $handler, '\\' ) )
		{
			$handler = $this->app()->mapper()->get($handler);
		}

		if( !class_exists( $handler ) )
		{
			throw new \Exception( 'Handler Class "'.$handler.'" Not Found' , 1);
		}

		return $handler ;
	}

	protected function findEndHandler( $handler )
	{
		if( !$handler->isAccessible() ) return ;

		$next = $this->findNext( $handler );

		if( !empty( $next ) )
		{
			$next = $this->resolveClass( $next );
			$this->mPath()->moveToNext();
			$this->_trace[ $this->mPath()->current() ] = $next;
			return $this->findEndHandler( new $next );
		}

		$switchToHandler = $handler->switchTo();

		if( !empty( $switchToHandler ) )
		{
			$switchToHandler = $this->resolveClass( $switchToHandler );
			$this->_trace[ count($this->_trace).'-switched' ] = $switchToHandler;
			return $this->findEndHandler( new $switchToHandler) ;
		}

		return $handler;
	}

	public function findNext( $handler )
	{

		if( !$this->mPath()->hasNext() ) return ;

		foreach ( $handler->nextNodeNames() as $path => $next )
		{
			if(  $this->mPath()->next() == $path )
			{
				return $next;
			}
		}

		foreach( $handler->nextNodeNameTypes()  as $t => $h )
		{
			if( $this->app()->mDataType( $t )->make( $this->mPath()->next() )->isValid())
			{
				return $h;
			}
		}

		return $handler->nextHandler();
	}

	public function mPath()
	{
		return $this->app()->clientRequestRoute()->navigator() ;
	}

	public function running() { return empty( $this->_running ); }

	public function showTrace()
	{
		$html = '';

		foreach ($this->_trace as $key => $value)
		{
			$html .= '<br/>'.$key.' => '.$value;
		}

		return $html;
	}

}
