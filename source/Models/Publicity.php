<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * Class Publicity
 *
 * @package Source\Model
 * @author  Joab T. Alencar <contato@joabtorres.com.br>
 * @version 1.0
 */
class Publicity extends Model
{
    /**
     * Publicity constructor.
     */
    public function __construct()
    {
        parent::__construct(
            "publicities",
            ["id"],
            ["status_id", "user_id", "campaign", "date", "description"]
        );
    }
    /**
     * bootstrap function
     *
     * @param integer $status_id
     * @param integer $user_id
     * @param string $campaign
     * @param string $date
     * @param string|null $description
     * @param string|null $date_start
     * @param string|null $date_end
     * @return Publicity
     */
    public function bootstrap(
        int $status_id,
        int $user_id,
        string $campaign,
        string $date,
        ?string $description = null,
        ?string $date_start = null,
        ?string $date_end = null
    ): Publicity {
        $this->status_id = $status_id;
        $this->user_id = $user_id;
        $this->campaign = $campaign;
        $this->date = $date;
        $this->description = $description;
        $this->date_start = $date_start;
        $this->date_end = $date_end;
        return $this;
    }
    /**
     * status function
     *
     * @return Sector
     */
    public function status(): Status
    {
        return (new Status())->findById($this->status_id);
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
     * save function
     *
     * @return boolean
     */
    public function save(): bool
    {
        if (!$this->required()) {
            $this->message->warning("O nome da campanha, data comemorativa, descrição e status são campos obrigatórios.");
            return false;
        }

        $publictyId = !empty($this->id) ? $this->id : null;
        if ($publictyId && ($this->find(
            "campaign = :name AND date = :date AND id != :id",
            "name={$this->campaign}&date={$this->date}&id={$publictyId}"
        )->count())) {
            $this->message()->info("Está campanha publicitária já está registrada no sistema.");
            return false;
        } else if ($this->find(
            "campaign = :name AND date = :date",
            "name={$this->campaign}&date={$this->date}"
        )->count()) {
            $this->message()->info("Está campanha publicitária já está registrada no sistema.");
            return false;
        }

        list($day, $month, $year) = explode("/", $this->date);
        $this->date = "{$year}-{$month}-{$day}";
        if (!empty($this->date_start)) {
            list($day, $month, $year) = explode("/", $this->date_start);
            $this->date_start = "{$year}-{$month}-{$day}";
        }
        if (!empty($this->date_end)) {
            list($day, $month, $year) = explode("/", $this->date_end);
            $this->date_end = "{$year}-{$month}-{$day}";
        }

        $this->description = str_textarea($this->description);
        return  parent::save();
    }
}
