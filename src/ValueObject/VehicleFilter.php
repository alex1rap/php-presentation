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
     * @var integer
     */
    protected $offset;

    /**
     * @var integer
     */
    protected $limit;

    /**
     * @param string|null $status
     * @param string|null $type
     * @param int $offset
     * @param int $limit
     */
    public function __construct(?string $status, ?string $type, int $offset = 0, int $limit = 10)
    {
        $this->status = $status;
        $this->type = $type;
        $this->offset = $offset;
        $this->limit = $limit;
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

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

}
