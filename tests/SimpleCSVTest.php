<?php
/**
 * Created by PhpStorm.
 * User: jeti
 * Date: 26.03.15
 * Time: 15:00
 */

class SimpleCSVTest extends \PHPUnit_Framework_TestCase {

    public function testsimplecsv_load_file()
    {
        $simpleCSV = new SimpleCSV\SimpleCSV();
        $objectFromFile = $simpleCSV->simplecsv_load_file('test.csv');
        $testArray = array(
            (object)array(
                'Spalte1' => 'Zelle11',
                'Spalte2' => 'Zelle12',
            ),
            (object)array(
                'Spalte1' => 'Zelle21',
                'Spalte2' => 'Zelle22',
            )
        );

        $this->assertEquals($objectFromFile, $testArray);
    }
}
