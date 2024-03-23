<?php

namespace Source\App;

use Source\Core\Connect;
use Source\Core\Controller;
use Source\Models\Auth;
use Source\Models\ListId;
use Source\Models\User;
use Source\Support\Message;
use Source\Support\Pager;

class ListIdController extends Controller
{
    /** @var User */
    private $user;
    /**
     * StatusController construct
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
        user_level(2);
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
            $json["redirect"] = url("/list_id/{$type}/{$search}/{$date_start}/{$date_final}/{$order}/1");
            echo json_encode($json);
            return;
        }

        $sql_query = "id > 0";
        $sql_params = null;
        if ($type != "type" && $search != "search") {
            $sql_query = "identify LIKE '%{$search}%'";
        }

        if ($date_start != "start" && $date_final != "final") {
            $sql_query .= " AND created_at BETWEEN :date_start AND :date_final";
            $sql_params .= "date_start={$date_start}&date_final={$date_final} 23:59:58";
        }

        $listIds = (new ListId())->find($sql_query, $sql_params);
        $pager = new Pager(url("/list_id/{$type}/{$search}/{$date_start}/{$date_final}/{$order}/"));
        $pager->pager($listIds->count(), 30, $page);

        $head = $this->seo->render(
            "Lista de Id - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );
        echo $this->view->render("list_id/search", [
            "head" => $head,
            "listIds" => $listIds->limit($pager->limit())
                ->offset($pager->offset())
                ->order("id {$order}")
                ->fetch(true),
            "listIdTotal" => $listIds->count(),
            "paginator" => $pager->render()
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
            if (empty($data["identify"])) {
                $json["message"] = $this->message->error("Informe o id.")->render();
                echo json_encode($json);
                return;
            }
            if (empty($data["name"])) {
                $json["message"] = $this->message->error("Informe o nome.")->render();
                echo json_encode($json);
                return;
            }

            $listId = (new ListId())->bootstrap(
                $data["identify"],
                $data["name"]
            );
            if (!$listId->save()) {
                $json["message"] = $listId->message()->render();
                echo json_encode($json);
                return;
            }
            $this->message->success("Cadastro realizado com sucesso!")->flash();
            $json["reload"] = true;
            echo json_encode($json);
        }
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
            if (empty($data["identify"])) {
                $json["message"] = $this->message->error("Informe o id.")->render();
                echo json_encode($json);
                return;
            }
            if (empty($data["name"])) {
                $json["message"] = $this->message->error("Informe o nome.")->render();
                echo json_encode($json);
                return;
            }
            $listId = (new ListId())->findById($data["id"]);
            $listId->name = $data["identify"];
            $listId->company_id = $data["name"];

            if (!$listId->save()) {
                $json["message"] = $listId->message()->render();
                echo json_encode($json);
                return;
            }
            $this->message->success("Alteração realizada com sucesso!")->flash();
            $json["redirect"] = url("status/update/{$listId->id}");
            echo json_encode($json);
            return;
        }

        $listId = (new ListId())->findById(filter_var($data["id"], FILTER_VALIDATE_INT));
        var_dump($listId);
        if (!$listId) {
            $this->message->warning("Oops {$this->user->first_name}! Você tentou acessar um registro inexistente no banco de dados.")->flash();
            redirect("status");
            return;
        }
        $head = $this->seo->render(
            "Editar status - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );
        echo $this->view->render("list_id/edit", [
            "head" => $head,
            "listId" => $listId
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
        $id = (new ListId())->findById(filter_var($data["id"], FILTER_VALIDATE_INT));
        if (!$id) {
            $this->message->warning("Ooops {$this->user->first_name}! Você tentou excluir um registro inexistente do banco de dados.")->flash();
        } else {
            $id->destroy();
            $this->message->success("Registro removido com sucesso!")->flash();
        }
        redirect(url_back());
    }
}