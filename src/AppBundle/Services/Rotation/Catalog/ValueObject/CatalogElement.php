<?php

namespace AppBundle\Services\Rotation\Catalog\ValueObject;

/**
 * Class CatalogElement
 *
 * @package AppBundle\Services\Rotation\Catalog\ValueObject
 */
class CatalogElement implements \JsonSerializable
{
    public const TYPE_HOTEL = 'hotel';
    public const TYPE_PRESET = 'preset';

    public const AVAILABLE_TYPES = [
        self::TYPE_HOTEL,
        self::TYPE_PRESET,
    ];

    /**
     * @var string
     */
    private $type;

    /**
     * @var mixed
     */
    private $data;

    /**
     * CatalogElement constructor.
     *
     * @param string $type
     * @param mixed  $data
     */
    public function __construct(string $type, $data)
    {
        if (!\in_array($type, self::AVAILABLE_TYPES, true)) {
            throw new \InvalidArgumentException('Invalid type');
        }

        $this->type = $type;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'data' => $this->data,
        ];
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
