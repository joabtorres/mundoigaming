<?php

namespace Source\App;

use Source\Core\Connect;
use Source\Core\Controller;
use Source\Models\Auth;
use Source\Models\User;
use Source\Support\Message;

/**
 * Class AuthController Controller
 *
 * @package Source\App
 * @author  Joab T. Alencar <contato@joabtorres.com.br>
 * @version 1.0
 */
class AuthController extends Controller
{
    /**
     * AuthController construct
     */
    public function __construct()
    {
        //redirect("/ops/manutencao");
        Connect::getInstance();
        parent::__construct(__DIR__ . "/../../themes/" . CONF_VIEW_THEME . "/");
    }

    /**
     * login function
     *
     * @param array|null $data
     * @return void
     */
    public function login(?array $data): void
    {
        if (!empty($data['csrf'])) {
            if (!csrf_verify($data)) {
                $json['message'] = $this->message->error("Erro ao enviar, favor use o formulário")->render();
                echo json_encode($json);
                return;
            }

            if (empty($data['email']) || empty($data['password'])) {
                $json['message'] = $this->message->warning("Informe seu e-mail e senha para entrar")->render();
                echo json_encode($json);
                return;
            }
            $save = !empty($data['save']) ? true : false;
            $auth = new Auth();
            $login = $auth->login($data['email'], $data['password'], $save);

            if ($login) {
                $json['redirect'] = url("/");
            } else {
                $json['message'] = $auth->message()->render();
            }
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            "Entrar - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/login"),
            theme("/assets/images/share.jpg")
        );
        echo $this->view->render("auth/auth-login", [
            "head" => $head,
            "cookie" => filter_input(INPUT_COOKIE, "authEmail")
        ]);
    }
    /**
     * register function
     *
     * @param null|array $data
     * @return void
     */
    public function register(?array $data): void
    {
        var_dump($data);
    }
    /**
     * logout function
     *
     * @return void
     */
    public function logout()
    {
        (new Message())->info(
            "Você saiu com sucesso " . Auth::user()->first_name . " volte logo :)"
        )->flash();

        Auth::logout();
        redirect("/login");
    }

    /**
     * forget function - recupera senha
     *
     * @param array|null $data
     * @return void
     */
    public function forget(?array $data): void
    {
        if (!empty($data['csrf'])) {
            if (!csrf_verify($data)) {
                $json['message'] = $this->message->error(
                    "Erro ao enviar, favor use o formulário"
                )->render();
                echo json_encode($json);
                return;
            }
            if (empty($data['email'])) {
                $json['message'] = $this->message->info(
                    "Informe seu e-mail para continuar"
                )->render();
                echo json_encode($json);
                return;
            }
            $auth = new Auth();
            if ($auth->forget($data['email'])) {
                $json['message'] = $this->message->success(
                    "Acesse seu e-mail para recuperar a senha"
                )->render();
            } else {
                $json['message'] = $auth->message()->render();
            }
            echo json_encode($json);
            return;
        }
        $head = $this->seo->render(
            "Recuperar Senha - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/forget"),
            theme("/assets/images/share.jpg")
        );
        echo $this->view->render("auth/auth-forget", [
            "head" => $head
        ]);
    }

    /**
     * reset function
     *
     * @param array|null $data
     * @return void
     */
    public function reset(?array $data): void
    {
        if (!empty($data['csrf'])) {
            if (!csrf_verify($data)) {
                $json['message'] = $this->message->error(
                    "Erro ao enviar, favor use o formulário"
                )->render();
                echo json_encode($json);
                return;
            }

            if (empty($data['password']) || empty($data['password_re'])) {
                $json['message'] = $this->message->info(
                    "Informe e repita a senha para continuar"
                )->render();
                echo json_encode($json);
                return;
            }
            list($email, $code) = explode("|", $data['code']);

            $auth = new Auth();

            if ($auth->reset(
                $email,
                $code,
                $data['password'],
                $data['password_re']
            )) {
                $this->message->success(
                    "Senha alterada com sucesso. Vamos logar?"
                )->flash();
                $json['redirect'] = url("/login");
            } else {
                $json['message'] = $auth->message()->render();
            }

            echo json_encode($json);
            return;
        }
        $head = $this->seo->render(
            "Crie sua nova senha no " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/forget"),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("auth/auth-reset", [
            "head" => $head,
            "code" => $data['code']
        ]);
    }
}
