<?php

namespace AppBundle\Services\Rotation;

use AppBundle\Services\Rotation\Catalog\Catalog;
use AppBundle\Services\Rotation\Catalog\CatalogProviderInterface;
use AppBundle\Services\Rotation\Dto\RotationDto;
use AppBundle\Services\Rotation\Filter\FilterProviderInterface;
use AppBundle\Services\Rotation\Order\OrderProviderInterface;
use AppBundle\Services\Rotation\Order\ValueObject\Order;
use AppBundle\Services\Rotation\Pin\PinProviderInterface;
use AppBundle\Services\Rotation\Preset\PresetProviderInterface;

/**
 * Class RotationService
 *
 * @package AppBundle\Services\Rotation
 */
class RotationService implements RotationServiceInterface
{
    /** @var PresetProviderInterface */
    private $presetProvider;

    /** @var PinProviderInterface */
    private $pinProvider;

    /** @var FilterProviderInterface */
    private $filterProvider;

    /** @var OrderProviderInterface */
    private $orderProvider;

    /** @var CatalogProviderInterface */
    private $catalogProvider;

    /**
     * RotationService constructor.
     *
     * @param PresetProviderInterface  $presetProvider
     * @param PinProviderInterface     $pinProvider
     * @param FilterProviderInterface  $filterProvider
     * @param OrderProviderInterface   $orderProvider
     * @param CatalogProviderInterface $catalogProvider
     */
    public function __construct(
        PresetProviderInterface $presetProvider,
        PinProviderInterface $pinProvider,
        FilterProviderInterface $filterProvider,
        OrderProviderInterface $orderProvider,
        CatalogProviderInterface $catalogProvider
    ) {
        $this->presetProvider = $presetProvider;
        $this->pinProvider = $pinProvider;
        $this->filterProvider = $filterProvider;
        $this->orderProvider = $orderProvider;
        $this->catalogProvider = $catalogProvider;
    }

    /**
     * @inheritdoc
     */
    public function getCatalog(RotationDto $rotationDto): Catalog
    {
        if ($rotationDto->presetSysname) {
            $presetEntity = $this->presetProvider->getPresetBySysname($rotationDto->presetSysname);
        } else {
            $presetEntity = $this->presetProvider->getPreset(
                $rotationDto->presetCategorySysname,
                $rotationDto->presetCityId,
                $rotationDto->presetRegionId
            );
        }

        $pinCollection = $this->pinProvider->getPins(
            $rotationDto->presetCityId,
            $rotationDto->presetRegionId,
            $presetEntity->getId()
        );

        $filterCollection = $this->filterProvider->getFilters($presetEntity);

        $orderCollection = $this->orderProvider->getOrders($presetEntity, $rotationDto->orders);

        $presetParams = $presetEntity->getParams();

        $filteredHotels = $presetParams['filteredHotels'] ?? [];
        $hotelsIds = array_column($filteredHotels, 'id');

        $limit = $presetParams['limit'] ?? null;

        return $this->catalogProvider->getCatalog(
            $filterCollection,
            $orderCollection,
            $pinCollection,
            $limit,
            $hotelsIds
        );
    }

}
