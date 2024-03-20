<?php

namespace Source\Models;

use Source\Core\Model;


/**
 * Class Status
 *
 * @package Source\Model
 * @author  Joab T. Alencar <contato@joabtorres.com.br>
 * @version 1.0
 */
class Status extends Model
{
    /**
     * Sector constructor.
     */
    public function __construct()
    {
        parent::__construct(
            "status",
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
     * @return Sector
     */
    public function bootstrap(int $company_id, string $name, string $class_color,): Status
    {
        $this->name = $name;
        $this->class_color = $class_color;
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
