<?php

class CurlEngine {

    public $userAgent = 'Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.16';

    public function getPageHtmlByUrl($url) {
        return $this->performCurlGetRequestByUrl($url);
    }

    public function getResultsPageHtml($url) {
        return $this->performCurlGetRequestByUrl($url);
    }

    public function getOneItemPageHtml($url) {
        return $this->performCurlGetRequestByUrl($url);
    }

    protected function performCurlGetRequestByUrl($url) {
        $process = curl_init($url);
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        curl_setopt($process, CURLOPT_USERAGENT, $this->userAgent);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($process, CURLOPT_REFERER, SEARCH_PAGE_URL);
        $result = curl_exec($process);
        curl_close($process);
        return $result;
    }

}
