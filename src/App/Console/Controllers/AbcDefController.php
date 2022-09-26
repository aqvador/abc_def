<?php

namespace App\Console\Controllers;

use App\Console\Controllers\Actions\AbcDef\ParseResourceAction;
use yii\console\Controller;

class AbcDefController extends Controller
{

    public function actions()
    {
        return [
            'parse-resource' => ParseResourceAction::class
        ];
    }
}