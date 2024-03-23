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
}
