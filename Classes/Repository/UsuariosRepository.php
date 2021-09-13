<?php

namespace Repository;

use DB\MySQL;
use PDO;

class UsuariosRepository
{
    /**
     * @var object|MySQL
     */
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
     * @return int
     */
    public function getRegistroByLogin($login)
    {
        $consulta = 'SELECT * FROM ' . self::$tabela . ' WHERE login = :login';

        $stmt = $this->MySQL->getDb()->prepare($consulta);

        $stmt->bindParam(':login', $login, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->rowCount();
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

        $stmt->bindParam(':login', $login, PDO::PARAM_STR);

        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);

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

        $stmt->bindParam(':login', $dados['login'], PDO::PARAM_STR);

        $stmt->bindParam(':senha', $dados['senha'], PDO::PARAM_STR);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

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
