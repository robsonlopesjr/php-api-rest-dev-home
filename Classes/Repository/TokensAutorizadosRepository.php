<?php

namespace Repository;

use DB\MySQL;

class TokensAutorizadosRepository
{
  private $MySQL;

  public static $tabela = "tokens_autorizados";

  public function __construct()
  {
    $this->MySQL = new MySQL();
  }

  public function validarToken($token)
  {
  }

  /**
   * @return MySQL|object
   */
  public function getMySQL()
  {
    return $this->MySQL;
  }
}
