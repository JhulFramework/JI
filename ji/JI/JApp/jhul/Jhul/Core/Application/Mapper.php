<?php namespace Jhul\Core\Application;

class Mapper
{
	use \Jhul\Core\_AccessKey;

	//to avoid multiple loading
	protected $_registered_modules;

	protected $_type_identifiers =
	[
		'handler'			=> '#',
		'page' 			=> '@',
		'view'			=> '.',
		'style'			=> '$',
		'l10n'			=> '=',
		'context'			=> '()',
	];

	protected $_map = [];

	public function ifRegistered( $module_key )
	{
		return isset( $this->_registered_modules[$module_key] );
	}



	protected function add( $key, $namespace )
	{
		if( isset( $this->_map[$key] ) )
		{
			throw new \Exception( 'resource key "'.$key.'" already used for resource "'.$namespace.'" ' , 1);
		}

		$this->_map[$key] = $namespace;
	}

	public function hasView( $view_name, $module_key )
	{
		return $this->has( $module_key.$this->viewIdentifier().$view_name );
	}

	public function has( $name )
	{
		if( !isset( $this->_map[$name] ) )
		{
			$res = $this->identifyResource( $name );

			if( !empty($res) )
			{

				if( !$this->ifRegistered( $res['module'] ) )
				{
					$this->register( $res['module']  );
				}

				// if( isset( $this->_map[$name] ) )
				// {
				// 	return TRUE;
				// }

				//throw new \Exception( 'Module "'.$res['module'].'" does not have "'.$res['type'].'" "'.$res['target'].'" ' , 1 );
			}
			//return TRUE;
		}

		return isset( $this->_map[$name] );

	}

	public function typeIdentifiers()
	{
		return $this->_type_identifiers;
	}

	public function identifyResource( $name )
	{
		foreach( $this->typeIdentifiers() as $type => $identifier )
		{
			if( strpos( $name, $identifier ) )
			{
				$res =  explode( $identifier, $name );


				$res['target'] = $res[1];
				unset($res[1]);

				$res['module'] = $res[0];
				unset($res[0]);

				$res['type_identifier'] = $identifier;

				$res['type'] = $type;

				$res['name'] = $name ;

				return $res;
			}
		}

		return [];
	}

	public function resolve( $name )
	{
		$res = $this->identifyResource( $name );
		$res['resource'] = $this->get( $name );
		return $res;
	}

	public function map()
	{
		return $this->_map;
	}

	public function register( $module_key  )
	{

		$module = $this->app()->m( $module_key );

		$this->_registered_modules[ $module->key() ] = $module->key();

		$this->_register
		(
			$this->loadConfigFile( $module->path().'/_config/_pages', FALSE ),
			$module->key().$this->pageIdentifier()
		);

		$this->_register
		(
			$this->loadConfigFile( $module->path().'/_config/_handlers', FALSE ),
			$module->key().$this->handlerIdentifier()
		);

		$this->_register
		(
			$this->loadConfigFile( $module->path().'/res/webpage/_templates', FALSE ),
			$module->key().$this->viewIdentifier()
		);

		$this->_register
		(
			$this->loadConfigFile( $module->path().'/res/webpage/_styles', FALSE ),
			$module->key().$this->styleIdentifier()
		);

		$this->_register
		(
			$this->loadConfigFile( $module->path().'/res/l10n/_map', FALSE ),
			$module->key().$this->l10nIdentifier()
		);

	}

	public function registerView( $module_key, $view_name, $view_file )
	{
		$this->add( $module_key.$this->viewIdentifier().$view_name, $view_file );
		return $this;
	}

	public function registerL10N( $view_name, $view_file )
	{
		$this->add( $module_key.$this->viewIdentifier().$view_name, $view_file );
		return $this;
	}

	public function get( $key, $required = TRUE )
	{
		if( $this->has($key) )
		{
			return $this->_map[$key] ;
		}

		if( $required )
		{
			$resource = $this->identifyResource( $key );

			if( empty($resource['type']) )
			{
				$resource['type'] = 'unknown';
			}

			throw new \Exception( ucfirst($resource['type']).' resource "'.$key.'" not found' , 1);
		}
	}

	public function pageIdentifier()
	{
		return $this->_type_identifiers['page'];
	}

	protected function loadConfigFile( $file, $required = TRUE )
	{
		return $this->J()->fx()->loadConfigFile( $file, $required );
	}

	public function _register( $resources, $prefix )
	{
		foreach ($resources as $name => $namespace)
		{
			$this->add( $prefix.$name, $namespace  ) ;
		}
	}


	public function virtualNodeIdentifier()
	{
		return $this->_type_identifiers['virtual_node'];
	}

	public function handlerIdentifier()
	{
		return $this->_type_identifiers['handler'];
	}

	public function viewIdentifier()
	{
		return $this->_type_identifiers['view'];
	}

	public function styleIdentifier()
	{
		return $this->_type_identifiers['style'];
	}

	public function l10nIdentifier()
	{
		return $this->_type_identifiers['l10n'];
	}

	public function getCss( $module_key, $name )
	{
		return $this->get( $module_key.$this->styleIdentifier().$name );
	}
}
