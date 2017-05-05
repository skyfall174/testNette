<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HeaderComponent
 *
 * @author nood7
 */
class HeaderComponent extends \Nette\Application\UI\Control {

    public $description;

    function __construct($name) {
        $this->description = $name;
    }

    public function handlerRefreshState($name){
        $this->redrawControl();
        
    }
    
    public function render() {
        $this->template->setFile(__DIR__ . "/header.latte");
        $this->template->description = $this->description;
        $this->template->render();
    }

}
