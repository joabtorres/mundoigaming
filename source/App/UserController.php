<?php

namespace Source\App;

use Source\Core\Connect;
use Source\Core\Controller;
use Source\Models\Auth;
use Source\Models\Sector;
use Source\Models\User;
use Source\Support\Message;
use Source\Support\Pager;

/**
 * Class UserController Controller
 *
 * @package Source\App
 * @author  Joab T. Alencar <contato@joabtorres.com.br>
 * @version 1.0
 */

class UserController extends Controller
{
    /** @var User */
    private $user;
    /**
     * UserController construct
     */
    public function __construct()
    {
        Connect::getInstance();
        parent::__construct(__DIR__ . "/../../themes/" . CONF_VIEW_THEME . "/");
        //RESTRIÇÃO
        if (!$this->user = Auth::user()) {
            (new Message())->warning("Efetue login para acessar o sistema.")->flash();
            redirect("/login");
        }
    }
    /**
     * search function
     *
     * @return void
     */
    public function search(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_SPECIAL_CHARS);
        $type = !empty($data["type"]) ? $data["type"] : "type";
        $search = !empty($data["search"]) && !empty($type) ? $data["search"] : "search";
        $date_start = !empty($data["date_start"]) ? $data["date_start"] : "start";
        $date_final = !empty($data["date_final"]) ? $data["date_final"] : "end";
        $order = !empty($data["order"]) ? ($data["order"] == "DESC" ? "DESC" : "ASC") : "ASC";
        $page = !empty($data["page"]) ? $data["page"] : 1;
        if (!empty($data["csrf"])) {
            if ($date_start != "start") {
                list($day, $month, $year) = explode("/", $date_start);
                $date_start = "{$year}-{$month}-{$day}";
            }
            if ($date_final != "end") {
                list($day, $month, $year) = explode("/", $date_final);
                $date_final = "{$year}-{$month}-{$day}";
            }
            $json["redirect"] = url("user/{$type}/{$search}/{$date_start}/{$date_final}/{$order}/1");
            echo json_encode($json);
            return;
        }

        $sql_query = "id > 0";
        $sql_params = null;
        if ($type != "type" && $search != "search") {
            $sql_query = "first_name LIKE '%{$search}%'";
        }

        if ($date_start != "start" && $date_final != "final") {
            $sql_query .= " AND created_at BETWEEN :date_start AND :date_final";
            $sql_params .= "date_start={$date_start}&date_final={$date_final} 23:59:58";
        }

        $users = (new User())->find($sql_query, $sql_params);
        $pager = new Pager(url("/user/{$type}/{$search}/{$date_start}/{$date_final}/{$order}/"));
        $pager->pager($users->count(), 30, $page);

        $head = $this->seo->render(
            "Usuários - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );
        echo $this->view->render("user/search", [
            "head" => $head,
            "users" => $users->limit($pager->limit())
                ->offset($pager->offset())
                ->order("id {$order}")
                ->fetch(true),
            "userTotal" => $users->count(),
            "paginator" => $pager->render(),
            "sectors" => (new Sector())->find()->fetch(true)
        ]);
    }
    /**
     * register function
     *
     * @param array $data
     * @return void
     */
    public function register(array $data): void
    {
        if (!empty($data["csrf"])) {
            $data = filter_var_array($data, FILTER_SANITIZE_SPECIAL_CHARS);
            if (!empty($data["password"]) && empty($data["rpassword"])) {
                $json["message"] = $this->message->warning("Informe o 'Repetir Senha' corretamente!")->render();
                echo json_encode($json);
                return;
            }
            if (!empty($data["password"]) && !empty($data["rpassword"]) && $data["password"] != $data["rpassword"]) {
                $json["message"] = $this->message->error("Os campos 'Senha' e 'Repetir Senha' não estão iguais.")->render();
                echo json_encode($json);
                return;
            }

            $user = (new User())->bootstrap(
                $data["first_name"],
                $data["last_name"],
                $data["email"],
                $data["password"],
                $data["sector_id"],
                $data["status"]
            );
            if (!$user->save()) {
                $json["message"] = $user->message()->render();
                echo json_encode($json);
                return;
            }
            $this->message->success("Cadastro realizado com sucesso!")->flash();
            $json["redirect"] = url("user/register");
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            "Novo Usuário - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );
        echo $this->view->render("user/register", [
            "head" => $head,
            "sectors" => (new Sector())->find()->fetch(true)
        ]);
    }

    /**
     * update function
     *
     * @param array $data
     * @return void
     */
    public function update(array $data): void
    {
        if (!empty($data["csrf"])) {
            $data = filter_var_array($data, FILTER_SANITIZE_SPECIAL_CHARS);
            if (!empty($data["password"]) && empty($data["rpassword"])) {
                $json["message"] = $this->message->warning("Informe o 'Repetir Senha' corretamente!")->render();
                echo json_encode($json);
                return;
            }
            if (!empty($data["password"]) && !empty($data["rpassword"]) && $data["password"] != $data["rpassword"]) {
                $json["message"] = $this->message->error("Os campos 'Senha' e 'Repetir Senha' não estão iguais.")->render();
                echo json_encode($json);
                return;
            }

            $user = (new User())->findById(filter_var($data["id"], FILTER_VALIDATE_INT));
            $user->sector_id = $data["sector_id"];
            $user->first_name = $data["first_name"];
            $user->last_name = $data["last_name"];
            $user->email = $data["email"];
            $user->password = !empty($data["password"]) ? $data["password"] : $user->password;
            $user->status = $data["status"];

            if (!$user->save()) {
                $json["message"] = $user->message()->render();
                echo json_encode($json);
                return;
            }
            $this->message->success("Alteração realizada com sucesso!")->flash();
            $json["redirect"] = url("user/update/{$user->id}");
            echo json_encode($json);
            return;
        }

        $user = (new User())->findById(filter_var($data["id"], FILTER_VALIDATE_INT));
        $head = $this->seo->render(
            "Editar usuário - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );
        echo $this->view->render("user/edit", [
            "head" => $head,
            "user" => $user,
            "sectors" => (new Sector())->find()->fetch(true)
        ]);
    }

    /**
     * remove function
     *
     * @param array $data
     * @return void
     */
    public function remove(array $data): void
    {
        $user = (new User())->findById(filter_var($data, FILTER_VALIDATE_INT));
        if (!$user) {
            $this->message->warning("Ooops {$this->user->first_name}! Você tentou excluir um registro inexistente do banco de dados.")->flash();
        } else {
            $user->destroy();
            $this->message->success("Registro removido com sucesso!")->flash();
        }
        redirect("user");
    }
}
