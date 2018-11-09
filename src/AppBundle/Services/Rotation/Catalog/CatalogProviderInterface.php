<?php

namespace AppBundle\Services\Rotation\Catalog;

use AppBundle\Services\Rotation\Filter\FilterCollection;
use AppBundle\Services\Rotation\Order\OrderCollection;
use AppBundle\Services\Rotation\Pin\PinCollection;

/**
 * Interface RotationBuilderInterface
 *
 * @package AppBundle\Services\Rotation
 */
interface CatalogProviderInterface
{
    public const SORTABLE_FIELDS = [
        'hotel' => [
            'administrative_area',
            'locality',
            'purchases_count',
            'start_at',
        ],
        'deal_offer' => [
            'start_at',
        ],
    ];

    public const FILTERABLE_FIELDS = [
        'administrative_area',
        'locality',
    ];

    /**
     * @param FilterCollection $filterCollection
     * @param OrderCollection  $orderCollection
     * @param PinCollection    $pinCollection
     * @param int|null         $limit
     * @param int[]|null       $hotelsIds
     * @return Catalog
     */
    public function getCatalog(
        FilterCollection $filterCollection,
        OrderCollection $orderCollection,
        PinCollection $pinCollection,
        int $limit = null,
        array $hotelsIds = null
    ): Catalog;

}
