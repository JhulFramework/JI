<?php namespace _m\webpage\view\type\element;


trait _API
{
	public function setBackground( $color )
	{
		$this->mStyle()->container()->set('background', $color);
		return $this ;
	}

	public function setContentBackground( $color )
	{
		$this->mStyle()->content()->set('background', $color);
		return $this ;
	}

	public function setWidthFull()
	{
		$this->mStyle()->container()->set('display', 'flex');
		return $this ;
	}

	public function autoExpandWidth()
	{
		if( NULL != $this->parent() )
		{
			$this->parent()->autoExpandWidth();
			$this->mStyle()->container()->set('flex-grow', 1);
		}

		$this->mStyle()->content()->set('flex-grow', 1);
		return $this ;
	}


	public function setContentPadding( $size, $unit = 'px' )
	{
		$this->mStyle()->content()->set('padding', $size.$unit);
		return  $this;
	}
}
