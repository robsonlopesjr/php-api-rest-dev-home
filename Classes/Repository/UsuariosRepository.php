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
   * @param $login
   * @param $senha
   * @return int
   */
  public function insertUser($login, $senha)
  {
    $consultaInsert = 'INSERT INTO ' . self::$tabela . ' (login, senha) VALUES (:login, :senha)';
    $this->MySQL->getDb()->beginTransaction();
    $stmt = $this->MySQL->getDb()->prepare($consultaInsert);
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':senha', $senha);
    $stmt->execute();
    return $stmt->rowCount();
  }

  /**
   * @return MySQL|object
   */
  public function getMySQL()
  {
    return $this->MySQL;
  }
}
