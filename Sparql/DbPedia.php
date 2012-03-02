<?php

namespace Sw\Arc2Bundle\Sparql; 

class DbPedia 
{
	public static function getInterests($keyword) 
	{
		// Configure the beautiful thing. 
		$config = array('remote_store_endpoint' => 'http://dbpedia.org/sparql');
		$store = \ARC2::getRemoteStore($config);
		
		// Do the actual request. 
		$q = 'PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>

SELECT ?interest 
WHERE { 
    ?x rdfs:label ?interest
    FILTER regex (?interest, "' . $keyword . '", "i") 
}'; 
		return $store->query($q, 'rows'); 
	}
}