<?php

namespace Sw\Arc2Bundle\Sparql; 

class DbPedia extends \Sw\Arc2Bundle\Sparql\Sparql
{
	protected function getOptions()
	{
		return array('remote_store_endpoint' => 'http://dbpedia.org/sparql');
	}

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