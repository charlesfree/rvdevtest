<?php
/**
 * PHP Developer Test 17
 *
 * Test a developers ability to create a class along with supporting methods.
 * Test a developers ability to create unit tests to validate each methods logic.
 *
 * INSTRUCTIONS:
 * --------------------------------------------------------------------
 * Write a class which will validate if a vehicle can carry any of the warranty coverages in the $coverage array
 *
 * Rules:
 * rule1 Book of Contracts should not have active contracts on vehicles where the mileage on the vehicle is > 153,000 miles before contract expires.
 * rule2 Book of Contracts should not have active contracts on vehicles who's age is more than 12 years old + 3 months (147 months) before contract expires.
 * rule3 Contract coverage should not be available if the term and miles of the coverage expire before the base warranty of the vehicle has expired.
 *#TODO: CFNOTE: NOTE: so if i have a BMW (48000bwm) with 29000 miles, there are 19000 before expiry. if this warranty is less than 19000, it fails.
 *#TODO: CFNOTE: NOTE: so if i have a BMW (36bwm) that is 42 months old, the baseline warranty has already expired. this will not cause a failure.

 * Test will validate each vehicle make in the $base_warranty array, each model year of the make in the $years array, and every issue mileage
 * between 0 and 150,000 in 1,000 mile increments. 
 * 
 * #TODO: CFREE NOTE i could just slap the suffixes into the car when I'm creating it -- which would make sense, since they are based on years and mileage.
 *
 * Additionally, a "New" or "Used" flag will be assigned to the output based on the vehicle issue mileage where if the issue mileage falls within the
 * base warranty, "New" value is assigned, otherwise a "Used" value is assigned.
 * #TODO: CFREE NOTE i used BOTH car age AND issue mileage to check against the base warranty for new or used.
 *
 * Output the following: make, model year, issue mileage, New or Used, coverage name, suffix1 (as a 2 digit zero fill left padded number),
 * suffix2 and success/failure, indicating the reason for the failure. Failure message should include all validation failures.
 *
 * Example (for demonstration purposes):
 *  Test Values: make: BMW, model year: 2018, issue mileage: 1000; testing coverage: "3 Months/3,000 Miles"
 *  Example Output: BMW  2018  1000  NEW  "3 Months/3,000 Miles"  suffix1:00  suffix2:A  RESULT: FAILURE array('Term expires before warranty', 'Miles expires before warranty');
 *
 *  Test Values: make: BMW, model year: 2018, issue mileage: 1000; testing coverage: "100 Months/120,000 Miles"
 *  Example Output: BMW  2018  1000  NEW  "100 Months/120,000 Miles"  suffix1:00  suffix2:A  RESULT: SUCCESS
 *
 * Convert the $coverage array to a json file, simulate an API call in a private method to pull the json file to create the coverage array.
 *
 * Make this a self contained script executable from a linux command line.
 *
 * phpunit test should be included as a separate file.
 *
 * Do not use built-in libraries or frameworks.
 *
 */



// Vehicle classification code based on make/model.
$classes = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15);

// Assumed base warranty of the vehicle make being tested. Both makes should be tested
$base_warranty = array(
    array("make" => "BMW", "term" => 36, "miles" => 48000),
    array("make" => "Volkswagen", "term" => 72, "miles" => 100000)
);

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
// warranty coverage options
// terms = maximum length of time (in months) the contract is in force from the time of sale
// miles = maximum number of miles the warranty is in effect from the time of sale
$coverage = array(
    array("name" => "3 Months/3,000 Miles", "terms" => 3, "miles" => 3000),
    array("name" => "6 Months/12,000 Miles", "terms" => 6, "miles" => 12000),
    array("name" => "12 Months/24,000 Miles", "terms" => 12, "miles" => 24000),
    array("name" => "24 Months/30,000 Miles", "terms" => 24, "miles" => 30000),
    array("name" => "24 Months/36,000 Miles", "terms" => 24, "miles" => 36000),
    array("name" => "36 Months/36,000 Miles", "terms" => 36, "miles" => 36000),
    array("name" => "36 Months/45,000 Miles", "terms" => 36, "miles" => 45000),
    array("name" => "36 Months/50,000 Miles", "terms" => 36, "miles" => 50000),
    array("name" => "48 Months/50,000 Miles", "terms" => 48, "miles" => 50000),
    array("name" => "48 Months/60,000 Miles", "terms" => 48, "miles" => 60000),
    array("name" => "60 Months/72,000 Miles", "terms" => 60, "miles" => 72000),
    array("name" => "60 Months/75,000 Miles", "terms" => 60, "miles" => 75000),
    array("name" => "72 Months/100,000 Miles", "terms" => 72, "miles" => 100000),
    array("name" => "84 Months/84,000 Miles", "terms" => 84, "miles" => 84000),
    array("name" => "84 Months/96,000 Miles", "terms" => 84, "miles" => 96000),
    array("name" => "100 Months/100,000 Miles", "terms" => 100, "miles" => 100000),
    array("name" => "100 Months/120,000 Miles", "terms" => 100, "miles" => 120000),
    array("name" => "120 Months/120,000 Miles", "terms" => 120, "miles" => 120000)
);
