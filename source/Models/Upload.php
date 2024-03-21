<?php

namespace Source\Models;

use Source\Core\Model;
use Source\Models\User;

/**
 * class Upload
 *
 * @package Source\Model\Publicity
 * @author  Joab T. Alencar <contato@joabtorres.com.br>
 * @version 1.0
 */
class Upload extends Model
{
    /**
     * Upload constructor.
     */
    public function __construct()
    {
        parent::__construct(
            "uploads",
            ["id"],
            ["status_id", "user_id", "description", "url"]
        );
    }

    /**
     * bootstrap function
     *
     * @param integer $status_id
     * @param integer $user_id
     * @param string $description
     * @param array|null $url
     * @return Upload
     */
    public function bootstrap(
        int $status_id,
        int $user_id,
        string $description,
        array $url = null
    ): Upload {
        $this->status_id = $status_id;
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
     * status function
     *
     * @return Status
     */
    public function status(): Status
    {
        return (new Status)->findById($this->status_id);
    }
}
