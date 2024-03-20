<?php

namespace Source\Support;

use CoffeeCode\Cropper\Cropper;

/**
 * Class Thumb | responsável para manipular o componente Cropper e gerar imagens em cache
 *
 * @package Source\Support
 * @author Joab T. Alencar <contato@joabtorres.com.br>
 * @version 1.0
 */
class Thumb
{
    /** @var Cropper */
    private Cropper $cropper;

    /** @var string */
    private string $uploads;

    /**
     * Thumb constructor.
     */
    public function __construct()
    {
        $this->cropper = new Cropper(CONF_IMAGE_CACHE, CONF_IMAGE_QUALITY['jpg'], CONF_IMAGE_QUALITY['png']);
        $this->uploads = CONF_UPLOAD_DIR;
    }

    /**
     * Função para gerar image thumbnail em cache
     *
     * @param string   $image
     * @param int      $width
     * @param int|null $height
     *
     * @return string
     */
    public function make(string $image, int $width, ?int $height = null): string
    {
        return $this->cropper->make("{$this->uploads}/{$image}", $width, $height);
    }

    /**
     * Função para remover image em cache
     *
     * @param string|null $image
     *
     * @return void
     */
    public function flush(?string $image = null): void
    {
        if ($image) {
            $this->cropper->flush("{$this->uploads}/{$image}");
            return;
        }

        $this->cropper->flush();
        return;
    }

    /**
     * Função responsável para retorna o objeto Cropper
     *
     * @return Cropper
     */
    public function cropper(): Cropper
    {
        return $this->cropper;
    }
}