<?php

namespace Source\Core;

use Source\Support\Message;

/**
 * Class Session
 *
 * @package Source\Core
 * @author Joab T. Alencar <contato@joabtorres.com.br>
 * @version 1.0
 */
class Session
{
    /**
     * Session constructor.
     */
    public function __construct()
    {
        if (!session_id()) {
            session_start();
        }
    }

    /**
     * Função Mágica para retornar o valor do indice solicidado caso ele exista,
     * caso contrario retorna null
     *
     * @param string $name - indice da $_SESSION
     *
     * @return mixed|null
     */
    public function __get($name)
    {
        if (!empty($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return null;
    }

    /**
     * Método mágico para verificar se o indice existe
     *
     * @param string $name -- indice da $_SESSION
     *
     * @return bool
     */
    public function __isset($name)
    {
        return $this->has($name);
    }

    /**
     * Função para retornar todos os indice da $_SESSION como objetos
     *
     * @return object|null
     */
    public function all(): ?object
    {
        return (object)$_SESSION;
    }

    /**
     * Função para criar um novo indice na $_SESSION
     *
     * @param string $key   - indice da $_SESSION
     * @param mixed  $value int, float, string, array ou object
     * @return Session
     */
    public function set(string $key, $value): Session
    {
        $_SESSION[$key] = (is_array($value) ? (object)$value : $value);
        return $this;
    }

    /**
     * Função para remover um indice especifico da $_SESSION
     *
     * @param string $key - indice da $_SESSION
     *
     * @return Session
     */
    public function unset(string $key): Session
    {
        unset($_SESSION[$key]);
        return $this;
    }

    /**
     *
     * Função para verificar se existe indice na $_SESSION
     *
     * @param string $key - indice da $_SESSION
     *
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Função para gerar um novo id na $_SESSION
     *
     * @return $this
     */
    public function regenerate(): Session
    {
        session_regenerate_id(true);
        return $this;
    }

    /**
     * Função para limpa toda a $_SESSION
     *
     * @return $this
     */
    public function destroy(): Session
    {
        session_destroy();
        return $this;
    }

    /**
     * Função para retorna objeto Message com a mensagem passada via session
     *
     * @return Message|null
     */
    public function flash(): ?Message
    {
        if ($this->has("flash")) {
            $flash = $this->flash;
            $this->unset("flash");
            return $flash;
        }
        return null;
    }

    /**
     * Função para gerar um CSRF Token, impedido a submissão por refrash F5
     *
     * @return void
     */
    public function csrf(): void
    {
        $_SESSION['csrf_token'] = md5(uniqid(rand(), true));
    }
}