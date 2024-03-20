<?php

namespace Source\App;

use Source\Core\Connect;
use Source\Core\Controller;
use Source\Models\Auth;
use Source\Models\Company;
use Source\Models\Status;
use Source\Support\Message;
use Source\Support\Pager;

/**
 * Class StatusController Controller
 *
 * @package Source\App
 * @author  Joab T. Alencar <contato@joabtorres.com.br>
 * @version 1.0
 */
class StatusController extends Controller
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
            $json["redirect"] = url("status/{$type}/{$search}/{$date_start}/{$date_final}/{$order}/1");
            echo json_encode($json);
            return;
        }

        $sql_query = "id > 0";
        $sql_params = null;
        if ($type != "type" && $search != "search") {
            $sql_query = "name LIKE '%{$search}%'";
        }

        if ($date_start != "start" && $date_final != "final") {
            $sql_query .= " AND created_at BETWEEN :date_start AND :date_final";
            $sql_params .= "date_start={$date_start}&date_final={$date_final} 23:59:58";
        }

        $status = (new Status())->find($sql_query, $sql_params);
        $pager = new Pager(url("/status/{$type}/{$search}/{$date_start}/{$date_final}/{$order}/"));
        $pager->pager($status->count(), 30, $page);

        $head = $this->seo->render(
            "Status - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );
        echo $this->view->render("status/search", [
            "head" => $head,
            "status" => $status->limit($pager->limit())
                ->offset($pager->offset())
                ->order("id {$order}")
                ->fetch(true),
            "statusTotal" => $status->count(),
            "paginator" => $pager->render(),
            "companies" => (new Company())->find()->fetch(true)
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
            if (empty($data["name"])) {
                $json["message"] = $this->message->error("Informe o status.")->render();
                echo json_encode($json);
                return;
            }

            $status = (new Status())->bootstrap(
                $data["company"],
                $data["name"],
                $data["class_color"]
            );
            if (!$status->save()) {
                $json["message"] = $status->message()->render();
                echo json_encode($json);
                return;
            }
            $this->message->success("Cadastro realizado com sucesso!")->flash();
            $json["redirect"] = url("status");
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
            if (empty($data["name"])) {
                $json["message"] = $this->message->error("Informe o status.")->render();
                echo json_encode($json);
                return;
            }
            $statusUpdate = (new Status())->findById($data["id"]);
            $statusUpdate->name = $data["name"];
            $statusUpdate->company_id = $data["company"];
            $statusUpdate->class_color = $data["class_color"];

            if (!$statusUpdate->save()) {
                $json["message"] = $statusUpdate->message()->render();
                echo json_encode($json);
                return;
            }
            $json["message"] = $this->message->success("Alteração realizada com sucesso!")->render();
            echo json_encode($json);
            return;
        }

        $status = (new Status())->findById(filter_var($data["id"], FILTER_VALIDATE_INT));
        if (!$status) {
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
        echo $this->view->render("status/edit", [
            "head" => $head,
            "status" => $status,
            "companies" => (new Company())->find()->fetch(true)
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
        $status = (new Status())->findById(filter_var($data["id"], FILTER_VALIDATE_INT));
        if (!$status) {
            $this->message->warning("Ooops {$this->user->first_name}! Você tentou excluir um registro inexistente do banco de dados.")->flash();
        } else {
            $status->destroy();
            $this->message->success("Registro removido com sucesso!")->flash();
        }
        redirect("status");
    }
}
