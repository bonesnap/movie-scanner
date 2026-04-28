<?php
namespace Scanner\IgnorantRecursiveDirectoryIterator;

use ReturnTypeWillChange;

class IgnorantRecursiveDirectoryIterator extends \RecursiveDirectoryIterator
{
    #[ReturnTypeWillChange]
	function getChildren() : \RecursiveDirectoryIterator|\RecursiveArrayIterator
	{
		try {
			return new IgnorantRecursiveDirectoryIterator($this->getPathname());
		} catch (\UnexpectedValueException $e) {
			return new \RecursiveArrayIterator([]);
		}
	}
}
