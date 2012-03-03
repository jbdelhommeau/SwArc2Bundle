<?php

namespace Sw\Arc2Bundle\Sparql; 

/**
 * Specific class for DBpedia support. 
 *
 * @author Thibaut
 */
class DbPedia
{
	/** 
	 * Convenience function to make requests easily on DBpedia. 
	 */
	public function request($q)
	{
		return Sparql::request('http://dbpedia.org/sparql', $q); 
	}

	/**
	 * Returns a set of interests based on the keyword (regexed later). 
	 *
	 * Request written by Julien Plu. 
	 */ 
	public function getInterests($keyword) 
	{
		$q = 'PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>

SELECT ?interest 
WHERE { 
    ?x rdfs:label ?interest
    FILTER regex (?interest, "' . $keyword . '", "i") 
}'; 
		return self::request($q); 
	}
}
