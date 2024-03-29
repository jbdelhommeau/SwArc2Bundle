<?php

namespace Sw\Arc2Bundle\SparqlEndpoint; 

/**
 * Description of SparqlEndpoint
 *
 * @author Thibaut
 */
class SparqlEndpoint
{
    /**
     * @var array The parameters for the SPARQL endpoint.  
     */
    private $_options = array();
    
    /**
     * @var string Path to ARC2
     */
    private $_arc = '';
    
    /**
     * @var boolean Is the endpoint available on the specified URL; otherwise, only by this service. 
     */
    private $_active = true; 
    
    /**
     * @var string The URL to serve automatically the endpoint. 
     */
    private $_url = ''; 
    
    /**
     * @var boolean Whether to create the tables in the database if they do not exist. 
     */
    private $_autocreate = false; 
    
    /**
     * Constructor, with the options specified.  
     * 
     * @param array $options
     */
    public function __construct($arc_path, array $db = array(), array $sparql = array(), array $features = array())
    {
        $this->_arc         = $arc_path; 
        $this->_active      = (bool) $sparql[0]; 
        $this->_url         = $sparql[1]; 
        $this->_autocreate  = (bool) $sparql[4];
        
        $feat = array(); 
        
        // Read
        if((bool) $features[0])
            $feat[] = 'select';
        if((bool) $features[1])
            $feat[] = 'construct';
        if((bool) $features[2])
            $feat[] = 'ask';
        if((bool) $features[3])
            $feat[] = 'describe';
        // Update
        if((bool) $features[4])
            $feat[] = 'load';
        if((bool) $features[5])
            $feat[] = 'insert';
        if((bool) $features[6])
            $feat[] = 'delete';
        // Backup
        if((bool) $features[7])
            $feat[] = 'dump';
        
        $this->_options = array(
            /* MySQL database settings */
            'db_host' => $db[0],
            'db_user' => $db[1],
            'db_pwd'  => $db[2],
            'db_name' => $db[3],

            /* ARC2 store settings */
            'store_name' => $sparql[2],
            'endpoint_timeout' => (int) $sparql[4], /* not implemented in ARC2 preview */
            'endpoint_read_key' => $sparql[5], /* optional */
            'endpoint_write_key' => $sparql[6], /* optional */
            'endpoint_max_limit' => (int) $sparql[7], /* optional */

            /* SPARQL endpoint settings */
            'endpoint_features' => $feat, 
            ); 
        
        require($this->_arc . '/ARC2.php'); 
    }
    
    /**
     * If this service cannot create the tables and they are not created, returns false. 
     * Otherwise, returns an endpoint instance (may the tables have been created or not). 
     * 
     * @return boolean or ARC2_StoreEndpoint
     */
    public function getEndpoint()
    {
        $ep = \ARC2::getStoreEndpoint($this->_options);

        if (! $ep->isSetUp())
        {
            if($this->_autocreate)
            {
                $ep->setUp();
            }
            else
            {
                return false; 
            }
        }
        
        return $ep; 
    }
    /**
     * Draws the endpoint **immediately**. 
     */
    public function drawEndpoint()
    {
       $this->getEndpoint()->go();
    }
    
    /**
     * Returns the HTML code for the endpoint. 
     * 
     * Note: This will also define some headers, which could interfere with Sf2. 
     * 
     * @todo Understand the headers and try to plug it into Sf2 (not the main goal of 
     * the bundle, will most probably not be done). 
     */
    public function getEndpointData()
    {
        $ep = $this->getEndpoint(); 
        $ep->handleRequest();
        $ep->sendHeaders(); 
        return $this->getResult();
    }
}
