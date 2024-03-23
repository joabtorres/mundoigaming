<?php

namespace Source\App;

use Source\Core\Connect;
use Source\Core\Controller;
use Source\Models\Auth;
use Source\Models\Company;
use Source\Support\Message;
use Source\Support\Pager;

/**
 * Class CompanyController Controller
 *
 * @package Source\App
 * @author  Joab T. Alencar <contato@joabtorres.com.br>
 * @version 1.0
 */
class CompanyController extends Controller
{
    /** @var User */
    private $user;
    /**
     * CompanyController construct
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
            $json["redirect"] = url("company/{$type}/{$search}/{$date_start}/{$date_final}/{$order}/1");
            echo json_encode($json);
            return;
        }

        $sql_query = "id > 0";
        $sql_params = null;
        if ($type != "type" && $search != "search") {
            $sql_query = "full_name LIKE '%{$search}%'";
        }

        if ($date_start != "start" && $date_final != "final") {
            $sql_query .= " AND created_at BETWEEN :date_start AND :date_final";
            $sql_params .= "date_start={$date_start}&date_final={$date_final} 23:59:58";
        }

        $companies = (new Company())->find($sql_query, $sql_params);
        $pager = new Pager(url("/company/{$type}/{$search}/{$date_start}/{$date_final}/{$order}/"));
        $pager->pager($companies->count(), 30, $page);

        $head = $this->seo->render(
            "Empresa - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );
        echo $this->view->render("company/search", [
            "head" => $head,
            "companies" => $companies->limit($pager->limit())
                ->offset($pager->offset())
                ->order("id {$order}")
                ->fetch(true),
            "companyTotal" => $companies->count(),
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
            if (empty($data["full_name"])) {
                $json["message"] = $this->message->error("Informe o nome completo da empresa.")->render();
                echo json_encode($json);
                return;
            }
            if (empty($data["address"])) {
                $json["message"] = $this->message->error("Informe o endereço da empresa.")->render();
                echo json_encode($json);
                return;
            }
            if (empty($data["cnpj"])) {
                $json["message"] = $this->message->error("Informe o CNPJ.")->render();
                echo json_encode($json);
                return;
            }

            $company = (new Company())->bootstrap(
                $data["full_name"],
                $data["address"],
                $data["cnpj"],
                $data["phone"],
                $data["email"]
            );
            if (!$company->save()) {
                $json["message"] = $company->message()->render();
                echo json_encode($json);
                return;
            }
            $this->message->success("Cadastro realizado com sucesso!")->flash();
            $json["redirect"] = url("company");
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
            if (empty($data["full_name"])) {
                $json["message"] = $this->message->error("Informe o nome completo da empresa.")->render();
                echo json_encode($json);
                return;
            }
            if (empty($data["address"])) {
                $json["message"] = $this->message->error("Informe o endereço da empresa.")->render();
                echo json_encode($json);
                return;
            }
            if (empty($data["cnpj"])) {
                $json["message"] = $this->message->error("Informe o CNPJ.")->render();
                echo json_encode($json);
                return;
            }

            $company = (new Company())->findById(filter_var($data["company"], FILTER_VALIDATE_INT));
            $company->full_name = $data["full_name"];
            $company->address = $data["address"];
            $company->cnpj = $data["cnpj"];
            $company->email = $data["email"];
            $company->phone = $data["phone"];

            if (!$company->save()) {
                $json["message"] = $company->message()->render();
                echo json_encode($json);
                return;
            }
            $json["message"] = $this->message->success("Alteração realizada com sucesso!")->render();
            echo json_encode($json);
            return;
        }

        $company = (new Company())->findById(filter_var($data["company"], FILTER_VALIDATE_INT));
        if (!$company) {
            $this->message->warning("Oops {$this->user->first_name}! Você tentou acessar um registro inexistente no banco de dados.")->flash();
            redirect("company");
            return;
        }
        $head = $this->seo->render(
            "Editar Empresa - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );
        echo $this->view->render("company/edit", [
            "head" => $head,
            "company" => $company
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
        $company = (new Company())->findById(filter_var($data["company"], FILTER_VALIDATE_INT));
        if (!$company) {
            $this->message->warning("Ooops {$this->user->first_name}! Você tentou excluir um registro inexistente do banco de dados.")->flash();
        } else {
            $company->destroy();
            $this->message->success("Registro removido com sucesso!")->flash();
        }
        redirect("company");
    }
}
