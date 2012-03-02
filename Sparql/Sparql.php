<?php

namespace Sw\Arc2Bundle\Sparql; 

/**
 * Abstract class to make creation of more specific databases classes
 * to get any kind of information you'd like from them. 
 *
 * @author Thibaut
 */
abstract class Sparql
{
	/** 
	 * Protected: can be redefined by subclasses, only when something more than an 
	 * endpoint must be defined. 
	 *
	 * Indicates the options to give ARC2, including the SPARQL endpoint to send
	 * the request (as this will be set for each of them, an easier method is available
	 * with getSparqlEndpoint()). 
	 *
	 * The return of this function is directly passed to ARC2, and therefore is 
	 * really ARC2 dependant. 
	 */
	protected function getOptions()
	{
		return array('remote_store_endpoint' => $this->getSparqlEndpoint());
	}
	
	/**
	 * Used to define the SPARQL endpoint URL (to make creation of subclasses as 
	 * smooth and ARC2-independant as possible). 
	 */
	abstract protected function getSparqlEndpoint(); 
	
	/**
	 * Gets the ARC2 store which will receive requests, can be asked to do more 
	 * intersting things. 
	 */
	private function getStore()
	{
		return \ARC2::getRemoteStore($this->getOptions());
	}
	
	/** 
	 * Protected: is to be called by subclasses. 
	 *
	 * Convenience function to make SPARQL requests on the defined endpoint. 
	 */
	protected function request($q)
	{
		return $this->getStore()->query($q, 'rows'); 
	}
}