<?php


class Car {
    public $make;
    public $modelyear;
    public $issue_miles;
    public $suffix1;
    public $suffix2;
    public $age_in_months;
    private $coverageInfo;
    private $base_warranty;

    public function __construct($make, $modelyear, $issue_mileage, $suffix1, $suffix2) {
        $this->make = $make;
        $this->modelyear = $modelyear;
        $this->issue_miles = $issue_mileage;
        $this->suffix1 = $suffix1;
        $this->suffix2 = $suffix2;
        $this->age_in_months = $this->get_vehicle_age_months();
        $this->coverageInfo = $this->get_coverageInfo();#TODO naming
        $this->base_warranty = $this->get_base_warranty();
    }
    private function get_vehicle_age_months() {
        $current_year = date("Y");
        $current_month = date("m");
        #TODO CFREE NOTE: per Greg, this can be calculated without regard to the date sold.
        return (($current_year - $this->modelyear) * 12) + $current_month;
    }

    private function get_coverageInfo() {
        $contents = file_get_contents('coverageInfo.json');
        $coverage_info = json_decode($contents, true)['coverage'];
        return $coverage_info;
    }

    public function validate_warranties() {
        foreach ($this->coverageInfo as $warranty) {
            #eoc_age: age of vehicle in months at the end of this warranty
            $eoc_age = $this->age_in_months + $warranty['terms'];
            #eoc_miles: miles at the end of this warranty
            $eoc_miles = $this->issue_miles + $warranty['miles'];
            $reasons = array();

            # test for rule 1
            if ($eoc_age > 147) {#test for rule 1
                $reasons[] = '(Rule 1) Term expires before warranty';
            }
            
            # test for rule 2
            if ($eoc_miles > 153000) {
                $reasons[] = '(Rule 2) Miles expires before warranty';
            }

            # only test for rule 3 IF car is still under baseline warranty.
            if ($this->age_in_months > $this->base_warranty['term'] or $this->issue_miles > $this->base_warranty['miles']) {
                if ( $eoc_age < $this->base_warranty['term'] or $eoc_miles < $this->base_warranty['miles'] ) {
                    $reasons[] = '(Rule 3) Coverage would not extend past baseline warranty.';
                }
            }

            $result = empty($reasons) ? 'SUCCESS' : 'FAILURE';
            $reasons = $result == 'SUCCESS' ? array('This Warranty Meets All Validation Criteria') : $reasons;

            yield array($warranty, $result, $reasons, $this->suffix1, $this->suffix2);
        }
    }

    private function get_base_warranty() {
        $base_warranty = array(
            array("make" => "BMW", "term" => 36, "miles" => 48000),
            array("make" => "Volkswagen", "term" => 72, "miles" => 100000)
        );
        foreach ($base_warranty as $entry) {
            if ($entry['make'] === $this->make) {
                return $entry;
            }
        }
        throw new \InvalidArgumentException("No Base warranty found for make: " . $this->make);
    }

    public function is_new() {
        return $this->issue_miles <= $this->base_warranty['miles'] && $this->age_in_months <= $this->base_warranty['term'];
    }
}

?>