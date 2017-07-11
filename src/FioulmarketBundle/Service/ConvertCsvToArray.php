<?php

namespace FioulmarketBundle\Service;

/**
 * Description of ConvertCsvToArray
 *
 * @author user
 */
class ConvertCsvToArray {

    /**
     * 
     * @param string $filename
     * @param string $delimiter
     * @return array
     */
    public function convert($filename, $delimiter = ',') {

        if (!file_exists($filename) || !is_readable($filename)) {
            return FALSE;
        }

        $header = NULL;
        $data = array();

        if (($handle = fopen($filename, 'r')) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
        return $data;
    }

}
