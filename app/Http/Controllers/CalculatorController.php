<?php

namespace App\Http\Controllers;

use App\Service\Valute\IValuteManager;
use App\Service\Valute\ValuteManager;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\CBRValute;

class CalculatorController extends Controller
{
    /** @var IValuteManager  */
    private $manager = null;

    public function __construct()
    {
        $this->manager = ValuteManager::getManager('cbr');
    }

    public function index(Request $request) {
        return view('index');
    }

    public function calc(Request $request) {
        $request->validate([
            'from' => 'required|min:3|max:3',
            'to' => 'required|min:3|max:3',
        ]);
        $value = $request->input('value');

        $fromModel = $this->manager->getModel()->where('currency', $request->input('from'))->first();
        $toModel = $this->manager->getModel()->where('currency', $request->input('to'))->first();

        return [
            'diff' => $this->manager->getCalculator()->currency($fromModel, $toModel),
            'value' => $this->manager->getCalculator()->calculate($value, $fromModel, $toModel)
        ];
    }

    /**
     * @param Request $request
     * @return string
     */
    public function currency(Request $request) {
        /** @var CBRValute $model */
        $model = $this->manager->getModel();
        return $model->orderBy('currency')->get()->toJson();
    }

    /**
     * @param Request $request
     */
    public function update(Request $request) {
        /** @var IValuteManager $manager */
        $data = $this->manager->getData();

        foreach($data as $item) {
            $model = $this->manager->getModel()->where('currency', $item['currency'])->first();
            foreach($item as $field => $value) {
                $model->$field = $value;
            }
            $model->save();
        }

    }

}
