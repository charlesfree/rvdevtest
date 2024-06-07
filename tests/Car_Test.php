<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../car.php';

final class Car_Test extends TestCase {
    public function testCarConstructor(): void {
        $make = 'BMW';
        $modelyear = '2020';
        $issue_mileage = 33000;
        $suffix1 = 2;
        $suffix2 = 'B';
        $car = new Car($make, $modelyear, $issue_mileage, $suffix1, $suffix2);

        $this->assertSame($make, $car->make);
        $this->assertSame($modelyear, $car->modelyear);
        $this->assertSame($issue_mileage, $car->issue_miles);
        $this->assertSame($suffix1, $car->suffix1);
        $this->assertSame($suffix2, $car->suffix2);
    }

    #[DataProvider('bunchOfOldNewCars')]
    public function testIsNewFunction($make, $modelyear, $issue_mileage, $suffix1, $suffix2, $expected) {
        $car = new Car($make, $modelyear, $issue_mileage, $suffix1, $suffix2);

        $this->assertSame($car->is_new(), $expected);
    }

    #[DataProvider('bunchOfCars')]
    public function testValidateWarranties($make, $modelyear, $issue_mileage, $suffix1, $suffix2, $expected) {
        //This test is a placeholder. Since validate_warranties() is a generator,
        //I will have to research the best way to validate the results.
        $car = new Car($make, $modelyear, $issue_mileage, $suffix1, $suffix2);
        $this->assertSame($car->suffix1, $expected);

    }

    public static function bunchOfOldNewCars(): array {
        return [
            //data to create old and new cars, with expected result appended to each
            //TODO: abstract the date to pinpoint the edge cases
            ['BMW', '2007', 3000, 2, 'B', false], //false = old
            ['BMW', '2023', 35999, 2, 'B', true], //true = new
            ['Volkswagen', '2023', 99000, 2, 'B', true],
            ['Volkswagen', '2021', 33000, 2, 'B', true],
            ['Volkswagen', '2012', 33000, 2, 'B', false]
        ];
    }
    public static function bunchOfCars(): array {
        return [
            ['BMW', '2007', 3000, 2, 'B', 2], 
            // ['BMW', '2023', 35999, 2, 'B', 'FAILURE'],
            // ['Volkswagen', '2023', 99000, 2, 'B', 'FAILURE'],
            // ['Volkswagen', '2021', 33000, 2, 'B', 'SUCCESS'],
            // ['Volkswagen', '2012', 33000, 2, 'B', 'FAILURE']
        ];
    }
}
