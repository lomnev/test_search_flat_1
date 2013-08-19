<?php
class Page {

    public $dataProvider;

    public function __construct($dataProvider = false) {
        $this->dataProvider = $dataProvider;
    }

    public function render($view) {
        return require "views/$view.php";
    }

}