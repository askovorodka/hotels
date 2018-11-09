<?php

namespace AppBundle\Services\Rotation\Order\ValueObject;

/**
 * Class OrderDto
 *
 * @package AppBundle\Services\Rotation\Order\Dto
 */
class Order
{
    public $table;

    /**
     * @var string
     */
    public $field;

    /**
     * @var int|null
     */
    public $num;

    /**
     * @var mixed|null
     */
    public $value;

    /**
     * @var string
     */
    public $direction = 'asc';

    /**
     * OrderDto constructor.
     *
     * @param string $table
     * @param string $field
     */
    public function __construct(string $table, string $field)
    {
        $this->table = $table;
        $this->field = $field;
    }

}
