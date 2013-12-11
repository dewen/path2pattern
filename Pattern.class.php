<?php

/**
 * NAME: 
 *      Pattern
 *
 *  DESCRIPTION:
 *
 *      Pattern class represents a valid pattern. Providing method to match 
 *      paths.
 *
 */
class Pattern 
{
    const PCRE_DELIMITER = '|';

    protected $_pattern = '';

    /**
     * constructor
     *
     * @param   $str    path string
     */
    public function __construct($str)
    {
        $this->_pattern = trim($str);
    }

    public function getPattern()
    {
        return $this->_pattern;
    }

    /**
     * match given path
     *
     * @param       $path       string      Path name
     * @param       $type       string      algorithm type, default to PCRE 
     *                                      (perl compatible regexp), more 
     *                                      advanced algorithm could be used 
     *                                      here for faster pattern match
     *
     * @return      boolean     true: path matchs
     */
    public function match(Path $path, $type = 'PCRE')
    {
        $result = false;
        switch($type){
            case 'PCRE':
                $result = $this->_pregMatch($path);
                break;
            default:
                throw Exception('Invalid RegExp type');
        }

        return $result;
    }

    public function getPcrePattern()
    {
        return $this->_getPcrePattern();
    }

    //* implementation

    protected function _pregMatch(Path $path)
    {   
        $pcre = $this->_getPcrePattern();

        return preg_match($pcre, $path->getPath());
    }

    protected function _getPcrePattern()
    {   
        return self::PCRE_DELIMITER . '^' . str_replace(array(',','*'), array('/', '[^/]+'), $this->_pattern) . '$'. self::PCRE_DELIMITER;
    }
}
