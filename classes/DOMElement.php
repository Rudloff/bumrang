<?php 
/**
 * NewDOMElement class
 * 
 * PHP version 5.3.10
 * 
 * @category PHP
 * @package  Bumrang
 * @author   Pierre Rudloff <rudloff@strasweb.fr>
 * @license  New BSD License http://opensource.org/licenses/BSD-3-Clause
 * @link     http://svn.strasweb.fr
 * */
 
 /**
  * Class used to extend DOMElement
  * 
  * @category PHP
 * @package  Bumrang
 * @author   Pierre Rudloff <rudloff@strasweb.fr>
 * @license  New BSD License http://opensource.org/licenses/BSD-3-Clause
 * @link     http://svn.strasweb.fr
  * */
class NewDOMElement extends DOMElement
{
    
    /**
     * Add an element
     * 
     * @param string $tag        Tag name
     * @param string $value      Inner text
     * @param array  $attributes List of attributes
     * 
     * @return NewDOMElement
     * */
    function addElement($tag, $value=null, $attributes=array())
    {
        global $dom;
        $this->$tag=$dom->createElement($tag);
        if (isset($value)) {	
            $this->$tag->nodeValue=$value;
        }
        foreach ($attributes as $attr => $value) {
            $attr=strtolower($attr);
            $this->$tag->setAttribute($attr, $value);
            if ($attr=="id") {
                $this->$tag->setIdAttribute("id", true);
            }
        }
        $this->appendChild($this->$tag);
        return($this->$tag);
    }
    
    
}


?>
