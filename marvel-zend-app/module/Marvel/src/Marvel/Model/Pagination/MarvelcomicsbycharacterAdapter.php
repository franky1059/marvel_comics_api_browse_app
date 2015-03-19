<?php

namespace Marvel\Model\Pagination;

use Zend\Paginator\Adapter\AdapterInterface;

/**
 * @category   Zend
 * @package    Paginator
 */
class MarvelcomicsbycharacterAdapter implements AdapterInterface
{
    /**
     * MarvelcomicsbycharacterAdapter
     *
     * @var array
     */
    protected $array = null;
    
    /**
     * Item count
     *
     * @var integer
     */
    protected $count = null;
    
    public $character_id = 0;

    /**
     * Constructor.
     *
     * @param array $array ArrayAdapter to paginate
     */
    public function __construct($character_id)
    {
        $this->array = array();
        $this->character_id = $character_id;
        $results_with_no_limit = $this->getComicsByCharacter(0, 0);
        $this->count = count($results_with_no_limit);
    }

    /**
     * Returns an array of items for a page.
     *
     * @param  integer $offset Page offset
     * @param  integer $itemCountPerPage Number of items per page
     * @return array
     */
    public function getItems($offset, $itemCountPerPage)
    {
        $results = array();        
        $results = $this->getComicsByCharacter($offset, $itemCountPerPage);        
    
        return $results;
    }

    /**
     * Returns the total number of rows in the array.
     *
     * @return integer
     */
    public function count()
    {
        return $this->count;
    }
    
    public function getComicsByCharacter($offset, $itemCountPerPage)
    {
        $results = array();
        
        if ($this->character_id) {
            $offset_arg = '';
            if ($offset) {
                $offset_arg = '&offset='.$offset;
            }
            
            $limit_arg = '';
            if ($itemCountPerPage) {
                $limit_arg = '&limit='.$itemCountPerPage;
            }
            
            $character_info_url = 'http://api.marvel.com/browse/digitalcomics/print?byType=character&byId='.$this->character_id.$offset_arg.$limit_arg;
            
            $character_info_results = json_decode(\Marvel\Utility\CurlUtility::curl_download($character_info_url, $headers['Host']));                    
            
            if ($character_info_results) {
                if($character_info_results->data) {
                    if ($character_info_results->data->results) {
                        $results = $character_info_results->data->results;
                    }
                }
            }
        } 

        if (FM_DEBUG) {
        // FM Debug
        echo "<pre>";
        print_r("File: ".__FILE__);
        echo "<br />";
        print_r("Line: ".__LINE__);
        echo "<br />";		  
        print_r("Inside ".__METHOD__." of class ".__CLASS__); 
        echo "<br />\$results: <br />";
        print_r($results);
        echo "<br />";
        echo "<br />";
        echo "</pre>";
        }         

        return $results;
    }
      
}

