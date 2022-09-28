<?php

namespace App\Http\Base;

use yii\base\Action;

class BaseAction extends Action
{
    private string $defaultErrorMessage = 'Ошибка обработки запроса, повторите попытку позже';

    protected function responseError(?string $text, int $httpCode = 400)
    {
        $this->setStatusCode($httpCode);
        return $this->asJson(['result' => 'error', 'message' => $text ?: $this->defaultErrorMessage, 'code' => $httpCode, 'data' => null]);
    }

    protected function responseSuccess($data, int $httpCode = 200)
    {
        $this->setStatusCode($httpCode);
        return $this->asJson(['result' => 'success', 'data' => $data, 'code' => $httpCode]);
    }

    private function asJson(array|\JsonSerializable $response)
    {
        return $this->controller->asJson($response);
    }

    private function setStatusCode(int $httpCode)
    {
        $this->controller->response->statusCode = $httpCode;
    }

}