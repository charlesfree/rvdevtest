<?php
//Simple script to quickly validate one car (make, model, year, ...)
require_once 'car.php';

$car = new Car('Volkswagen', '2023', 99000, 2, 'B');

$is_new = $car->is_new() ? "New" : "Used";
$make = $car->make;
$year = $car->modelyear;
$miles = $car->issue_miles;
$age = $car->age_in_months;
$suffix1 = $car->suffix1;
$suffix2 = $car->suffix2;

// check newness
print("this car is " . $age . " months old\n");

foreach ($car->validate_warranties() as $data) {
    $warranty_name = $data[0]['name'];
    $result = $data[1];
    $reasons = implode("', '", $data[2]);
    $message = "$make  $year  $miles $is_new  $warranty_name  suffix1:$suffix1  suffix2:$suffix2  RESULT:  $result  array($reasons)";
    
    print($message . "\n");
}

?>