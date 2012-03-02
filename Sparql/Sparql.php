<?php

namespace Sw\Arc2Bundle\Sparql; 

abstract class Sparql
{
	// protected: is to be redefined by subclasses. 
	abstract protected function getOptions(); 
	
	private function getStore()
	{
		return \ARC2::getRemoteStore($this->getOptions());
	}
	
	// protected: is to be called by subclasses. 
	protected function request($q)
	{
		return $this->getStore()->query($q, 'rows'); 
	}
}