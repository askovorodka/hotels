<?php

namespace AppBundle\Services\Rotation\Order;

use AppBundle\Entity\Preset;
use AppBundle\Services\Rotation\Order\ValueObject\Order;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

/**
 * Class OrderProvider
 *
 * @package AppBundle\Services\Rotation\Order
 */
class OrderProvider implements OrderProviderInterface
{
    /**
     * @var CamelCaseToSnakeCaseNameConverter
     */
    private $nameConverter;

    /**
     * OrderProvider constructor.
     *
     * @param CamelCaseToSnakeCaseNameConverter $nameConverter
     */
    public function __construct(CamelCaseToSnakeCaseNameConverter $nameConverter)
    {
        $this->nameConverter = $nameConverter;
    }

    /**
     * @param string $path
     * @return string
     */
    private function getTableByPath(string $path): string
    {
        $parts = explode('.', $path);

        if (\count($parts) === 1) {
            return 'hotel';
        }

        return $parts[0];
    }

    /**
     * @param string $path
     * @return string
     */
    private function getFieldByPath(string $path): string
    {
        $parts = explode('.', $path);
        return end($parts);
    }

    /**
     * @inheritdoc
     */
    public function getOrders(Preset $preset, ?array $extraOrders = []): OrderCollection
    {
        $orderCollection = new OrderCollection();

        // Если переданы дополнительные сортировки, учитываем только их без учета сортировок самой подборки
        if ($extraOrders) {
            foreach ($extraOrders as $path => $orderDirection) {
                $path = $this->nameConverter->normalize($path);
                $table = $this->getTableByPath($path);
                $field = $this->getFieldByPath($path);

                $orderDto = new Order($table, $field);
                $orderDto->direction = $orderDirection;

                $orderCollection->add($orderDto);
            }
        }

        $presetParams = $preset->getParams();

        $sorts = $presetParams['sorts'] ?? [];

        foreach ($sorts as $path => $rawOrders) {
            // Преобразуем путь(таблица + имя поля) из camelCase в snake_case
            $path = $this->nameConverter->normalize($path);
            $table = $this->getTableByPath($path);
            $field = $this->getFieldByPath($path);

            foreach ($rawOrders as $rawOrder) {
                $num = $rawOrder['order'] ?? null;

                if ($field && $num !== null) {
                    $orderDto = new Order($table, $field);
                    $orderDto->num = $num;

                    $value = $rawOrder['value'] ?? null;
                    if ($value !== null) {
                        $orderDto->value = $value;
                    }

                    $direction = $rawOrder['direction'] ?? null;
                    if ($direction == 'asc' || $direction == 'desc') {
                        $orderDto->direction = $direction;
                    }

                    $orderCollection->add($orderDto);
                }
            }
        }

        return $orderCollection;
    }
}
