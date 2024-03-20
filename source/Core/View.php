<?php

namespace Source\Core;

use League\Plates\Engine;

/**
 * Class View
 *
 * @package Source\Core
 * @author Joab T. Alencar <contato@joabtorres.com.br>
 * @version 1.0
 */
class View
{
    /** @var Engine */
    private Engine $engine;

    /**
     * Construct para instancia a classe Engine e seta os valores padrões
     *
     * @param string $path
     * @param string $ext
     */
    public function __construct(string $path = CONF_VIEW_PATH, string $ext = CONF_VIEW_EXT)
    {
        $this->engine = new Engine($path, $ext);
    }

    /**
     * Função para adicionar um caminho de diretorio;
     *
     * @param string $name
     * @param string $path
     *
     * @return $this
     */
    public function path(string $name, string $path): View
    {
        $this->engine->addFolder($name, CONF_VIEW_PATH."/{$path}");
        return $this;
    }

    /**
     * Função para renderizar uma view com array data
     *
     * @param string $templateName
     * @param array  $data
     *
     * @return string
     */
    public function render(string $templateName, array $data): string
    {
        return $this->engine->render($templateName, $data);
    }

    /**
     * Função para retornar o objeto da classe Engine
     *
     * @return Engine
     */
    public function engine(): Engine
    {
        return $this->engine();
    }
}