<?php

use Util\ConstantesGenericasUtil;
use Util\JsonUtil;
use Util\RotasUtil;
use Validator\RequestValidator;

include 'bootstrap.php';

try {
  $RequestValidator = new RequestValidator(RotasUtil::getRotas());
  $retorno = $RequestValidator->processarRequest();

  $JsonUtil = new JsonUtil();
  $JsonUtil->processarArrayParaRetornar($retorno);
} catch (Exception $exception) {
  echo json_encode([
    ConstantesGenericasUtil::TIPO => ConstantesGenericasUtil::TIPO_ERRO,
    ConstantesGenericasUtil::RESPOSTA => utf8_encode($exception->getMessage())
  ]);
}
