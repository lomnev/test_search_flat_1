<?php

class SearchRequest {

    public $minFlat = 0;
    public $maxFlat = 8;
    public $minPrice = 1;
    public $maxPrice = 100000;
    public $selectedMetroArray = [-1];
    protected $resultsPageHtml;

    public function __construct() {
        $this->setMinFlat();
        $this->setMaxFlat();
        $this->setMinPrice();
        $this->setMaxPrice();
        $this->setMetroArray();
        $this->updateSession();
    }

    public function getResultsArray() {
        $this->resultsPageHtml = $this->getResultsPageHtml();
        return $this->getParsedResultsArray();
    }

    protected function getResultsPageHtml() {
        return (new CurlEngine)->getResultsPageHtml($this->getRequestUrl());
    }

    protected function getParsedResultsArray() {
        return (new Parser)->getResultsArrayFromResultsPageHtml($this->resultsPageHtml);
    }

    protected function updateSession() {
        $_SESSION['minFlat'] = $this->minFlat;
        $_SESSION['maxFlat'] = $this->maxFlat;
        $_SESSION['minPrice'] = $this->minPrice;
        $_SESSION['maxPrice'] = $this->maxPrice;
        $_SESSION['metro'] = serialize($this->selectedMetroArray);
    }

    protected function setMinFlat() {
        if (isset($_POST['kkv1'])) {
            $this->minFlat = $this->cleanIntValue($_POST['kkv1']);
        } elseif (isset($_SESSION['minFlat'])) {
            $this->minFlat = $_SESSION['minFlat'];
        }
    }

    protected function setMaxFlat() {
        if (isset($_POST['kkv2'])) {
            $this->maxFlat = $this->cleanIntValue($_POST['kkv2']);
        } elseif (isset($_SESSION['maxFlat'])) {
            $this->maxFlat = $_SESSION['maxFlat'];
        }
    }

    protected function setMinPrice() {
        if (isset($_POST['price1'])) {
            $this->minPrice = $this->cleanIntValue($_POST['price1']);
        } elseif (isset($_SESSION['minPrice'])) {
            $this->minPrice = $_SESSION['minPrice'];
        }
    }

    protected function setMaxPrice() {
        if (isset($_POST['price2'])) {
            $this->maxPrice = $this->cleanIntValue($_POST['price2']);
        } elseif (isset($_SESSION['maxPrice'])) {
            $this->maxPrice = $_SESSION['maxPrice'];
        }
    }

    protected function setMetroArray() {
        if (isset($_POST['metro'])) {
            $metroRaw = $_POST['metro'];
            $i = 0;
            foreach ($metroRaw as $m) {
                $this->selectedMetroArray[$i] = $this->cleanIntValue($m);
                $i++;
            }
        } elseif (isset($_SESSION['metro'])) {
            $this->selectedMetroArray = unserialize($_SESSION['metro']);
        }
    }

    protected function cleanIntValue($badValue) {
        return intval(preg_replace('/[^\d-]/', '', $badValue));
    }

    protected function getRequestUrl() {
        $url = RESULTS_PAGE_URL . '?kkv1=' . $this->minFlat . '&kkv2=' . $this->maxFlat;
        $url .= '&price1=' . $this->minPrice . '&price2=' . $this->maxPrice;
        if (count($this->selectedMetroArray) > 0) {
            foreach ($this->selectedMetroArray as $oneMetroId) {
                $url .= '&metro[]=' . $oneMetroId;
            }
        }
        return $url;
    }

}