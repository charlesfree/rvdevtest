<?php

require_once 'car.php';

// vehicle model years to test
$years = array(
    array("modelyear" => 2007, "suffix1" => 15),
    array("modelyear" => 2008, "suffix1" => 14),
    array("modelyear" => 2009, "suffix1" => 13),
    array("modelyear" => 2010, "suffix1" => 12),
    array("modelyear" => 2011, "suffix1" => 11),
    array("modelyear" => 2012, "suffix1" => 10),
    array("modelyear" => 2013, "suffix1" => 9),
    array("modelyear" => 2014, "suffix1" => 8),
    array("modelyear" => 2015, "suffix1" => 7),
    array("modelyear" => 2016, "suffix1" => 6),
    array("modelyear" => 2017, "suffix1" => 5),
    array("modelyear" => 2018, "suffix1" => 4),
    array("modelyear" => 2019, "suffix1" => 3),
    array("modelyear" => 2020, "suffix1" => 2),
    array("modelyear" => 2021, "suffix1" => 1),
    array("modelyear" => 2022, "suffix1" => 0),
    array("modelyear" => 2023, "suffix1" => 0));

// mileage of the vehicle at the time the contract is rated
$issue_mileage = array(
    array("min" => 0, "max" => 12000, "suffix2" => "A"),
    array("min" => 12001, "max" => 24000, "suffix2" => "A"),
    array("min" => 24001, "max" => 36000, "suffix2" => "B"),
    array("min" => 36001, "max" => 48000, "suffix2" => "C"),
    array("min" => 48001, "max" => 60000, "suffix2" => "D"),
    array("min" => 60001, "max" => 72000, "suffix2" => "E"),
    array("min" => 72001, "max" => 84000, "suffix2" => "F"),
    array("min" => 84001, "max" => 96000, "suffix2" => "G"),
    array("min" => 96001, "max" => 108000, "suffix2" => "H"),
    array("min" => 108001, "max" => 120000, "suffix2" => "I"),
    array("min" => 120001, "max" => 132000, "suffix2" => "J"),
    array("min" => 132001, "max" => 144000, "suffix2" => "K"),
    array("min" => 144001, "max" => 150000, "suffix2" => "L")
);

#TODO: This should not be in two places. maybe add all of these arrays to the json file
$base_warranty = array(
    array("make" => "BMW", "term" => 36, "miles" => 48000),
    array("make" => "Volkswagen", "term" => 72, "miles" => 100000)
);

foreach ($base_warranty as $mbw) {#mbw = manufacturer's base warranty
    foreach ($years as $year) {
        for ($miles = 10000; $miles <= 150000; $miles += 1000) {
            $suffix1 = $year['suffix1'];
            $suffix2 = getSuffix2($miles);

            $car = new Car($mbw['make'], $year['modelyear'], $miles, $suffix1, $suffix2);
            $is_new = $car->is_new() ? "New" : "Used";

            foreach ($car->validate_warranties() as $data) {
                $warranty_name = $data[0]['name'];
                $result = $data[1];
                $reasons = implode("', '", $data[2]);
                $carMake = $car->make;
                $carModelyear = $car->modelyear;
                $carIssueMiles = $car->issue_miles;
                $message = "$carMake $carModelyear  $carIssueMiles  $is_new  $warranty_name  suffix1:$suffix1  suffix2:$suffix2  RESULT: $result array($reasons)";
                //$message = "$carMake  $carModelyear  $carIssueMiles  $is_new  $warranty_name  " .
                            "suffix1:$suffix1  suffix2:$suffix2  RESULT: $result array($reasons)";

                print($message . "\n");
            }
            unset($car); //make sure each car object is destroyed
        }
    }
}

function getSuffix2($miles) {
    global $issue_mileage;
    
    foreach ($issue_mileage as $mileage_range) {
        if ($miles >= $mileage_range['min'] && $miles <= $mileage_range['max']) {
            return $mileage_range['suffix2'];
        }
    }
    return "None";
}

// // Vehicle classification code based on make/model.
$classes = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15);

// vehicle model years to test
$years = array(
    array("modelyear" => 2007, "suffix1" => 15),
    array("modelyear" => 2008, "suffix1" => 14),
    array("modelyear" => 2009, "suffix1" => 13),
    array("modelyear" => 2010, "suffix1" => 12),
    array("modelyear" => 2011, "suffix1" => 11),
    array("modelyear" => 2012, "suffix1" => 10),
    array("modelyear" => 2013, "suffix1" => 9),
    array("modelyear" => 2014, "suffix1" => 8),
    array("modelyear" => 2015, "suffix1" => 7),
    array("modelyear" => 2016, "suffix1" => 6),
    array("modelyear" => 2017, "suffix1" => 5),
    array("modelyear" => 2018, "suffix1" => 4),
    array("modelyear" => 2019, "suffix1" => 3),
    array("modelyear" => 2020, "suffix1" => 2),
    array("modelyear" => 2021, "suffix1" => 1),
    array("modelyear" => 2022, "suffix1" => 0),
    array("modelyear" => 2023, "suffix1" => 0));

// mileage of the vehicle at the time the contract is rated
$issue_mileage = array(
    array("min" => 0, "max" => 12000, "suffix2" => "A"),
    array("min" => 12001, "max" => 24000, "suffix2" => "A"),
    array("min" => 24001, "max" => 36000, "suffix2" => "B"),
    array("min" => 36001, "max" => 48000, "suffix2" => "C"),
    array("min" => 48001, "max" => 60000, "suffix2" => "D"),
    array("min" => 60001, "max" => 72000, "suffix2" => "E"),
    array("min" => 72001, "max" => 84000, "suffix2" => "F"),
    array("min" => 84001, "max" => 96000, "suffix2" => "G"),
    array("min" => 96001, "max" => 108000, "suffix2" => "H"),
    array("min" => 108001, "max" => 120000, "suffix2" => "I"),
    array("min" => 120001, "max" => 132000, "suffix2" => "J"),
    array("min" => 132001, "max" => 144000, "suffix2" => "K"),
    array("min" => 144001, "max" => 150000, "suffix2" => "L")
);

$base_warranty = array(#TODO: Pass $base_warranty into the car
    array("make" => "BMW", "term" => 36, "miles" => 48000),
    array("make" => "Volkswagen", "term" => 72, "miles" => 100000)
);

?>