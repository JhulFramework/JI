<?php namespace Jhul\Core\Application\Page\Item;

abstract class _Class extends \Jhul\Core\Application\Page\_Class
{
	abstract public function item();

	abstract public function previousPageURL();

	abstract public function nextPageURL();

	abstract public function navigationCenterContent();
}
