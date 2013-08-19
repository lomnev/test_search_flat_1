<?php

class Metro {

    protected $cacheFile = 'cache/metro_serialized.txt';
    protected $searchPageUrl = SEARCH_PAGE_URL;

    public function getMetroArray() {
        $metroArray = $this->readMetroCashFile();
        if ($metroArray) {
            return $this->prepareMetroArray($metroArray);
        } else {
            $newDataArray = $this->getNewMetroData();
            $this->saveToMetroCashFile($newDataArray);
            return $this->prepareMetroArray($newDataArray);
        }
    }

    protected function saveToMetroCashFile($array) {
        $file = fopen($this->cacheFile, "w+");
        $result = fputs($file, serialize($array));
        fclose($file);
        return $result;
    }

    protected function readMetroCashFile() {
        $contents = file_get_contents($this->cacheFile);
        $cachedArray = unserialize($contents);
        return ($cachedArray && is_array($cachedArray) && count($cachedArray) > 0) ? $cachedArray : false;
    }

    protected function getNewMetroData() {
        return (new Parser)->getMetroArrayFromSearchPageHtml($this->getSearchPageHtml());
    }

    protected function getSearchPageHtml() {
        return (new CurlEngine)->getPageHtmlByUrl($this->searchPageUrl);
    }

    protected function prepareMetroArray($oldArray) {
        $newArray = [];
        $selectedArray = isset($_SESSION['metro']) ? unserialize($_SESSION['metro']) : [];
        $matches = array_unique(array_intersect($oldArray, $selectedArray));
        foreach ($matches as $oneSelected) {
            $selectedArray[] = $oneSelected['metro_value'];
        }
        foreach ($oldArray as $m) {
            if (in_array($m['metro_value'], $selectedArray)) {
                $m['selected'] = 'selected="selected"';
            }
            $newArray[] = $m;
        }
        return $newArray;
    }

}