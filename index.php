<?php

use Util\RotasUtil;
use Validator\RequestValidator;

include 'bootstrap.php';

try {
  $RequestValidator = new RequestValidator(RotasUtil::getRotas());
  $retorno = $RequestValidator->processarRequest();
} catch (Exception $exception) {
  echo $exception->getMessage();
}
