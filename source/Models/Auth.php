<?php

namespace Source\Models;

use Source\Core\Model;
use Source\Core\Session;
use Source\Core\View;
use Source\Support\Email;

/**
 * Class Auth
 *
 * @package Source\Model
 * @version 1.0
 */
class Auth extends Model
{
    /**
     *
     */
    public function __construct()
    {
        parent::__construct("users", ["id"], ["email", "password"]);
    }

    /**
     * @return User|null
     */
    public static function user(): ?User
    {
        $session = new Session();
        if (!$session->has("authUserWorld")) {
            return null;
        }
        return (new User())->find("status=1 && id=:id", "id={$session->authUserWorld}")->fetch();
    }

    /**
     * logout
     *
     * @return void
     */
    public static function logout(): void
    {
        $session = new Session();
        $session->unset("authUserWorld");
    }


    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function save(): bool
    {

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

        /** User Create */
        if ((new User())->findByEmail($this->email, "id")) {
            $this->message->warning("O e-mail informado já está cadastrado");
            return false;
        }

        $this->id = $this->create($this->safe());
        if ($this->fail()) {
            $this->message->error("Erro ao cadastrar, verifique os dados");
            return false;
        }
        $this->data = ($this->findById($this->id))->data();
        return true;
    }
    /**
     * @param string $email
     * @param string $password
     * @param bool   $save
     *
     * @return bool
     */
    public function login(
        string $email,
        string $password,
        bool $save = false
    ): bool {
        if (!is_email($email)) {
            $this->message->warning("O e-mail informado não é válido");
            return false;
        }
        if ($save) {
            setcookie("authEmail", $email, time() + 604800, "/");
        } else {
            setcookie("authEmail", '', time() - 3600, "/");
        }

        if (!is_passwd($password)) {
            $this->message->warning("A senha informada não é válida");
            return false;
        }

        $user = (new User())->findByEmail($email);
        if (!$user) {
            $this->message->error("O e-mail informado não está cadastrado");
            return false;
        }
        if (!$user->status) {
            $this->message->error("O acesso deste usuário foi revogado.");
            return false;
        }

        if (!passwd_verify($password, $user->password)) {
            $this->message->error("A senha informada não confere");
            return false;
        }

        if (passwd_rehash($user->password)) {
            $user->password = $password;
            $user->save();
        }

        //LOGIN
        (new Session())->set("authUserWorld", $user->id);
        $this->message->success("Login efetuado com sucesso")->flash();
        return true;
    }

    /**
     * @param string $email
     *
     * @return bool
     */
    public function forget(string $email): bool
    {
        $user = (new User())->findByEmail($email);

        if (!$user) {
            $this->message->warning("O e-mail informado não está cadastrado");
            return false;
        }
        if (!$user->status) {
            $this->message->warning("O acesso deste usuário foi revogado.");
            return false;
        }

        $user->forget = md5(uniqid(rand(), true));
        $user->save();
        $view = new View(__DIR__ . "/../../shared/views/email");
        $message = $view->render("forget", [
            "first_name" => $user->first_name,
            "forget_link" => url("/forget/{$user->email}|{$user->forget}")
        ]);

        $email = (new Email())->bootstrap(
            "Recupe sua senha no " . CONF_SITE_NAME,
            $message,
            $user->email,
            "{$user->first_name} {$user->last_name}"
        );
        if (!$email->send()) {
            $this->message = $email->message();
            return false;
        }
        return true;
    }

    /**
     * @param string $email
     * @param string $code
     * @param string $password
     * @param string $password_re
     *
     * @return bool
     */
    public function reset(
        string $email,
        string $code,
        string $password,
        string $password_re
    ): bool {
        $user = (new User())->findByEmail($email);

        if (!$user) {
            $this->message->warning(
                "A conta para recuperação não foi encontrada"
            );
            return false;
        }
        if ($user->forget != $code) {
            $this->message->error(
                "Desculpe, mas o código de verificação não é valido"
            );
            return false;
        }
        if (!is_passwd($password)) {
            $min = CONF_PASSWD_MIN_LEN;
            $max = CONF_PASSWD_MAX_LEN;
            $this->message->info(
                "Sua senha deve ter entre {$min} e {$max} caracteres"
            );
            return false;
        }

        if ($password != $password_re) {
            $this->message->warning("Você informou duas senhas diferentes");
            return false;
        }

        $user->password = $password;
        $user->forget = null;
        $user->save();
        return true;
    }
}
