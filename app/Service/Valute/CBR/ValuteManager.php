<?php


namespace App\Service\Valute\CBR;


use App\Models\CBRValute;
use App\Service\Valute\ValuteManager as BaseManager;
use App\Service\Valute\ICalculator;
use App\Service\Valute\ValuteModel;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ValuteManager extends BaseManager
{
    /**
     * @return array
     * @throws GuzzleException
     */
    function getData(): array
    {
        $client = new Client();
        $response = json_decode($client->request('GET', 'https://www.cbr-xml-daily.ru/daily_json.js')->getBody()->getContents(), true);
        $data = [
            [
                'currency' => 'RUB',
                'name' => 'Российский рубль',
                'nominal' => 1,
                'value' => 1
            ]
        ];

        foreach($response['Valute'] as $item) {
            $data[] = [
                'currency' => $item['CharCode'],
                'name' => $item['Name'],
                'nominal' => $item['Nominal'],
                'value' => $item['Value']
            ];
        }
        return $data;
    }

    function getCalculator(): ICalculator
    {
        return new Calculator();
    }

    function getModel(): ValuteModel
    {
        return new CBRValute();
    }
}
