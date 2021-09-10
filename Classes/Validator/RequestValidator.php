<?php

namespace Validator;

use Repository\TokensAutorizadosRepository;
use Service\UsuariosService;
use Util\ConstantesGenericasUtil;
use Util\JsonUtil;

class RequestValidator
{
  private $request;
  private $dadosRequest = [];
  private $tokensAutorizadosRepository;

  const GET = 'GET';
  const DELETE = 'DELETE';
  const USUARIOS = 'USUARIOS';

  public function __construct($request)
  {
    $this->request = $request;
    $this->tokensAutorizadosRepository = new TokensAutorizadosRepository();
  }

  /**
   * @return string
   */
  public function processarRequest()
  {
    $retorno = utf8_encode(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);

    if (in_array($this->request['metodo'], ConstantesGenericasUtil::TIPO_REQUEST, true)) {
      $retorno = $this->direcionarRequest();
    }

    return $retorno;
  }

  private function direcionarRequest()
  {
    if ($this->request['metodo'] !== self::GET && $this->request['metodo'] !== self::DELETE) {
      $this->dadosRequest = JsonUtil::tratarCorpoRequisicaoJson();
    }

    $this->tokensAutorizadosRepository->validarToken(getallheaders()['Authorization']);

    $metodo = $this->request['metodo'];

    return $this->$metodo();
  }

  private function get()
  {
    $retorno = utf8_encode(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);
    if (in_array($this->request['rota'], ConstantesGenericasUtil::TIPO_GET, true)) {
      switch ($this->request['rota']) {
        case self::USUARIOS:
          $UsuariosService = new UsuariosService($this->request);
          $retorno = $UsuariosService->validarGet();
          break;
        default:
          throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
          break;
      }
    }

    return $retorno;
  }
}
