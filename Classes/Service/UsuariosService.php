<?php

namespace Service;

use Repository\UsuariosRepository;
use Util\ConstantesGenericasUtil;

class UsuariosService
{

  public static $TABELA = 'usuarios';
  public static $RECURSOS_GET = ['listar'];
  public static $RECURSOS_DELETE = ['deletar'];
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

  /**
   * @return mixed
   */
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

  /**
   * @return mixed
   */
  public function validarDelete()
  {
    $retorno = null;
    $recurso = $this->dados['recurso'];

    if (in_array($recurso, self::$RECURSOS_DELETE, true)) {
      if ($this->dados['id'] > 0) {
        $retorno = $this->$recurso();
      } else {
        throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_ID_OBRIGATORIO);
      }
    } else {
      throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
    }

    if ($retorno === null) {
      throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
    }

    return $retorno;
  }

  /**
   * @return mixed
   */
  private function getOneByKey()
  {
    return $this->UsuariosRepository->getMySQL()->getOneByKey(self::$TABELA, $this->dados['id']);
  }

  /**
   * @return mixed
   */
  private function listar()
  {
    return $this->UsuariosRepository->getMySQL()->getAll(self::$TABELA);
  }

  /**
   * @return string
   */
  private function deletar()
  {
    return $this->UsuariosRepository->getMySQL()->delete(self::$TABELA, $this->dados['id']);
  }
}
