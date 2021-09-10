<?php

namespace Repository;

use DB\MySQL;

class UsuariosRepository
{
  private $MySQL;

  public static $tabela = "usuarios";

  /**
   * UsuariosRepository constructor.
   */
  public function __construct()
  {
    $this->MySQL = new MySQL();
  }

  /**
   * @return MySQL|object
   */
  public function getMySQL()
  {
    return $this->MySQL;
  }
}
