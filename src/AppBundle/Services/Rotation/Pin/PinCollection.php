<?php

namespace AppBundle\Services\Rotation\Pin;

use AppBundle\Services\Rotation\Pin\ValueObject\Pin;

/**
 * Class PinCollection
 *
 * @package AppBundle\Services\Rotation\Pin
 */
class PinCollection implements \Iterator
{
    /**
     * @var Pin[]
     */
    private $pins = [];

    /**
     * @var Pin[][]
     */
    private $pinsByPosition = [];

    /**
     * @var Pin[][]
     */
    private $pinsByPinnedHotelId = [];

    /**
     * @var Pin[][]
     */
    private $pinsByPinnedPresetId = [];

    /**
     * @param Pin $pin
     * @return PinCollection
     */
    public function add(Pin $pin): self
    {
        $this->pins[] = $pin;

        $this->pinsByPosition[$pin->category][$pin->position] = $pin;

        if ($pin->pinnedHotelId !== null) {
            $this->pinsByPinnedHotelId[$pin->category][$pin->pinnedHotelId] = $pin;
        }

        if ($pin->pinnedPresetId !== null) {
            $this->pinsByPinnedPresetId[$pin->category][$pin->pinnedPresetId] = $pin;
        }

        return $this;
    }

    /**
     * @param string $category
     * @param int    $position
     * @return Pin|null
     */
    public function getPinByPosition(string $category, int $position): ?Pin
    {
        return $this->pinsByPosition[$category][$position] ?? null;
    }

    /**
     * @param string $category
     * @param int    $pinnedHotelId
     * @return Pin|null
     */
    public function getPinByPinnedHotelId(string $category, int $pinnedHotelId): ?Pin
    {
        return $this->pinsByPinnedHotelId[$category][$pinnedHotelId] ?? null;
    }

    /**
     * @param string $category
     * @param int    $pinnedPresetId
     * @return Pin|null
     */
    public function getPinByPinnedPresetId(string $category, int $pinnedPresetId): ?Pin
    {
        return $this->pinsByPinnedPresetId[$category][$pinnedPresetId] ?? null;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return \count($this->pins);
    }

    /**
     * @inheritdoc
     */
    public function current(): Pin
    {
        return current($this->pins);
    }

    /**
     * @inheritdoc
     */
    public function next(): void
    {
        next($this->pins);
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        return key($this->pins);
    }

    /**
     * @inheritdoc
     */
    public function valid(): bool
    {
        return key($this->pins) !== null;
    }

    /**
     * @inheritdoc
     */
    public function rewind(): void
    {
        reset($this->pins);
    }
}
