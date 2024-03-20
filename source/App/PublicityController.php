<?php

namespace Source\App;

use Source\Core\Connect;
use Source\Core\Controller;
use Source\Models\Auth;
use Source\Models\Publicity;
use Source\Models\Publicity\Anexo;
use Source\Models\Status;
use Source\Support\Message;
use Source\Support\Pager;
use Source\Support\Upload;

/**
 * Class PublicityController Controller
 *
 * @package Source\App
 * @author  Joab T. Alencar <contato@joabtorres.com.br>
 * @version 1.0
 */

class PublicityController extends Controller
{
    /** @var User */
    private $user;
    /**
     * PublicityController construct
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
     * graphic function - grafico estatistico
     *
     * @param array $data
     * @return void
     */
    public function graphic(array $data): void
    {
        echo "página em desenvolvimento";
    }
    /**
     * search function
     *
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
            $json["redirect"] = url("publicity/{$status}/{$type}/{$search}/{$date_start}/{$date_final}/{$order}/1");
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
            $sql_query .= "AND campaign LIKE '%{$search}%'";
        }
        if ($date_start != "start" && $date_final != "final") {
            $sql_query .= " AND created_at BETWEEN :date_start AND :date_final";
            $sql_params .= "&date_start={$date_start}&date_final={$date_final} 23:59:58";
        }

        $publicity = (new Publicity())->find($sql_query, $sql_params);
        $pager = new Pager(url("/publicity/{$status}/{$type}/{$search}/{$date_start}/{$date_final}/{$order}/"));
        $pager->pager($publicity->count(), 30, $page);

        $head = $this->seo->render(
            "Campanha Publicitária - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );
        echo $this->view->render("publicity/search", [
            "head" => $head,
            "publicities" => $publicity->limit($pager->limit())
                ->offset($pager->offset())
                ->order("id {$order}")
                ->fetch(true),
            "publicityTotal" => $publicity->count(),
            "paginator" => $pager->render(),
            "status" => (new Status())->find()->fetch(true)
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
            $publicity = (new Publicity())->bootstrap(
                $data["status_id"],
                $this->user->id,
                $data["campaign"],
                $data["date"],
                $data["description"],
                !empty($data["date_start"]) ? $data["date_start"] : "",
                !empty($data["date_end"]) ? $data["date_end"] : ""
            );

            if (!$publicity->save()) {
                $json['message'] = $publicity->message()->render();
                echo json_encode($json);
                return;
            }
            $this->message->success("Cadastro realizado com sucesso!")->flash();
            $json["redirect"] = url("publicity/register");
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            "Nova campanha publicitária - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );
        echo $this->view->render("publicity/register", [
            "head" => $head,
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
        if (!empty($data["csrf"])) {
            $data = filter_var_array($data, FILTER_SANITIZE_SPECIAL_CHARS);
            $publicity = (new Publicity())->findById($data["id"]);
            $publicity->campaign = $data["campaign"];
            $publicity->date = $data["date"];
            $publicity->description = $data["description"];
            $publicity->status_id = $data["status_id"];
            $publicity->date_start = !empty($data["date_start"]) ? $data["date_start"] : null;
            $publicity->date_end = !empty($data["date_end"]) ? $data["date_end"] : null;

            if (!$publicity->save()) {
                $json['message'] = $publicity->message()->render();
                echo json_encode($json);
                return;
            }
            $this->message->success("Alteração realizada com sucesso!")->flash();
            $json["redirect"] = url("publicity/view/{$publicity->id}");
            echo json_encode($json);
            return;
        }

        $publicity = (new Publicity())->findById(filter_var($data["id"], FILTER_VALIDATE_INT));
        if (!$publicity) {
            $this->message->warning("Oops {$this->user->first_name}! Você tentou acessar um registro inexistente no banco de dados.")->flash();
            redirect("publicity");
            return;
        }

        $head = $this->seo->render(
            "Editar Campanha - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );
        echo $this->view->render("publicity/edit", [
            "head" => $head,
            "status" => (new Status())->find()->fetch(true),
            "publicity" => $publicity
        ]);
    }

    /**
     * view function
     *
     * @param array $data
     * @return void
     */
    public function view(array $data): void
    {
        $publicity = (new Publicity())->findById(filter_var($data["id"], FILTER_VALIDATE_INT));
        if (!$publicity) {
            $this->message->error("Ooops {$this->user->first_name}! Você tentou acessa um registro inexistente!")->flash();
            redirect(url_back());
            return;
        }
        $head = $this->seo->render(
            "Campanha - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("publicity/view", [
            "head" => $head,
            "publicity" => $publicity,
            "anexos" => (new Anexo())->find("publicity_id=:publicity", "publicity={$publicity->id}")->fetch(true)
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
        $publicity = (new Publicity())->findById(filter_var($data["id"], FILTER_VALIDATE_INT));
        if (!$publicity) {
            $this->message->warning("Ooops {$this->user->first_name}! Você tentou excluir um registro inexistente do banco de dados.")->flash();
        } else {
            $anexo = (new Anexo())->find("publicity_id=:publicity", "publicity={$publicity->id}")->fetch(true);
            if (!empty($anexo)) {
                $upload = new Upload();
                foreach ($anexo as $anexoItem) {
                    $upload->remove(CONF_UPLOAD_DIR . "/{$anexoItem->url}");
                }
                (new Anexo())->delete("publicity_id = :publicity", "publicity={$publicity->id}");
            }
            $publicity = (new Publicity())->findById(filter_var($data["id"], FILTER_VALIDATE_INT));
            $publicity->destroy();
            $this->message->success("Registro removido com sucesso!")->flash();
        }
        redirect("publicity");
    }
    /**
     * registerAnexo function
     *
     * @param array $data
     * @return void
     */
    public function registerAnexo(array $data): void
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

            $anexo = (new Anexo())->bootstrap(
                $data['publicity_id'],
                $this->user->id,
                $data["description"]
            );

            $upload = new Upload();
            if (!$anexo->url = $upload->fromAllTypes($_FILES["url"], date('Y-m-d') . md5(rand(1, 666666) . time()))) {
                $json["message"] = $upload->message()->render();
                echo json_encode($json);
                return;
            }
            if (!$anexo->save()) {
                $json["message"] = $anexo->message()->render();
                echo json_encode($json);
                return;
            }
            $this->message->success("Cadastro realizado com sucessso!")->flash();
            $json["redirect"] = url("publicity/view/{$data["publicity_id"]}");
            echo json_encode($json);
            return;
        }
    }

    /**
     * removeAnexo function
     *
     * @param array $data
     * @return void
     */
    public function removeAnexo(array $data): void
    {
        $anexo = (new Anexo())->findById(filter_var($data["id"], FILTER_VALIDATE_INT));
        $publicity = $anexo->publicity_id;
        if (!$anexo) {
            $this->message->warning("Ooops {$this->user->first_name}! Você tentou excluir um registro inexistente do banco de dados.")->flash();
        } else {
            $upload = new Upload();
            $upload->remove(CONF_UPLOAD_DIR . "/{$anexo->url}");
            $anexo->destroy();
            $this->message->success("Registro removido com sucesso!")->flash();
            redirect("publicity/view/{$publicity}");
        }
        redirect(url_back());
    }
}
