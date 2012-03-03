<?php

namespace Sw\Arc2Bundle\Sparql; 

/**
 * Convenience class to make SPARQL requests on distant endpoints. 
 *
 * @author Thibaut
 */
class Sparql
{
	/** 
	 * Convenience function to make SPARQL requests on an endpoint. 
	 *
	 * $endpoint: the SPARQL endpoint URL. 
	 * $q: the SPARQL request. 
	 */
	public static function request($endpoint, $q)
	{
		return self::requestAdvanced(array('remote_store_endpoint' => $endpoint), $q); 
	}
	
	/** 
	 * Convenience function to make SPARQL requests on an endpoint, with possible details (really dependent on ARC2). 
	 *
	 * $options: an ARC2 options array. Will be passed to ARC2::getRemoteStore without further processing. 
	 * $q: the SPARQL request. 
	 */
	public static function requestAdvanced($options, $q)
	{
		return \ARC2::getRemoteStore($options)->query($q, 'rows'); 
	}
}
