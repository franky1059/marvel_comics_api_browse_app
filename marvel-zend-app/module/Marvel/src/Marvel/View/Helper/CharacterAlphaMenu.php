<?php

namespace Marvel\View\Helper;

use Zend\View\Helper\AbstractHelper;

class CharacterAlphaMenu extends AbstractHelper
{
    protected $count = 0;

    public function __invoke()
    {
        foreach (range('A', 'Z') as $char) { 
            ?>
            <a href="javascript:void(0)" id="alpha_menu_item_<?php echo $char; ?>" name="alpha_menu_item_<?php echo $char; ?>" char_letter="<?php echo $char; ?>" ajax_url="<?php echo $this->view->url('marvel', array('action' => 'getentries', 'id' => $char)); ?>" marvel_comics_by_character_url="<?php echo $this->view->url('marvel', array('action' => 'comicbycharacter')); ?>" class="alpha_menu_item" >
            <?php
            echo $char . "\n";
            ?>
            </a>
            <?php
        } 
    }
}



?>