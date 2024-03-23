<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * Class User
 *
 * @package Source\Model
 * @author  Joab T. Alencar <contato@joabtorres.com.br>
 * @version 1.0
 */
class User extends Model
{
    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct(
            "users",
            ["id"],
            ["sector_id", "first_name", "last_name", "email", "password"]
        );
    }

    /**
     * @param string      $firstName
     * @param string      $lastName
     * @param string      $email
     * @param string      $password
     * @param int         $status
     * @param int         $level
     * @param string|null $document
     *
     * @return User
     */
    public function bootstrap(
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        int $sectorId,
        int $status,
        int $level,
        string $avatar = null,
    ): User {
        $this->first_name = $firstName;
        $this->last_name = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->avatar = $avatar;
        $this->sector_id = $sectorId;
        $this->status = $status;
        $this->level = $level;
        return $this;
    }

    /**
     * Consulta e retorna um usuário do banco de dados a partir do email
     *
     * @param string $email
     * @param string $columns
     *
     * @return User|null
     */
    public function findByEmail(string $email, string $columns = "*"): ?User
    {
        return $this->find("email = :email", "email={$email}", $columns)->fetch();
    }


    /**
     * Verifica se será cadatrado ou atualizado um usuario no banco de dados
     *
     * @return bool
     */
    public function save(): bool
    {
        if (!$this->required()) {
            $this->message->warning("Nome, sobrenome, email, senha e setor são obrigatórios");
            return false;
        }

        if (!is_email($this->email)) {
            $this->message->warning("O e-mail informado não tem um formato válido");
            return false;
        }

        if (!is_passwd($this->password)) {
            $min = CONF_PASSWD_MIN_LEN;
            $max = CONF_PASSWD_MAX_LEN;
            $this->message->warning("A senha deve ter entre {$min} e {$max} caracteres");
            return false;
        } else {
            $this->password = passwd($this->password);
        }

        /** User Update */
        if (!empty($this->id)) {
            $userId = $this->id;

            if ($this->find(
                "email = :e AND id != :i",
                "e={$this->email}&i={$userId}",
                "id"
            )->fetch()) {
                $this->message->warning("O e-mail informado já está cadastrado");
                return false;
            }

            $this->update(
                $this->safe(),
                "id = :id",
                "id={$userId}"
            );
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

        /** User Create */
        if (empty($this->id)) {
            if ($this->findByEmail($this->email, "id")) {
                $this->message->warning("O e-mail informado já está cadastrado");
                return false;
            }

            $userId = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }

        $this->data = ($this->findById($userId))->data();
        return true;
    }

    public function sector(): ?Sector
    {
        if ($this->sector_id) {
            return (new Sector())->findById($this->sector_id);
        }
    }
}
