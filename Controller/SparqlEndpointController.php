<?php

namespace Sw\Arc2Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * A SPARQL endpoint. 
 *
 * @author Thibaut
 */
class SparqlEndpointController extends Controller
{
    public function indexAction()
    {
        $this->get('sw_arc2.sparql')->drawEndpoint(); 	
    }
}
