<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Actions\AbcDef\RegionByNumberAction;
use yii\rest\Controller;

class AbcDefController extends Controller
{
    public function actions()
    {
        return [
            'region-by-number' => RegionByNumberAction::class
        ];
    }
}