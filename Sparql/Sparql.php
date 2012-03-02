<?php

namespace Sw\Arc2Bundle\Sparql; 

abstract class Sparql
{
	// protected: can be redefined by subclasses, only when something more than an 
	// endpoint must be defined. 
	protected function getOptions()
	{
		return array('remote_store_endpoint' => $this->getSparqlEndpoint());
	}
	
	abstract protected function getSparqlEndpoint(); 
	
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