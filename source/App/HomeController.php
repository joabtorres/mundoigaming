<?php

namespace Source\App;

use Source\Core\Connect;
use Source\Core\Controller;
use Source\Models\Auth;
use Source\Models\ListId;
use Source\Models\Status;
use Source\Models\Upload;
use Source\Models\User;
use Source\Support\Message;
use Source\Support\Pager;

/**
 * Class HomeController Controller
 *
 * @package Source\App
 * @version 1.0
 */
class HomeController extends Controller
{
    /** @var User */
    private $user;
    /**
     * HomeController construct
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
     * home function
     * @return void
     */
    public function home(?array $data): void
    {

        $head = $this->seo->render(
            CONF_SITE_NAME . " - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );

        $query = ($this->user->level > 1)  ? "id >= :id" : "user_id=:user";

        $param = ($this->user->level > 1)  ? "id=1" : "user={$this->user->id}";

        $page = !empty($data["page"]) ? filter_var($data["page"], FILTER_VALIDATE_INT) : 1;
        $uploads = (new Upload())->find("status_id=:status AND {$query}", "status=1&{$param}");

        $pager = new Pager(url("/"));
        $pager->pager($uploads->count(), 30, $page);

        echo $this->view->render("home", [
            "head" => $head,
            "usersCount" => (new User())->find()->count(),
            "listIdCount" => (new ListId())->find()->count(),
            "uploadCount" => (new Upload())->find()->count(),
            "uploads" => $uploads->limit($pager->limit())
                ->offset($pager->offset())
                ->order("id ASC")
                ->fetch(true),
            "paginator" => $pager->render()
        ]);
    }
}
