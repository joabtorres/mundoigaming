<?php

namespace Source\App;

use Source\Core\Connect;
use Source\Core\Controller;

/**
 * Class ErrorController Controller
 *
 * @package Source\App
 * @author  Joab T. Alencar <contato@joabtorres.com.br>
 * @version 1.0
 */
class ErrorController extends Controller
{
    /**
     * ErrorController function
     */
    public function __construct()
    {
        Connect::getInstance();
        parent::__construct(__DIR__ . "/../../themes/" . CONF_VIEW_THEME . "/");
    }

    /**
     * error function
     *
     * @param array $data
     * @return void
     */
    public function error(array $data): void
    {
        $error = new \stdClass();

        switch ($data['errcode']) {
            case "problemas":
                $error->code = "OPS";
                $error->title = "Estamos enfrentando problemas!";
                $error->message
                    = "Parece que nosso serviço não está disponível no momento. Já estamos vendo isso, mas caso precise envie um e-mail :)";
                $error->linkTitle = "ENVIAR E-MAIL";
                $error->link = "mailto: " . CONF_MAIL_SUPPORT;
                break;
            case "manutencao":
                $error->code = "OPS";
                $error->title = "Desculpe. Estamos em manutenção!";
                $error->message
                    = "Voltamos logo! Por hora estamos trabalhando para melhorar nosso conteúdo para você controlar melhor as suas contas :P";
                $error->linkTitle = null;
                $error->link = null;
                break;
            default:
                $error->code = $data['errcode'];
                $error->title = "Ooops. Conteúdo Indisponível :/";
                $error->message
                    = "Sentimos muito, mas o conteúdo que você tentou acessar não existe, está indisponível no momento ou foi removido :/";
                $error->linkTitle = "Continue navegando";
                $error->link = url_back();
                break;
        }

        $head = $this->seo->render(
            "{$error->code} | {$error->title}",
            $error->message,
            url_back("/ops/{$error->code}"),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("error", [
            "head" => $head,
            "error" => $error
        ]);
    }
}
