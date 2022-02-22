<?php

namespace App\ValueObject;

class VehicleFilter
{

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string|null
     */
    protected $status;

    /**
     * @param string|null $status
     * @param string|null $type
     */
    public function __construct(?string $status, ?string $type)
    {
        $this->status = $status;
        $this->type = $type;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

}
