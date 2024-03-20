<?php

namespace Source\Models\Publicity;

use Source\Core\Model;
use Source\Models\Publicity;
use Source\Models\User;

/**
 * class Anexo
 *
 * @package Source\Model\Publicity
 * @author  Joab T. Alencar <contato@joabtorres.com.br>
 * @version 1.0
 */
class Anexo extends Model
{
    /**
     * Anexo constructor.
     */
    public function __construct()
    {
        parent::__construct(
            "publicities_anexos",
            ["id"],
            ["publicity_id", "user_id", "description", "url"]
        );
    }

    /**
     * bootstrap function
     *
     * @param integer $publicity_id
     * @param integer $user_id
     * @param string $description
     * @param array|null $url
     * @return Anexo
     */
    public function bootstrap(
        int $publicity_id,
        int $user_id,
        string $description,
        array $url = null
    ): Anexo {
        $this->publicity_id = $publicity_id;
        $this->user_id = $user_id;
        $this->description = $description;
        $this->url = $url;
        return $this;
    }

    /**
     * user function
     *
     * @return User
     */
    public function user(): User
    {
        return (new User())->findById($this->user_id);
    }

    /**
     * publicity function
     *
     * @return Publicity
     */
    public function publicity(): Publicity
    {
        return (new Publicity())->findById($this->publicity_id);
    }
    /**
     * save function
     *
     * @return boolean
     */
    public function save(): bool
    {

        return parent::save();
    }
}
