<?php

namespace AppBundle\Services\Rotation\Catalog;

use AppBundle\Services\Rotation\Catalog\ValueObject\CatalogElement;
use AppBundle\Services\Rotation\Dto\HotelDto;
use AppBundle\Services\Rotation\Dto\PresetDto;

/**
 * Class Catalog
 *
 * @package AppBundle\Services\Rotation
 */
class Catalog
{
    /**
     * @var CatalogElement[]
     */
    private $banners = [];

    /**
     * @var CatalogElement[]
     */
    private $items = [];

    private $catalogHotelCache = [];

    private $catalogPresetCache = [];

    private $bannerHotelCache = [];

    private $bannerPresetCache = [];

    /**
     * @param HotelDto $hotel
     * @return bool
     */
    public function addHotelToCatalogIfNotExists(HotelDto $hotel): bool
    {
        if (isset($this->catalogHotelCache[$hotel->id])) {
            return false;
        }

        $catalogEl = new CatalogElement(CatalogElement::TYPE_HOTEL, $hotel);

        $this->items[] = $catalogEl;
        $this->catalogHotelCache[$hotel->id] = true;

        return true;
    }

    /**
     * @param PresetDto $preset
     * @return bool
     */
    public function addPresetToCatalogIfNotExists(PresetDto $preset): bool
    {
        if (isset($this->catalogPresetCache[$preset->id])) {
            return false;
        }

        $catalogEl = new CatalogElement(CatalogElement::TYPE_PRESET, $preset);

        $this->items[] = $catalogEl;
        $this->catalogHotelCache[$preset->id] = true;

        return true;
    }

    /**
     * @param HotelDto $hotel
     * @return bool
     */
    public function addHotelToBannersIfNotExists(HotelDto $hotel): bool
    {
        if (isset($this->bannerHotelCache[$hotel->id])) {
            return false;
        }

        $catalogEl = new CatalogElement(CatalogElement::TYPE_HOTEL, $hotel);

        $this->banners[] = $catalogEl;
        $this->bannerHotelCache[$hotel->id] = true;

        return true;
    }

    /**
     * @param PresetDto $preset
     * @return bool
     */
    public function addPresetToBannersIfNotExists(PresetDto $preset): bool
    {
        if (isset($this->bannerPresetCache[$preset->id])) {
            return false;
        }

        $catalogEl = new CatalogElement(CatalogElement::TYPE_PRESET, $preset);

        $this->banners[] = $catalogEl;
        $this->bannerPresetCache[$preset->id] = true;

        return true;
    }

    /**
     * @return CatalogElement[]
     */
    public function getBanners(): array
    {
        return $this->banners;
    }

    /**
     * @return CatalogElement[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function getItemsCount(): int
    {
        return \count($this->items);
    }

}
