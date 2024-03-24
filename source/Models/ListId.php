<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * Class ListId
 *
 * @package Source\Model
 * @version 1.0
 */
class ListId extends Model
{

    /**
     * ListId constructor.
     */
    public function __construct()
    {
        parent::__construct(
            "list_id",
            ["id"],
            ["identify", "name"]
        );
    }

    /**
     * bootstrap function
     *
     * @param string $identify
     * @param string $name
     * @return ListId
     */
    public function bootstrap(string $identify, string $name): ListId
    {
        $this->identify = $identify;
        $this->name = $name;
        return $this;
    }
    public function save(): bool
    {
        if (empty($this->identify)) {
            $this->message->error("Informe o id.")->render();
            return false;
        }
        if (empty($this->name)) {
            $this->message->error("Informe o nome.")->render();
            return false;
        }
        $idList = !empty($this->id) ? $this->id : null;
        //update
        if ($idList) {
            if ($this->find("identify=:identify AND id != :id", "identify={$this->identify}&id={$this->id}")->count()) {
                $this->message->warning("Este ID já está sendo utilizado por outros registro.")->render();
                return false;
            }
        } else {
            //created
            if ($this->find("identify=:identify", "identify={$this->identify}")->count()) {
                $this->message->warning("Este ID já está registrado.")->render();
                return false;
            }
        }

        return parent::save();
    }
}
