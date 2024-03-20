<?php

namespace Source\App;

use Source\Core\Connect;
use Source\Core\Controller;
use Source\Models\Auth;
use Source\Models\Publicity;
use Source\Models\Status;
use Source\Models\User;
use Source\Support\Message;

/**
 * Class HomeController Controller
 *
 * @package Source\App
 * @author  Joab T. Alencar <contato@joabtorres.com.br>
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
    public function home(): void
    {
        $head = $this->seo->render(
            CONF_SITE_NAME . " - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );
        echo $this->view->render("home", [
            "head" => $head,
            "usersCount" => (new User())->find()->count(),
            "publicitiesCount" => (new Publicity())->find()->count(),
            "statusCount" => (new Status())->find()->count(),
            "publicities" => (new Publicity())->find("date > :date", "date=" . date_fmt("now", "Y-m-d"))->order("date ASC")->fetch(true)
        ]);
    }
}
