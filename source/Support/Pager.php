<?php

namespace Source\Support;

use CoffeeCode\Paginator\Paginator;

/**
 * Class Pager | responsável por manipular o componente Paginator
 *
 * @package Source\Support
 * @author Joab T. Alencar <contato@joabtorres.com.br>
 * @version 1.0
 */
class Pager extends Paginator
{
    /**
     * Pager constructor.
     *
     * @param string $link
     * @param null|string $title
     * @param array|null $first
     * @param array|null $last
     */
    public function __construct(string $link, ?string $title = null, ?array $first = null, ?array $last = null)
    {
        parent::__construct($link, $title, $first, $last);
    }
}