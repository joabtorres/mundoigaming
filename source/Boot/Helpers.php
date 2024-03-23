<?php

/**
 * ####################
 * ###   VALIDATE   ###
 * ####################
 */

use Source\Support\Message;

/**
 * Função para verificar se é um email válido
 *
 * @param string $email
 *
 * @return bool
 */
function is_email(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Função para verificar se $password é maior igual que o CONF_PASSWD_MIN_LEN ou menor igual CONF_PASSWD_MAX_LEN
 *
 * @param string $password
 *
 * @return bool
 */
function is_passwd(string $password): bool
{
    if (
        password_get_info($password)['algo']
        || (mb_strlen($password) >= CONF_PASSWD_MIN_LEN
            && mb_strlen($password) <= CONF_PASSWD_MAX_LEN)
    ) {
        return true;
    }

    return false;
}

/**
 * ##################
 * ###   STRING   ###
 * ##################
 */

/**
 * Função para alterar uma string qualquer em uma url amigavel
 *
 * @param string $string
 *
 * @return string Ex: essa-e-uma-url-amigavel
 */
function str_slug(string $string): string
{
    $string = filter_var(mb_strtolower($string), FILTER_SANITIZE_STRIPPED);
    $formats
        = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<br>°ºª';
    $replace
        = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';

    $slug = str_replace(
        ["-----", "----", "---", "--"],
        "-",
        str_replace(
            " ",
            "-",
            trim(strtr(utf8_decode($string), utf8_decode($formats), $replace))
        )
    );
    return $slug;
}

/**
 * Função para transformar uma string em uma classe studly case
 *
 * @param string $string
 *
 * @return string Ex: CarroModel
 */
function str_studly_case(string $string): string
{
    $string = str_slug($string);
    $studlyCase = str_replace(
        " ",
        "",
        mb_convert_case(str_replace("-", " ", $string), MB_CASE_TITLE)
    );

    return $studlyCase;
}

/**
 *
 * Funcao para transforma uma string em um metodo ou variavel camel case
 *
 * @param string $string
 *
 * @return string Ex: chamaFuncao
 */
function str_camel_case(string $string): string
{
    return lcfirst(str_studly_case($string));
}

/**
 * Função para transformar o string em um título
 *
 * @param string $string texto do titulo
 *
 * @return string
 */
function str_title(string $string): string
{
    return mb_convert_case(
        filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS),
        MB_CASE_TITLE
    );
}

/**
 *
 * Formata o paragrafo de um textarea
 * @param string $text
 * @return string
 */
function str_textarea(string $text): string
{
    $text = str_replace(array("\r\n", "\r", "\n", PHP_EOL), "<br />", $text);
    $arrayReplace = ["<br/><br/><br/><br/><br/>", "<br/><br/><br/><br/>", "<br/><br/><br/>", "<br/><br/>", "<br/>"];
    return str_replace($arrayReplace, "<br/>", $text);
}

/**
 * Função para limitar a quantidade de uma string por palavras
 *
 * @param string $string texto
 * @param int    $limit  limite de palavras
 * @param string $pointer
 *
 * @return string
 */
function str_limit_words(
    string $string,
    int $limit,
    string $pointer = "..."
): string {
    $string = trim(filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS));
    $arrWords = explode(" ", $string);
    $numWords = count($arrWords);

    if ($numWords < $limit) {
        return $string;
    }

    $words = implode(" ", array_slice($arrWords, 0, $limit));
    return "{$words}{$pointer}";
}

/**
 * Função para limitar a quantidade de uma string por caracter
 *
 * @param string $string texto
 * @param int    $limit  limite de letras
 * @param string $pointer
 *
 * @return string
 */
function str_limit_chars(
    string $string,
    int $limit,
    string $pointer = "..."
): string {
    $string = trim(filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS));
    if (mb_strlen($string) <= $limit) {
        return $string;
    }

    $chars = mb_substr(
        $string,
        0,
        mb_strrpos(mb_substr($string, 0, $limit), " ")
    );
    return "{$chars}{$pointer}";
}

/**
 * ###############
 * ###   URL   ###
 * ###############
 */

/**
 * @param string|null $path
 *
 * @return string
 */
function url(string $path = null): string
{
    if (strpos($_SERVER['HTTP_HOST'], "localhost")) {
        if ($path) {
            return CONF_URL_TEST . "/" . ($path[0] == "/" ? mb_substr($path, 1)
                : $path);
        }
        return CONF_URL_TEST;
    }
    if ($path) {
        return CONF_URL_BASE . "/" . ($path[0] == "/" ? mb_substr($path, 1)
            : $path);
    }
    return CONF_URL_BASE;
}

/**
 * @return string
 */
function url_back(): string
{
    return ($_SERVER['HTTP_REFERER'] ?? url());
}


/**
 * Função para redirecionar Url
 *
 * @param string $url
 *
 * @return void
 */
function redirect(string $url): void
{
    header("HTTP/1.1 302 Redirect");
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        header("Location: {$url}");
        exit;
    }
    if (filter_input(INPUT_GET, "route", FILTER_DEFAULT) != $url) {
        $location = url($url);
        header("Location: {$location}");
        exit;
    }
}

/**
 * ##################
 * ###   ASSETS   ###
 * ##################
 */

/**********************************
 * 
 *********************************/

/**
 * Instancia do model Auth
 * @return \Source\Models\User|null
 */
function user()
{
    return \Source\Models\Auth::user();
}
/**
 * message function Instancia da classe Message
 *
 * @return \Source\Models\Message
 */
function message(): Message
{
    return new \Source\Support\Message();;
}

/**
 * list_user_level function lista de acesso ao sistema
 *
 * @return array $levels lista dos níveis de acesso
 */
function list_user_level(): array
{
    return $levels = [
        ["value" => 1, "label" => "Básico"],
        ["value" => 2, "label" => "Administrador"]
    ];
}
/**
 * user_level function
 *
 * @param integer $require
 * @return void
 */
function user_level(int $require): void
{
    if (user()->level < $require) {
        message()->warning("Oops, " . user()->first_name . "! Parece que você não possui o nível de acesso necessário para realizar essa ação.")->flash();
        redirect("/");
    }
}

/**
 * @param string|null $path
 *
 * @return string
 */
function theme(string $path = null): string
{
    if (strpos($_SERVER['HTTP_HOST'], "localhost")) {
        if ($path) {
            return CONF_URL_TEST . "/themes/" . CONF_VIEW_THEME . "/"
                . ($path[0] == "/" ? mb_substr($path, 1) : $path);
        }
        return CONF_URL_TEST . "/themes/" . CONF_VIEW_THEME;
    }
    if ($path) {
        return CONF_URL_BASE . "/themes/" . CONF_VIEW_THEME . "/" . ($path[0]
            == "/" ? mb_substr($path, 1) : $path);
    }
    return CONF_URL_BASE . "/themes/" . CONF_VIEW_THEME;
}

/**
 * @param string $image
 * @param int $width
 * @param int|null $height
 *
 * @return string
 */
function image(string $image, int $width, int $height = null): string
{
    return url() . "/" . (new \Source\Support\Thumb())->make(
        $image,
        $width,
        $height
    );
}
/**
 * bgcolor_options function retorna array com lista de opcoes de background para labels, muito utilizado em status
 *
 * @return array $options
 */
function bgcolor_options(): array
{
    return $options = [
        ['value' => 'bg-primary', 'label' => 'Azul'],
        ['value' => 'bg-info', 'label' => 'Azul claro'],
        ['value' => 'bg-secondary', 'label' => 'Cinza'],
        ['value' => 'bg-success', 'label' => 'Verde'],
        ['value' => 'bg-danger', 'label' => 'Vermelho'],
        ['value' => 'bg-light', 'label' => 'Branco'],
        ['value' => 'bg-dark', 'label' => 'Preto'],
        ['value' => 'bg-warning', 'label' => 'Amarelo'],
        ['value' => 'bg-transparent', 'label' => 'Transparente']
    ];
}
/**
 * count_reg function 
 *
 * @param integer $count
 * @return string $count  x registros encontrados | 1 registro encontrado"  | nenhum registro encontrado
 */
function count_reg(int $count): string
{
    if ($count > 1) {
        return "{$count} registros encontrados";
    } else if ($count == 1) {
        return "{$count} registro encontrado";
    }
    return "nenhum registro encontrado";
}
/**
 * ################
 * ###   DATE   ###
 * ################
 */

/**
 * date_fmt function 
 *
 * @param string $date
 * @param string $format string que retorna data em  d/m/Y H\hi
 *
 * @return string
 */
function date_fmt(string $date = "now", string $format = "d/m/Y H:i\h"): string
{
    return (new DateTime($date))->format($format);
}

/**
 * date_fmt_br function 
 *
 * @param string $date
 *
 * @return string string que retorna data em d/m/Y H:i:s
 */
function date_fmt_br(string $date = "now"): string
{
    return (new DateTime($date))->format(CONF_DATE_BR);
}

/**
 * Função string que retorna data em  Y-m-d H:i:s
 *
 * @param string $date
 *
 * @return string
 */
function date_fmt_app(string $date = "now"): string
{
    return (new DateTime($date))->format(CONF_DATE_APP);
}
/**
 * date_from_days function
 *
 * @param string $date
 * @param string $dateDif
 * @return string
 */
function date_from_days(string $date = "now", string $dateDif = "now"): string
{
    $date_start = new DateTime($date);
    $date_final = new DateTime($dateDif);

    $dateInterval = $date_start->diff($date_final);

    return "{$dateInterval->days} dias";
}

/**
 * ####################
 * ###   PASSWORD   ###
 * ####################
 */

/**
 * passwd function transforma a senha informada pelo usuário em um hash
 *
 * @param string $password
 *
 * @return string hash de senha
 */
function passwd(string $password): string
{
    if (!empty(password_get_info($password)['algo'])) {
        return $password;
    }
    return password_hash($password, CONF_PASSWD_ALGO, CONF_PASSWD_OPTION);
}

/**
 * passwd_verify function verifica se senha e igual ao hash
 *
 * @param string $password
 * @param string $hash
 *
 * @return bool
 */
function passwd_verify(string $password, string $hash): bool
{
    return password_verify($password, $hash);
}

/**
 *
 * passwd_rehash function verifica se precisa atualizar o hash da senha
 *
 * @param string $hash
 *
 * @return bool
 */
function passwd_rehash(string $hash): bool
{
    return password_needs_rehash($hash, CONF_PASSWD_ALGO, CONF_PASSWD_OPTION);
}

/**
 * ###################
 * ###   REQUEST   ###
 * ###################
 */

/**
 * csrf_input function
 *
 * @return string retorna um input com token de validação do formulário
 */
function csrf_input(): string
{
    $session = new \Source\Core\Session();
    $session->csrf();
    return "<input type='hidden' name='csrf' value='" . ($session->csrf_token ??
        "") . "'/>";
}


/**
 * csrf_verify function verifica se csrf foi gerado pela aplicação
 *
 * @param string $csrf
 * @return boolean true|false
 */
function csrf_verify(string $csrf): bool
{
    $session = new \Source\Core\Session();
    if (
        empty($session->csrf_token) || empty($csrf)
        || $csrf != $session->csrf_token
    ) {
        return false;
    }
    return true;
}


/**
 * flash function retorna a ultima messagem da classe Message salvo em sessão
 *
 * @return string|null
 */
function flash(): ?string
{
    $session = new \Source\Core\Session();
    if ($flash = $session->flash()) {
        echo $flash;
    }
    return null;
}
