<?php
namespace Marvel\Controller;

use Zend\Log\Writer\Stream;
use Zend\Log\Logger;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Marvel\Model\Pagination\MarvelcomicsbycharacterAdapter;

class MarvelController extends AbstractActionController
{
    protected $albumTable;
    
    public function indexAction()
    {
        $config = $this->getEvent()->getApplication()->getConfig();
        
        if (FM_DEBUG) {
        // FM Debug
        echo "<pre>";
        print_r("File: ".__FILE__);
        echo "<br />";
        print_r("Line: ".__LINE__);
        echo "<br />";		  
        print_r("Inside ".__METHOD__." of class ".__CLASS__); 
        echo "<br />\$this->layout(): <br />";
        print_r($this->layout());
        echo "<br />";
        echo "<br />";
        echo "</pre>";
        }  

        /*
        $stream = fopen('/var/www/html/marvel/zend/logfile', 'w', false);
        print_r($stream);
        if (! $stream) {
            throw new Exception('Failed to open stream');
        }

        $writer = new Stream($stream);
        $logger = new Logger();
        $logger->addWriter($writer);

        $logger->info(print_r($this, true));   
        */
        
    }
    
    
    public function getentriesAction()
    {
        $starting_letter = $this->params()->fromRoute('id', 0);
        
        $view = new ViewModel(array(
            'entries_exist' => false,
        ));
        $view->setTerminal(true);
        
        $headers = $this->params()->fromHeader(); 
        
        if ($starting_letter) {
            $character_browse_url = 'http://api.marvel.com/browse/characters?startsWith='.$starting_letter.'&byType=digital-comics&limit=100';
            
            $character_browse_results = \Marvel\Utility\CurlUtility::curl_download($character_browse_url, $headers['Host']);

            if ($character_browse_results) {
                $view->setVariable('entries_exist', true);
                
                $view->setVariable('character_browse_results', $character_browse_results);                
            }
        }
        
        return $view;  
    }
    
    
    public function comicbycharacterAction()
    {
        $character_id = (int)$this->params()->fromRoute('id', 0);
        $page = (int)$this->params()->fromRoute('page', 0);  

        $paginator = $this->getComicByCharacterPaginator($page, $character_id);
    
        if (FM_DEBUG) {
        // FM Debug
        echo "<pre>";
        print_r("File: ".__FILE__);
        echo "<br />";
        print_r("Line: ".__LINE__);
        echo "<br />";		  
        print_r("Inside ".__METHOD__." of class ".__CLASS__); 
        echo "<br />\$this->paginationControl: <br />";
        print_r($this->paginationControl);
        echo "<br />";
        echo "<br />";
        echo "</pre>";
        }    

        $vm = new ViewModel();
        
        $gridView = new ViewModel();
        $gridView->setVariable('paginator', $paginator);
        $gridView->setVariable('character_id', $character_id);
        $gridView->setTemplate('marvel/marvel/comicbycharacter_ajax');
        
        $vm->addChild($gridView, 'gridView');
        
        return $vm;
    }
    
    public function comicbycharacterajaxAction()
    {
        $character_id = (int)$this->params()->fromRoute('id', 0);
        $page = (int)$this->params()->fromRoute('page', 0);  

        $paginator = $this->getComicByCharacterPaginator($page, $character_id);
        
        $vm = new ViewModel();
        $vm->setTerminal(true);
        $vm->setTemplate('marvel/marvel/comicbycharacter_ajax');
        $vm->setVariable('paginator', $paginator);
        $vm->setVariable('character_id', $character_id);
        return $vm;
    }

    
    public function getComicByCharacterPaginator($page, $character_id)
    {
        $paginator = new \Zend\Paginator\Paginator(new MarvelcomicsbycharacterAdapter($character_id));
        $paginator->setItemCountPerPage(20);
        $paginator->setCurrentPageNumber($page); 

        return $paginator;
    }
    
    

    public function characterAction()
    {
    
        $headers = $this->params()->fromHeader();        

        $character_id = (int)$this->params()->fromRoute('id', 0);
        
        $view = new ViewModel(array(
            'entries_exist' => false,
        ));
        $view->setTemplate('marvel/marvel/character');
                
        
        if ($character_id) {            
            $character_info_url = 'http://api.marvel.com/browse/digitalcomics/print?byType=character&byId='.$character_id.'&offset=0';
            
            $character_info_results = json_decode(\Marvel\Utility\CurlUtility::curl_download($character_info_url, $headers['Host']));                    
            
            if ($character_info_results) {
                if($character_info_results->data) {
                    if ($character_info_results->data->results) {
                        $view->setVariable('entries_exist', true);
                        
                        $view->setVariable('character_info_results', $character_info_results->data->results);                
                    }
                }
            }
        }
        
        return $view;    
    }
    
}




?>