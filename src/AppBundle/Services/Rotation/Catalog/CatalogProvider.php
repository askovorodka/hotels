<?php

namespace AppBundle\Services\Rotation\Catalog;

use AppBundle\Entity\PinCategory;
use AppBundle\Services\PhotoUrlService;
use AppBundle\Services\Rotation\Dto\DealOfferDto;
use AppBundle\Services\Rotation\Dto\HotelCategoryDto;
use AppBundle\Services\Rotation\Dto\HotelDto;
use AppBundle\Services\Rotation\Dto\PresetDto;
use AppBundle\Services\Rotation\Filter\FilterCollection;
use AppBundle\Services\Rotation\Order\OrderCollection;
use AppBundle\Services\Rotation\Pin\ValueObject\Pin;
use AppBundle\Services\Rotation\Pin\PinCollection;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Class RotationBuilder
 *
 * @package AppBundle\Services\Rotation
 */
class CatalogProvider implements CatalogProviderInterface
{
    /**
     * @var Connection
     */
    private $conn;

    /**
     * @var PhotoUrlService
     */
    private $photoUrlService;

    /**
     * RotationBuilder constructor.
     *
     * @param Connection      $conn
     * @param PhotoUrlService $photoUrlService
     */
    public function __construct(Connection $conn, PhotoUrlService $photoUrlService)
    {
        $this->conn = $conn;
        $this->photoUrlService = $photoUrlService;
    }

    /**
     * @inheritdoc
     */
    public function getCatalog(
        FilterCollection $filterCollection,
        OrderCollection $orderCollection,
        PinCollection $pinCollection,
        int $limit = null,
        array $hotelsIds = null
    ): Catalog {
        $catalog = new Catalog();

        // Загружаем запиненные отели и подборки
        $pinnedHotelsIndexedById = $this->getPinnedHotelsIndexedById($pinCollection);
        $pinnedPresetsIndexedById = $this->getPinnedPresetsIndexedById($pinCollection);

        //Формируем баннеры
        $bannerPinsSorted = $this->getBannerPinsSorted($pinCollection);

        foreach ($bannerPinsSorted as $pin) {
            if ($pinnedHotelId = $pin->pinnedHotelId) {
                $pinnedHotel = $pinnedHotelsIndexedById[$pin->pinnedHotelId] ?? null;

                if (!$pinnedHotel) {
                    continue;
                }

                $catalog->addHotelToBannersIfNotExists($pinnedHotel);
            } elseif ($pinnedPresetId = $pin->pinnedPresetId) {
                $pinnedPreset = $pinnedPresetsIndexedById[$pin->pinnedPresetId] ?? null;

                if (!$pinnedPreset) {
                    continue;
                }

                $catalog->addPresetToBannersIfNotExists($pinnedPreset);
            }
        }

        // Загружаем отели
        $hotelsQb = $this->getHotelsQuery($filterCollection, $orderCollection, $hotelsIds);
        $hotelsData = $hotelsQb->execute()->fetchAll();

        $hotels = [];
        foreach ($hotelsData as $hotelRawData) {
            $hotel = $this->buildHotelDto($hotelRawData);
            $hotels[] = $hotel;
        }

        // Формируем каталог
        $position = 0;
        $skippedHotels = [];

        //Формируем список отелей/подборок
        foreach ($hotels as $hotel) {
            if ($limit && $limit === $position) {
                break;
            }

            // Если на текущей позиции стоит пин, то вставляем его
            while ($pinnedEl = $pinCollection->getPinByPosition(PinCategory::CATEGORY_CATALOG, $position)) {
                if ($pinnedHotelId = $pinnedEl->pinnedHotelId) {
                    $pinnedHotel = $pinnedHotelsIndexedById[$pinnedHotelId] ?? null;

                    if ($pinnedHotel && $catalog->addHotelToCatalogIfNotExists($pinnedHotel)) {
                        ++$position;
                    }
                } elseif ($pinnedPresetId = $pinnedEl->pinnedPresetId) {
                    $pinnedPreset = $pinnedPresetsIndexedById[$pinnedPresetId] ?? null;

                    if ($pinnedPreset && $catalog->addPresetToCatalogIfNotExists($pinnedPreset)) {
                        ++$position;
                    }
                }
            }

            // Проверяем есть ли пин для отеля
            $hotelId = $hotel->id;
            if ($pinCollection->getPinByPinnedHotelId(PinCategory::CATEGORY_CATALOG, $hotelId)) {
                $skippedHotels[$hotelId] = $hotel;
                continue;
            }

            if ($limit && $limit === $position) {
                break;
            }

            if ($catalog->addHotelToCatalogIfNotExists($hotel)) {
                ++$position;
            }
        }

        foreach ($skippedHotels as $skippedHotel) {
            if ($limit && $limit === $position) {
                break;
            }

            $catalog->addHotelToCatalogIfNotExists($skippedHotel);
        }

        return $catalog;
    }

    /**
     * @param PinCollection $pinCollection
     * @return HotelDto[]
     */
    private function getPinnedHotelsIndexedById(PinCollection $pinCollection): array
    {
        $hotelsIds = [];

        foreach ($pinCollection as $pin) {
            if ($pinnedHotelId = $pin->pinnedHotelId) {
                $hotelsIds[] = $pinnedHotelId;
            }
        }

        if (!$hotelsIds) {
            return [];
        }

        $qb = $this->getHotelsBaseQuery();
        $qb->where('h.id in (:hotelsIds)')
            ->setParameter('hotelsIds', $hotelsIds, Connection::PARAM_INT_ARRAY);

        $hotelsIndexedById = [];

        $hotelsData = $qb->execute()->fetchAll();
        foreach ($hotelsData as $hotelDataRaw) {
            $hotel = $this->buildHotelDto($hotelDataRaw);
            $hotelsIndexedById[$hotel->id] = $hotel;
        }

        return $hotelsIndexedById;
    }

    /**
     * @param PinCollection $pinCollection
     * @return PresetDto[]
     */
    private function getPinnedPresetsIndexedById(PinCollection $pinCollection): array
    {
        $presetsIds = [];
        foreach ($pinCollection as $pin) {
            if ($presetId = $pin->pinnedPresetId) {
                $presetsIds[] = $presetId;
            }
        }

        if (!$presetsIds) {
            return [];
        }

        $qb = $this->conn->createQueryBuilder();

        $qb->select(
            'preset.id',
            'preset.sysname',
            'preset.title',
            'preset.description',
            'photo.width as photoWidth',
            'photo.height as photoHeight',
            'photo.photo'
        )->from('preset')
            ->leftJoin('preset', 'preset_photo', 'preset_photo', 'preset.id = preset_photo.preset_id')
            ->leftJoin('preset_photo', 'photo', 'photo', 'preset_photo.photo_id = photo.id')
            ->where('preset.id in (:presetsIds)')
            ->setParameter('presetsIds', $presetsIds, Connection::PARAM_INT_ARRAY);

        $presetsIndexedById = [];

        $presetsData = $qb->execute()->fetchAll();
        foreach ($presetsData as $presetRawData) {
            $preset = $this->buildPresetDto($presetRawData);
            $presetsIndexedById[$preset->id] = $preset;
        }

        return $presetsIndexedById;
    }

    /**
     * @param PinCollection $pinCollection
     * @return Pin[]
     */
    private function getBannerPinsSorted(PinCollection $pinCollection): array
    {
        $pins = [];

        foreach ($pinCollection as $pin) {
            if ($pin->category === PinCategory::CATEGORY_BANNER) {
                $pins[] = $pin;
            }
        }

        usort($pins, function (Pin $pinA, Pin $pinB) {
            if ($pinA->position === $pinB->position) {
                return 0;
            }
            return ($pinA->position < $pinB->position) ? -1 : 1;
        });

        return $pins;
    }

    /**
     * @return QueryBuilder
     */
    private function getHotelsBaseQuery(): QueryBuilder
    {
        $qb = $this->conn->createQueryBuilder();

        $qb->select('
             h.id                       as hotelId',
            'h.sysname                  as hotelSysname',
            'h.title                    as hotelTitle',
            'hc.id                      as hotelCategoryId',
            'hc.title                   as hotelCategoryTitle',
            'hp.area_width              as areaWidth',
            'hp.area_height             as areaHeight',
            'hp.offset_top              as offsetTop',
            'hp.offset_left             as offsetLeft',
            'p.photo                    as photo',
            'h.administrative_area      as hotelAdministrativeArea',
            'h.locality                 as hotelLocality',
            'h.rating                   as hotelRating',
            'h.purchases_count          as purchasesCount',
            'h.label_text               as labelText',
            'h.label_color              as labelColor',
            'h.label_background_color   as labelBackgroundColor',
            'hwmp.price                 as minPrice',
            'hwmp.original_price        as minOriginalPrice',
            'hwmp.discount              as discount',
            'do.id                      as dealOfferId',
            'do.title                   as dealOfferTitle',
            'do.title_link              as dealOfferTitleLink',
            'do.start_at                as dealOfferStartAt'
        )->from('hotel_with_min_price', 'hwmp')
            ->innerJoin('hwmp', 'hotel', 'h', 'hwmp.id = h.id')
            ->innerJoin('hwmp', 'deal_offer', 'do', 'hwmp.deal_offer_id = do.id')
            ->innerJoin('h', 'hotel_category', 'hc', 'h.hotel_category_id = hc.id')
            ->leftJoin(
                'h',
                'hotel_photos',
                'hp',
                'h.id = hp.hotel_id and hp.list_order = 0'
            )
            ->leftJoin('hp', 'photo', 'p', 'hp.photo_id = p.id');

        return $qb;
    }

    /**
     * @param $table
     * @return string
     */
    private function getAliasByTable($table): string
    {
        $map = [
            'hotel' => 'h',
            'deal_offer' => 'do',
        ];

        return $map[$table];
    }

    /**
     * @param FilterCollection $filterCollection
     * @param OrderCollection  $orderCollection
     * @param int[]            $hotelsIds
     * @return QueryBuilder
     */
    private function getHotelsQuery(
        FilterCollection $filterCollection,
        OrderCollection $orderCollection,
        array $hotelsIds = null
    ): QueryBuilder {
        $qb = $this->getHotelsBaseQuery();

        if ($simpleOrders = $orderCollection->getSimpleOrders()) {
            foreach ($simpleOrders as $simpleOrder) {
                $table = $simpleOrder->table;
                $field = $simpleOrder->field;

                if (
                    !isset(self::SORTABLE_FIELDS[$table]) ||
                    !\in_array($field, self::SORTABLE_FIELDS[$table], true)
                ) {
                    continue;
                }

                $alias = $this->getAliasByTable($table);

                $qb->addOrderBy("{$alias}.{$simpleOrder->field}", $simpleOrder->direction === 'desc' ? 'desc' : 'asc');
            }

        } else {
            foreach ($orderCollection->getValueOrdersGroupedByNum() as $num => $orders) {
                $conditions = [];

                $subNum = 0;
                foreach ($orders as $order) {
                    $table = $order->table;
                    $field = $order->field;
                    $alias = $this->getAliasByTable($table);

                    if (
                        !isset(self::SORTABLE_FIELDS[$table]) ||
                        !\in_array($field, self::SORTABLE_FIELDS[$table], true)
                    ) {
                        continue;
                    }

                    if ($order->value !== null) {
                        $parameterName = "{$field}_{$num}_{$subNum}";
                        $conditions[] = "{$alias}.{$field} = :$parameterName";

                        $qb->setParameter($parameterName, $order->value);

                        ++$subNum;
                    } else {
                        $qb->addOrderBy($field, $order->direction);
                    }
                }

                $conditionStr = implode(' or ', $conditions);

                $qb->addSelect("if ($conditionStr, 1, 0) as order_field_$num")
                    ->addOrderBy("order_field_$num", 'desc');
            }
        }

        $qb->addOrderBy('h.purchases_count', 'desc');

        if ($hotelsIds) {
            $qb->andWhere('h.id in (:hotelsIds)')
                ->setParameter('hotelsIds', $hotelsIds, Connection::PARAM_INT_ARRAY);

            return $qb;
        }

        foreach ($filterCollection as $filter) {
            $field = $filter->field;
            $values = $filter->values;

            if (!\in_array($field, self::FILTERABLE_FIELDS, true)) {
                continue;
            }

            $parameterName = "{$field}Values";
            $qb->orWhere("h.$field in (:$parameterName)")
                ->setParameter($parameterName, $values, Connection::PARAM_STR_ARRAY);
        }

        return $qb;
    }

    /**
     * @param array $rawData
     * @return HotelDto
     */
    private function buildHotelDto(array $rawData): HotelDto
    {
        $dealOfferStartAt = $rawData['dealOfferStartAt'];
        if ($dealOfferStartAt) {
            $dealOfferStartAt = new \DateTime($dealOfferStartAt);
        }

        $dealOffer = new DealOfferDto(
            $rawData['dealOfferId'],
            $rawData['dealOfferTitle'],
            $rawData['dealOfferTitleLink'],
            $dealOfferStartAt
        );

        $hotelCategory = new HotelCategoryDto(
            $rawData['hotelCategoryId'],
            $rawData['hotelCategoryTitle']
        );

        $photoUrl = null;

        $areaWidth = $rawData['areaWidth'];
        $areaHeight = $rawData['areaHeight'];
        $offsetTop = $rawData['offsetTop'];
        $offsetLeft = $rawData['offsetLeft'];
        $photo = $rawData['photo'];

        if (isset($areaWidth, $areaHeight, $offsetTop, $offsetLeft, $photo)) {
            $photoUrl = $this->photoUrlService->getPhotoUrlByMetadata(
                $rawData['areaWidth'],
                $rawData['areaHeight'],
                $rawData['offsetTop'],
                $rawData['offsetLeft'],
                $rawData['photo']
            );
        }

        return new HotelDto(
            $rawData['hotelId'],
            $rawData['hotelSysname'],
            $rawData['hotelTitle'],
            $rawData['hotelAdministrativeArea'],
            $rawData['hotelLocality'],
            round($rawData['hotelRating'], 2),
            $rawData['minPrice'],
            $rawData['minOriginalPrice'],
            $rawData['discount'],
            $rawData['purchasesCount'],
            $photoUrl,
            $rawData['labelText'],
            $rawData['labelColor'],
            $rawData['labelBackgroundColor'],
            $hotelCategory,
            $dealOffer
        );
    }

    /**
     * @param array $rawData
     * @return PresetDto
     */
    private function buildPresetDto(array $rawData): PresetDto
    {
        $width = $rawData['photoWidth'];
        $height = $rawData['photoHeight'];
        $photo = $rawData['photo'];

        $photoUrl = null;
        if (isset($width, $height, $photo)) {
            $photoUrl = $this->photoUrlService->getPhotoUrlByMetadata(
                $width,
                $height,
                0,
                0,
                $photo,
                $width,
                $height
            );
        }

        return new PresetDto(
            $rawData['id'],
            $rawData['sysname'],
            $rawData['title'],
            $rawData['description'],
            $photoUrl
        );
    }

}
