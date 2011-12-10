<?php

namespace Sw\Arc2Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// TO DO: don't hardcode paths
require(__DIR__ . '/../../../../arc2/ARC2.php');

/**
 * A SPARQL endpoint. 
 *
 * @author Thibaut
 */
class SparqlEndpointController
{
    public function indexAction()
    {
        // TO DO: use a semantic configuration for the bundle
        $arc_config = array(
            /* MySQL database settings */
            'db_host' => 'localhost',
            'db_user' => 'root',
            'db_pwd' => '',
            'db_name' => 'symfony',

            /* ARC2 store settings */
            'store_name' => 'sandbox',

            /* SPARQL endpoint settings */
            'endpoint_features' => array(
                'select', 'construct', 'ask', 'describe', // allow read
                'load', 'insert', 'delete',               // allow update
                'dump'                                    // allow backup
            ),
            'endpoint_timeout' => 60, /* not implemented in ARC2 preview */
            'endpoint_read_key' => '', /* optional */
            'endpoint_write_key' => '', /* optional */
            'endpoint_max_limit' => 250, /* optional */
            );
        
        $ep = \ARC2::getStoreEndpoint($arc_config);

        if (!$ep->isSetUp())
        {
            $ep->setUp(); /* create MySQL tables */
        }
        
        $ep->go();
        return; 
        // and that's, ARC2 handles everything else
    }
}
