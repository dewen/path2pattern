<?php

/**
 * NAME: 
 *      Path
 *
 *  DESCRIPTION:
 *
 *      - Path class represents a valid path  
 *
 */
class Path 
{
    protected $_path = '';

    /**
     * constructor
     *
     * @param   $str    path string
     */
    public function __construct($str)
    {
        $this->_path = $this->_clean($str);
    }

    /**
     * return the path value
     *
     * @return   string
     */
    public function getPath()
    {
        return $this->_path;
    }

    /**
     * match the current path with give pattern 
     *
     * @return   bool
     */
    public function match(Pattern $pattern)
    {
        return $pattern->match($this->path);
    }

    //* implementation
    
    /**
     * remove whitespace and slash chars
     *
     * slash char is ignorable
     */
    protected function _clean($str) 
    {
        return trim($str, " \t\n\r\0\x0B/");
    }
}

