<?php
/**
 * @author Thomas Jez
 * generates an array of objects from a CSV file
 */
namespace SimpleCSV;

class SimpleCSV {

    /**
     * Constructor still empty
     */
    function __construct()
    {
    }

    /**
     * @param string $fileName
     * @return array
     * @throws \Exception
     */
    public function simplecsv_load_file($fileName)
    {
        if (($csvFile = fopen($fileName, 'r')) === FALSE) {
            throw new \Exception('Couldn\'t open the file');
        }
        $csvArray = array();
        $keys = fgetcsv($csvFile, 2000, ",");
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            $o = array();
            for ($i = 0; $i < count($keys); $i++) {
                $oArray[$keys[$i]] = $data[$i];
            }
            $o = (object)$oArray;
            $csvArray[] = $o;
        }
        fclose($csvFile);
        return $csvArray;
    }
}
