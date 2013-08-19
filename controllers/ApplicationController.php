<?php

class Application {

    public $configuration;

    public function __construct($configurationFile) {
        $this->configuration = parse_ini_file($configurationFile);
        define('SHOW_METRO', $this->configuration['show_metro']);
        define('TARGET_HOST_URL', $this->configuration['target_host_url']);
        define('SEARCH_PAGE_URL', $this->configuration['search_page_url']);
        define('RESULTS_PAGE_URL', $this->configuration['results_page_url']);
        session_start();
    }

    public function run() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processSearchRequest();
        } else {
            $this->renderMainPage();
        }
    }

    protected function processSearchRequest() {
        $resultsArray = (new SearchRequest)->getResultsArray();
        if ($this->isAjaxRequest()) {
            (new Page($resultsArray))->render("_results_partial");
        } else {
            $this->renderMainPage();
        }
    }

    protected function renderMainPage() {
        $metroArray = (new Metro)->getMetroArray();
        (new Page($metroArray))->render("main_page");
    }

    protected function isAjaxRequest() {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }
}