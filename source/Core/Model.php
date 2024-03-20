<?php

namespace Source\Core;

use PDO;
use PDOException;
use PDOStatement;


use Source\Support\Message;

/**
 * Class Model Layer Supertype Pattern
 *
 * @package Source\Core
 * @author  Joab T. Alencar <contato@joabtorres.com.br>
 * @version 1.0
 */
abstract class Model
{
    /** @var object|null */
    protected $data;

    /** @var PDOException|null */
    protected $fail;

    /** @var Message|null */
    protected $message;

    /** @var string */
    protected $query;

    /** @var string|array */
    protected $params;

    /** @var string */
    protected $order;

    /** @var int */
    protected $limit;

    /** @var int */
    protected $offset;

    /** @var string $entity database table */
    protected static $entity;

    /** @var array $protected no update or create */
    protected static $protected;

    /** @var array $required table fields */
    protected static $required;

    /**
     * Model constructor.
     *
     * @param string $entity database table name
     * @param array $protected table protected columns
     * @param array $required table required columns
     */
    public function __construct(
        string $entity,
        array  $protected,
        array  $required
    ) {
        self::$entity = $entity;
        self::$protected = array_merge(
            $protected,
            ['created_at', "updated_at"]
        );
        self::$required = $required;

        $this->message = new Message();
    }


    /**
     * Armazena um objeto stdClass os valore obtidos do banco
     *
     * @param string $name - propriedade do objeto
     * @param mixed $value - valor do objeto
     *
     * @return void
     */
    public function __set($name, $value)
    {
        if (empty($this->data)) {
            $this->data = new \stdClass();
        }

        $this->data->$name = $value;
    }

    /**
     *
     * Verifica se exite uma propriedade no objeto data
     *
     * @param string $name - propriedade do objeto solicitada
     *
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data->$name);
    }

    /**
     * retorna o valor da propriedade do objeto solicitado
     *
     * @param string $name - propriedade do objeto solicitada
     *
     * @return null
     */
    public function __get($name)
    {
        return ($this->data->$name ?? null);
    }

    /**
     * @return null|object
     */
    public function data(): ?object
    {
        return $this->data;
    }

    /**
     * @return PDOException|null
     */
    public function fail(): ?PDOException
    {
        return $this->fail;
    }

    /**
     * @return Message|null
     */
    public function message(): ?Message
    {
        return $this->message;
    }

    /**
     * find() - prepara a query que ira consultar registro no banco de dados;
     * @param string|null $terms termos de condição da query
     * @param string|null $params valores dos termos da condição
     * @param string $columns colunas de retorno do banco, por padrão retorna tudo (*)
     *
     * @return Model|mixed
     */
    public function find(
        string  $terms = null,
        ?string $params = null,
        string  $columns = "*"
    ) {
        if ($terms) {
            $this->query = "SELECT $columns FROM " . static::$entity
                . " WHERE {$terms}";
            parse_str($params, $this->params);
            return $this;
        }
        $this->query = "SELECT $columns FROM " . static::$entity;
        return $this;
    }

    /**
     * Consulta e retorna do banco de dados a partir do do
     *
     * @param int $id
     * @param string $columns
     *
     * @return Model|null
     */
    public function findById(int $id, string $columns = "*"): ?Model
    {
        return $this->find("id=:id", "id={$id}", $columns)->fetch();
    }

    /**
     * order() - determina a ordem dos resultados crescente ou descrescente
     * @param string $collumnOrder
     *
     * @return Model
     */
    public function order(string $collumnOrder): Model
    {
        $this->order = " ORDER BY {$collumnOrder}";
        return $this;
    }

    /**
     * limit() limita o número de resultados da query SELECT
     * @param int $limit
     *
     * @return Model
     */
    public function limit(int $limit): Model
    {
        $this->limit = " LIMIT {$limit}";
        return $this;
    }

    /**
     * offset() indica o início da leitura dos resultados
     * @param int $offset
     *
     * @return Model
     */
    public function offset(int $offset): Model
    {
        $this->offset = " OFFSET {$offset}";
        return $this;
    }

    /**
     * Realiza a consulta na tabela retornando um ou mais valores
     *
     * @param bool $all true retorna todos os valores, false retorna somento o primeiro
     *
     * @return null|array|mixed|Model
     */
    public function fetch(bool $all = false)
    {
        try {
            $stmt = Connect::getInstance()->prepare(
                $this->query . $this->order . $this->limit . $this->offset
            );
            $stmt->execute($this->params);


            if (!$stmt->rowCount()) {
                return null;
            }

            if ($all) {
                return $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
            }

            return $stmt->fetchObject(static::class);
        } catch (PDOException $ex) {
            $this->fail = $ex;
            return null;
        }
    }

    /**
     * Realiza a contagem de registro em uma tabela
     *
     * @param string $key
     *
     * @return int
     */
    public function count(string $key = "id"): int
    {
        $stmt = Connect::getInstance()->prepare($this->query);
        $stmt->execute($this->params);
        return $stmt->rowCount();
    }

    /**
     * Cadastrar no banco de dados
     *
     * @param array $data - array com indices das colunas e valores
     *
     * @return int|null - retorna null ou o valor do id cadastrado
     */
    protected function create(array $data): ?int
    {
        try {
            $columns = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));

            $stmt = Connect::getInstance()->prepare(
                "INSERT INTO " . static::$entity
                    . " ({$columns}) VALUES ({$values})"
            );
            $stmt->execute($this->filter($data));

            return Connect::getInstance()->lastInsertId();
        } catch (PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }


    /**
     * Realizar o update do registro no banco de dados
     *
     * @param array $data - o array do registro
     * @param string $terms - termos do where
     * @param string $params - valores dos termos
     *
     * @return int|null
     */
    protected function update(
        array  $data,
        string $terms,
        string $params
    ): ?int {
        try {
            $dateSet = [];
            foreach ($data as $bind => $value) {
                $dateSet[] = "{$bind} = :{$bind}";
            }
            $dateSet = implode(", ", $dateSet);
            parse_str($params, $params);

            $stmt = Connect::getInstance()->prepare(
                "UPDATE " . static::$entity . " SET {$dateSet} WHERE {$terms}"
            );
            $stmt->execute($this->filter(array_merge($data, $params)));
            return ($stmt->rowCount() ?? 1);
        } catch (PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    /**
     * Salvar o registro no banco
     * @return bool
     */
    public function save(): bool

    {
        if (!$this->required()) {
            $this->message->warning("Preencha todos os campos para continuar.");
            return false;
        }
        /** Update **/
        if (!empty($this->id)) {
            $id = $this->id;
            $this->update($this->safe(), "id = :id", "id={$id}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }
        /** Create **/
        if (empty($this->id)) {
            $id = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->error("Error ao cadastrar, verifique os dados");
                return false;
            }
        }
        $this->data = $this->findById($id)->data();
        return true;
    }


    /**
     * Realiza a exclusão de registro da tabela
     *
     * @param string $terms termo da condição
     * @param string|null $params valor do termo da condição
     *
     * @return bool
     */
    public function delete(string $terms, ?string $params = null): bool
    {
        try {
            $stmt = Connect::getInstance()->prepare("DELETE FROM  " . static::$entity . " WHERE {$terms}");
            if ($params) {
                parse_str($params, $params);
                $stmt->execute($params);
                return true;
            }
            $stmt->execute();
            return true;
        } catch (PDOException $exception) {
            $this->fail = $exception;
            return false;
        }
    }

    /**
     * Remove o registro se houve um id
     * @return bool
     */
    public function destroy(): bool
    {
        if (empty($this->id)) {
            return false;
        }
        $destroy = $this->delete("id=:id", "id={$this->id}");
        return true;
    }

    /**
     * Função responsável para remover os indices definido pela variavel
     * static::$safe
     *
     * @return array|null
     */
    protected function safe(): ?array
    {
        $safe = (array)$this->data;
        foreach (static::$protected as $unset) {
            unset($safe[$unset]);
        }
        return $safe;
    }

    /**
     * Verifica se o array é null ou possui metadados além de texto e números
     * por exemplo: tags, script, barras, etc...
     *
     * @param array $data - array já filtrado pela safe
     *
     * @return array|null
     */
    private function filter(array $data): ?array
    {
        $filter = [];
        foreach ($data as $key => $value) {
            $filter[$key] = (is_null($value)
                ? null
                : filter_var(
                    $value,
                    FILTER_DEFAULT
                ));
        }
        return $filter;
    }

    /**
     *  Verifica se todos os campos obrigatórios foram preenchidos
     *
     * @return bool
     */
    protected function required(): bool
    {
        $data = (array)$this->data();
        foreach (static::$required as $field) {
            if (empty($data[$field])) {
                return false;
            }
        }
        return true;
    }
}
