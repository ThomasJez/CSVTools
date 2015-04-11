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

    public function vCard2Csv($vcfName, $csvName)
    {
        $cardFile = fopen($vcfName, 'r');
        $vCardTemplate = array();
        while (($data = fgets($cardFile)) !== FALSE) {
            $data = rtrim($data);
            if (in_array($data, array('BEGIN:VCARD', 'END:VCARD'))) {
                continue;
            }
            $dataArray = explode(':', $data);
            if ($dataArray[0] === 'VERSION') {
                continue;
            }
            $vCardTemplate[str_replace(';', ' ', $dataArray[0])] = '';
        }
//var_dump(($cardKeys));
        fclose($cardFile);

        $csvFile = fopen($csvName, 'w');
        fputcsv($csvFile, array_keys($vCardTemplate));
        $cardFile = fopen($vcfName, 'r');
        $cardList = array();
        while (($data = fgets($cardFile)) !== FALSE) {
            $data = rtrim($data);
            if ($data === 'BEGIN:VCARD') {
                $vCard = $vCardTemplate;
                continue;
            }
            if ($data === 'END:VCARD') {
                $cardList[] = $vCard;
                fputcsv($csvFile, $vCard);
                continue;
            }
            $dataArray = explode(':', $data);
            if ($dataArray[0] === 'VERSION') {
                continue;
            }
            $vCard[str_replace(';', ' ', $dataArray[0])] = str_replace(';', ' ', $dataArray[1]);
        }
        var_dump(($cardList));
        fclose($cardFile);
        fclose($csvFile);
    }
}
