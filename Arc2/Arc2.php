<?php

namespace Sw\Arc2Bundle\Arc2; 

/**
 * Loading of ARC2. 
 *
 * @author Thibaut
 */
class Arc2
{
    /**
     * Constructor, with the options specified.  
     * 
     * @param array $options
     */
    public function __construct($arc_path)
    {
        require($arc_path . '/ARC2.php'); 
		// ARC2 takes care of all the necessary loading (no namespace for these files, but 
		// they autoload when necessary). 
	}
}