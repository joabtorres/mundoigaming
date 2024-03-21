<?php

namespace Source\App;

use Source\Core\Connect;
use Source\Core\Controller;
use Source\Models\Auth;
use Source\Models\Status;
use Source\Models\Upload;
use Source\Support\Message;
use Source\Support\Pager;
use Source\Support\Upload as SupportUpload;

/**
 * Class UploadController Controller
 *
 * @package Source\App
 * @author  Joab T. Alencar <contato@joabtorres.com.br>
 * @version 1.0
 */
class UploadController extends Controller
{

    /** @var User */
    private $user;
    /**
     * UploadController construct
     */
    public function __construct()
    {
        Connect::getInstance();
        parent::__construct(__DIR__ . "/../../themes/" . CONF_VIEW_THEME . "/");
        //RESTRIÇÃO
        if (!$this->user = Auth::user()) {
            (new Message())->warning("Efetue login para acessar o sistema.")->flash();
            redirect(url("/login"));
        }
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
            if (!$data["description"]) {
                $json["message"] = $this->message->warning("Informe uma descrição")->render();
                echo json_encode($json);
                return;
            }

            if (empty($_FILES["url"])) {
                $json["message"] = $this->message->warning("Ooops {$this->user->first_name}, selecione um arquivo para upload.")->render();
                echo json_encode($json);
                return;
            }

            $upload = (new Upload())->bootstrap(
                1,
                $this->user->id,
                $data["description"]
            );

            $uploadSupport = new SupportUpload();
            if (!$upload->url = $uploadSupport->image($_FILES["url"], date('Y-m-d') . md5(rand(1, 666666) . time()))) {
                $json["message"] = $uploadSupport->message()->render();
                echo json_encode($json);
                return;
            }
            if (!$upload->save()) {
                $json["message"] = $upload->message()->render();
                echo json_encode($json);
                return;
            }
            $this->message->success("Cadastro realizado com sucessso!")->flash();
            $json["redirect"] = url("/upload");
            echo json_encode($json);
            return;
        }
    }
    /**
     * search function
     *
     * @param array|null $data
     * @return void
     */
    public function search(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_SPECIAL_CHARS);
        $status = !empty($data["status"]) ? $data["status"] : "status";
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
            $json["redirect"] = url("upload/{$status}/{$type}/{$search}/{$date_start}/{$date_final}/{$order}/1");
            echo json_encode($json);
            return;
        }

        $sql_query = "id >= :id";
        $sql_params = "id=1";
        if ($status != "status") {
            $sql_query .= " AND status_id=:status";
            $sql_params .= "&status={$status}";
        }
        if ($type != "type" && $search != "search") {
            $sql_query .= "AND description LIKE '%{$search}%'";
        }
        if ($date_start != "start" && $date_final != "final") {
            $sql_query .= " AND created_at BETWEEN :date_start AND :date_final";
            $sql_params .= "&date_start={$date_start}&date_final={$date_final} 23:59:58";
        }

        $upload = (new Upload())->find($sql_query, $sql_params);
        $pager = new Pager(url("/upload/{$status}/{$type}/{$search}/{$date_start}/{$date_final}/{$order}/"));
        $pager->pager($upload->count(), 30, $page);

        $head = $this->seo->render(
            "Uploads Realizados - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );
        echo $this->view->render("upload/search", [
            "head" => $head,
            "uploads" => $upload->limit($pager->limit())
                ->offset($pager->offset())
                ->order("id {$order}")
                ->fetch(true),
            "uploadTotal" => $upload->count(),
            "paginator" => $pager->render(),
            "status" => (new Status())->find()->fetch(true)
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
        if ($this->user->level < 1) {
            (new Message())->warning("Você não tem permissão para acessar essa área.")->flash();
            redirect(url("/"));
        }
        $id = filter_var($data["id"], FILTER_VALIDATE_INT);
        $status = filter_var($data["status"], FILTER_SANITIZE_SPECIAL_CHARS) && $data["status"] == "aceita" ? 3 : 4;
        $upload = (new Upload())->findById($id);
        if (!$upload) {
            $this->message->warning("Oops {$this->user->first_name}! Você tentou acessar um registro inexistente no banco de dados.")->flash();
            redirect(url("publicity"));
            return;
        }
        $upload->status_id = $status;
        if (!$upload->save()) {
            $json['message'] = $upload->message()->flash();
            echo json_encode($json);
            return;
        }
        $this->message->success("Alteração realizada com sucesso!")->flash();
        redirect(url("/"));
    }

    public function remove(array $data): void
    {
        $upload = (new Upload())->findById(filter_var($data["id"], FILTER_VALIDATE_INT));
        $publicity = $upload->publicity_id;
        if (!$upload) {
            $this->message->warning("Ooops {$this->user->first_name}! Você tentou excluir um registro inexistente do banco de dados.")->flash();
        } else {
            $uploadSupport = new SupportUpload();
            $uploadSupport->remove(CONF_UPLOAD_DIR . "/{$upload->url}");
            $upload->destroy();
            $this->message->success("Registro removido com sucesso!")->flash();
            redirect(url("/upload"));
        }
        redirect(url_back());
    }
}
