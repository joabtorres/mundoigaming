<?php

namespace Source\Core;

use PDO;
use PDOException;

/**
 * Class Connect responsável para realizar a conexão com o banco de dados
 *
 * @package Source\Core
 * @version 1.0
 */
class Connect
{
    /** @const array */
    private const OPTIONS
        = [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_CASE => PDO::CASE_NATURAL
        ];

    /** @var PDO */
    private static $instance;

    /**
     * Função reponsável para conectar ao banco dados;
     * Connect getInstance.
     *
     * @return PDO
     */
    public static function getInstance(): ?PDO
    {
        if (empty(self::$instance)) {
            try {
                self::$instance = new PDO(
                    "mysql:host=" . CONF_DB_HOST . ";dbname=" . CONF_DB_NAME,
                    CONF_DB_USER,
                    CONF_DB_PASS,
                    self::OPTIONS
                );
            } catch (PDOException $exception) {
                redirect("/ops/problemas");
            }
        }

        return self::$instance;
    }

    /**
     * Connect construct.
     */
    private function __construct()
    {
    }

    /**
     * Connect clone.
     */
    private function __clone()
    {
    }
}