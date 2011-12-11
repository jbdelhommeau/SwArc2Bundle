<?php

namespace Sw\Arc2Bundle\Triples; 

/**
 * Representation of a triple, will be used as a factory for a series of triples. 
 *
 * @author Thibaut
 */
class Triple
{
    private $_s; 
//    private $_s_bnode = false; 
    private $_p; 
    private $_o; 
//    private $_o_bnode = false; 
    private $_o_datatype; 
    private $_o_lang; 
    private $_subtriples = array(); 
    
    /**
     * Constructs a triple. 
     * 
     * If the object is null, it will be replaced by blank nodes. 
     * 
     * @param \Sw\Arc2Bundle\Triples\URI, \Sw\Arc2Bundle\Triples\Triple $subject
     * @param string (URL) $predicate
     * @param string, \Sw\Arc2Bundle\Triples\URI, \Sw\Arc2Bundle\Triples\Triple $object
     * @param string $object_datatype
     * @param string $object_lang 
     */
    public function __construct($subject, $predicate, $object = null, $object_datatype = '', $object_lang = '')
    {
        // If $subject is not an object, it refers to a blank node. 
        if(is_object($subject) && ! in_array(get_class($subject), array('Sw\Arc2Bundle\Triples\Triple', 'Sw\Arc2Bundle\Triples\URI')))
            throw new InvalidArgumentException('Subject ' . $subject . ' must be a triple or an URI. (' . $subject . ';' . $predicate . ';' . $object . ')'); 
        
        $this->_s = $subject; 
//        $this->_s_bnode = (is_object($subject)) ? false : true; 
        $this->_p = $predicate; 
        $this->_o = $object; //($object != null) ? $object : rand(); 
        $this->_o_bnode = ($object == null) ? rand() : null; 
//        $this->_o_bnode = ($object != null) ? true : false; 
        $this->_o_datatype = $object_datatype; 
        $this->_o_lang = $object_lang; 
    }
    
    public function addBlankNode($predicate, $object, $object_datatype = '', $object_lang = '')
    {
        $t = new Triple($this->_o, $predicate, $object, $object_datatype, $object_lang); 
        $this->_subtriples[] = $t; 
        return $t; 
    }
    
    /**
     * Serializes this triple into the ARC2 triple format, along with the triples 
     * who have this triple as subject (blank nodes). 
     * 
     * @return type 
     */
    public function toArcTriples()
    {
        $ret = array(); 
        
        $ret[] = array  (
                            's' => (string) $this->_s, 
                            's_type' => $this->getType($this->_s), //($this->_o_bnode) ? 'bnode' : $this->getType($this->_s), 
                            'p' => (string) $this->_p, 
                            'o' => (string) $this->_o, 
                            'o_type' => $this->getType($this->_o), //($this->_s_bnode) ? 'bnode' : $this->getType($this->_o), 
                            'o_datatype' => $this->_o_datatype,
                            'o_lang' => $this->_o_lang
                        ); 
        
        if(count($this->_subtriples) > 0)
        {
            foreach($this->_subtriples as $bn)
            {
                $b = $bn->toArcTriples(); 
                $ret[] = $b[0]; 
            }
        }
        
        return $ret; 
    }
    
    /**
     * Returns the type of the piece of data, in the ARC2 world: 
     *  - URI (uri)
     *  - blank node (bnode)
     *  - literal (literal)
     * 
     * @param mixed The piece of data whose type is to be retrieved
     * @return string The type of $data
     */
    public static function getType($data)
    {
        if(! is_object($data))
            return 'literal'; 
        
        $type = get_class($data); 
        if($type == 'Sw\Arc2Bundle\Triples\URI')
            return 'uri'; 
        if($type == 'Sw\Arc2Bundle\Triples\Triple')
            return 'bnode';
    }
}