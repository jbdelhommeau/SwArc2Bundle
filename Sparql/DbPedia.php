<?php

namespace Sw\Arc2Bundle\Sparql; 

/**
 * Specific class for DBpedia support. 
 *
 * @author Thibaut
 */
class DbPedia extends \Sw\Arc2Bundle\Sparql\Sparql
{
	protected function getSparqlEndpoint()
	{
		return 'http://dbpedia.org/sparql';
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
		return $this->request($q, 'rows'); 
	}
}