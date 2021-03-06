<?php

namespace DB;

use InvalidArgumentException;
use PDO;
use PDOException;
use Util\ConstantesGenericasUtil;

class MySQL
{
    /** @var object */
    private $db;

    /**
     * MySQL constructor.
     */
    public function __construct()
    {
        $this->db = $this->setDB();
    }

    /** @return PDO */
    public function setDB()
    {
        try {
            return new PDO(
                'mysql:host=' . CONF_DB_HOST . '; dbname=' . CONF_DB_NAME . ';',
                CONF_DB_USER,
                CONF_DB_PASS
            );
        } catch (PDOException $exception) {
            throw new PDOException($exception->getMessage());
        }
    }

    /**
     * @param string $tabela
     * @param int $id
     * @return string
     */
    public function delete(string $tabela, int $id)
    {
        $consultaDelete = 'DELETE FROM ' . $tabela . ' WHERE id = :id';

        if ($tabela && $id) {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare($consultaDelete);

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $this->db->commit();
                return ConstantesGenericasUtil::MSG_DELETADO_SUCESSO;
            }

            $this->db->rollBack();
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_SEM_RETORNO);
        }
        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
    }

    /**
     * @param $tabela
     * @return array
     */
    public function getAll($tabela)
    {
        if ($tabela) {
            $consulta = 'SELECT * FROM ' . $tabela;

            $stmt = $this->db->query($consulta);

            $registros = $stmt->fetchAll($this->db::FETCH_ASSOC);

            if (is_array($registros) && count($registros) > 0) {
                return $registros;
            }
        }
        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_SEM_RETORNO);
    }

    /**
     * @param $tabela
     * @param $id
     * @return mixed
     */
    public function getOneByKey($tabela, $id)
    {
        if ($tabela && $id) {
            $consulta = 'SELECT * FROM ' . $tabela . ' WHERE id = :id';

            $stmt = $this->db->prepare($consulta);

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();

            $totalRegistros = $stmt->rowCount();

            if ($totalRegistros === 1) {
                return $stmt->fetch($this->db::FETCH_ASSOC);
            }

            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_SEM_RETORNO);
        }

        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_ID_OBRIGATORIO);
    }

    /**
     * @return object|PDO
     */
    public function getDb()
    {
        return $this->db;
    }
}
