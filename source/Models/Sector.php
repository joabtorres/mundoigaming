<?php

namespace Source\Models;

use Source\Core\Model;


/**
 * Class Sector
 *
 * @package Source\Model
 * @author  Joab T. Alencar <contato@joabtorres.com.br>
 * @version 1.0
 */
class Sector extends Model
{
    /**
     * Sector constructor.
     */
    public function __construct()
    {
        parent::__construct(
            "sectors",
            ["id"],
            ["company_id", "name"]
        );
    }
    /**
     * bootstrap function
     *
     * @param integer $company_id
     * @param string $name
     * @param string $abbreviation
     * @return Status
     */
    public function bootstrap(int $company_id, string $name, string $abbreviation,): Sector
    {
        $this->name = $name;
        $this->abbreviation = $abbreviation;
        $this->company_id = $company_id;
        return $this;
    }
    /**
     * company function
     *
     * @return Company|null
     */
    public function company(): ?Company
    {
        if ($this->company_id) {
            return (new Company())->findById($this->company_id);
        }
    }
}
