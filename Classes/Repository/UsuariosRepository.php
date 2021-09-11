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
   * @param $id
   * @param $dados
   * @return int
   */
  public function updateUser($id, $dados)
  {
    $consultaUpdate = 'UPDATE ' . self::$tabela . ' SET login = :login, senha = :senha WHERE id = :id';
    $this->MySQL->getDb()->beginTransaction();
    $stmt = $this->MySQL->getDb()->prepare($consultaUpdate);
    $stmt->bindParam(':login', $dados['login']);
    $stmt->bindParam(':senha', $dados['senha']);
    $stmt->bindParam(':id', $id);
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
