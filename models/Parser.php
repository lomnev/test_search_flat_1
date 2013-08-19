<?php

class Parser {
    protected $metroArray = [];
    protected $rawItemsArray = [];
    protected $resultsArray = [];

    public function getMetroArrayFromSearchPageHtml($html) {
        phpQuery::newDocument($html);
        $i = 0;
        foreach (pq('select#metro option') as $opt) {
            $this->metroArray[$i]['metro_value'] = pq($opt)->val();
            $this->metroArray[$i]['metro_title'] = pq($opt)->text();
            $i++;
        }
        return $this->metroArray;
    }

    public function getResultsArrayFromResultsPageHtml($html) {
        $this->getRawItemsArray($html);
        return $this->getProcessedRawItemsArray();
    }

    public function getRawItemsArray($html) {
        phpQuery::newDocument($html);
        $i = 0;
        foreach (pq('table.results tr[class^="bg"]') as $item) {
            foreach (pq($item)->find('td') as $td) {
                $this->rawItemsArray[$i][] = iconv('windows-1251', 'utf-8', pq($td)->html());
            }
            $i++;
        }
    }

    public function getProcessedRawItemsArray() {
        $i = 0;
        foreach ($this->rawItemsArray as $row) {
            $tempArray = [];
            $tempArray['flat_count'] = $this->dashesIfEmpty($row[1]);
            if (strlen($tempArray['flat_count']) > 2) {
                continue;//кривая верстка некоторых результатов
            }
            $tempArray['address'] = $this->dashesIfEmpty($this->removeTags($row[2]));
            $tempArray['metro'] = SHOW_METRO ? $this->getMetroFromSiteByUrl($row[2]) : '--';
            $tempArray['floor'] = $this->dashesIfEmpty($row[3]);
            $tempArray['house_type'] = $this->dashesIfEmpty($this->removeTags($row[4]));

            $sTotal = $this->dashesIfEmpty($row[5]);
            $sZhil = $this->dashesIfEmpty($row[6]);
            $sKitchen = $this->dashesIfEmpty($row[7]);
            $tempArray['s_string'] = $sTotal . ' / ' . $sZhil . ' / ' . $sKitchen;

            $tempArray['s_uzel'] = $this->dashesIfEmpty($row[8]);
            $tempArray['subject'] = $this->dashesIfEmpty($this->removeTags($row[11]));
            $tempArray['contact'] = $this->dashesIfEmpty($row[12]);
            $tempArray['additional'] = (strlen($row[13]) > 2)?$row[13]:'--';
            $tempArray['price'] = $this->dashesIfEmpty($this->removeTags($row[9]));

            $this->resultsArray[$i] = $tempArray;
            $i++;
        }
        return $this->resultsArray;
    }

    public function getMetroFromSiteByUrl($oneItemUrl) {
        $url = $this->getItemUrlFromAddressString($oneItemUrl);
        $oneItemPageHtml = (new CurlEngine)->getOneItemPageHtml($url);
        return $this->getMetroFromItemPageHtml($oneItemPageHtml);
    }

    protected function getItemUrlFromAddressString($address) {
        preg_match('/(href=[\'"])([^\'"]+)([\'"][^<>]*>)/', $address, $matches);
        return TARGET_HOST_URL . $matches[2];
    }

    protected function removeTags($oldString) {
       return preg_replace('/<[^>]*>/', '', $oldString);
    }

    protected function dashesIfEmpty($string) {
       return (strlen($string) > 0) ? $string : '--';
    }

    protected function getMetroFromItemPageHtml($html) {
        phpQuery::newDocument($html);
        return (iconv('windows-1251', 'utf-8', pq('.kvart_left > table tr:nth-child(6) td:nth-child(2)')->html()));
    }
}







