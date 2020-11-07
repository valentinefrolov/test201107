<?php

namespace Tests\Feature;

use App\Service\Valute\ValuteManager;
use Tests\TestCase;

class CalculatorTest extends TestCase
{
    private $manager = null;

    public function setUp() : void
    {
        parent::setUp();
        $this->manager = ValuteManager::getManager('cbr');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCalc()
    {
        /*$from = $this->manager->getModel()->where('currency', 'RUB')->first();
        $to = $this->manager->getModel()->where('currency', 'USD')->first();*/

        $from = $this->manager->getModel();
        $to = $this->manager->getModel();

        $data = [
            [
                1, // value
                70, // from value
                1, // from nominal
                1,  // to value
                1,  // to nominal
                70 // result
            ],

            [
                150, // value
                77, // from value
                1, // from nominal
                91,  // to value
                1,  // to nominal
                126.9 // result
            ],

            [
                10, // value
                16, // from value
                100, // from nominal
                1,  // to value
                1,  // to nominal
                1.6 // result
            ],

            [
                1, // value
                77, // from value
                1, // from nominal
                16,  // to value
                100,  // to nominal
                481.2 // result
            ]

        ];

        foreach($data as $item) {
            $from->value = $item[1];
            $from->nominal = $item[2];

            $to->value = $item[3];
            $to->nominal = $item[4];

            $this->assertTrue($this->manager->getCalculator()->calculate($item[0], $from, $to) - $item[5] <= .1);
        }

    }
}
