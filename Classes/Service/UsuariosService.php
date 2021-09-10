<?php

namespace Service;

use Repository\UsuariosRepository;
use Util\ConstantesGenericasUtil;

class UsuariosService
{

  public static $TABELA = 'usuarios';
  public static $RECURSOS_GET = ['listar'];
  private $dados;

  /**
   * @var object|UsuariosRepository
   */
  private $UsuariosRepository;

  /**
   * UsuariosService constructor
   * @param array $dados
   */
  public function __construct($dados = [])
  {

    $this->dados = $dados;
    $this->UsuariosRepository = new UsuariosRepository();
  }

  public function validarGet()
  {
    $retorno = null;
    $recurso = $this->dados['recurso'];

    if (in_array($recurso, self::$RECURSOS_GET, true)) {
      $retorno = $this->dados['id'] > 0 ? $this->getOneByKey() : $this->$recurso();
    } else {
      throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
    }

    if ($retorno === null) {
      throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
    }

    return $retorno;
  }

  private function getOneByKey()
  {
    return $this->UsuariosRepository->getMySQL()->getOneByKey(self::$TABELA, $this->dados['id']);
  }

  private function listar()
  {
    return $this->UsuariosRepository->getMySQL()->getAll(self::$TABELA);
  }
}
