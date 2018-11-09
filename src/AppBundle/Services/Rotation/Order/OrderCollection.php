<?php

namespace AppBundle\Services\Rotation\Order;

use AppBundle\Services\Rotation\Order\ValueObject\Order;

/**
 * Class OrderCollection
 *
 * @package AppBundle\Services\Rotation\Order
 */
class OrderCollection
{
    /**
     * @var Order[][]
     */
    private $valueOrdersGroupedByNum = [];

    /**
     * @var Order[]
     */
    private $simpleOrders = [];

    /**
     * @param Order $order
     * @return $this
     */
    public function add(Order $order): self
    {
        if ($order->num === null) {
            $this->simpleOrders[] = $order;
        } else {
            $this->valueOrdersGroupedByNum[$order->num][] = $order;
            ksort($this->valueOrdersGroupedByNum);
        }

        return $this;
    }

    /**
     * @return Order[]
     */
    public function getSimpleOrders(): array
    {
        return $this->simpleOrders;
    }

    /**
     * @return ValueObject\Order[][]
     */
    public function getValueOrdersGroupedByNum(): array
    {
        return $this->valueOrdersGroupedByNum;
    }
}
