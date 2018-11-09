<?php

namespace AppBundle\Services\Rotation\Dto;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class RotationDtoAssembler
 *
 * @package AppBundle\Services\Rotation\Dto
 */
class RotationDtoAssembler
{
    public const PRESET_CITY_ID_INPUT_PARAM = 'cityId';
    public const PRESET_REGION_ID_INPUT_PARAM = 'regionId';
    public const PRESET_SYSNAME_INPUT_PARAM = 'sysname';
    public const PRESET_CATEGORY_SYSNAME_INPUT_PARAM = 'categorySysname';
    public const ORDERS_INPUT_PARAM = 'orders';
    public const LIMIT_INPUT_PARAM = 'limit';
    public const OFFSET_INPUT_PARAM = 'offset';
    public const PAGE_INPUT_PARAM = 'page';
    public const ITEMS_PER_PAGE_INPUT_PARAM = 'itemsPerPage';

    /** @var Request */
    private $request;

    /**
     * RotationDtoAssembler constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return RotationDto
     * @throws \InvalidArgumentException
     */
    public function assemble(): RotationDto
    {
        $rotationDto = new RotationDto();

        // cityId
        $presetCityId = $this->request->get(self::PRESET_CITY_ID_INPUT_PARAM);
        if ($presetCityId !== null) {
            $rotationDto->presetCityId = (int)$presetCityId;
        }

        // regionId
        $regionId = $this->request->get(self::PRESET_REGION_ID_INPUT_PARAM);
        if ($regionId !== null) {
            $rotationDto->presetRegionId = (int)$regionId;
        }

        // sysname
        $presetSysname = $this->request->get(self::PRESET_SYSNAME_INPUT_PARAM);
        if ($presetSysname !== null) {
            $rotationDto->presetSysname = $presetSysname;
        }

        // categorySysname
        $presetCategorySysname = $this->request->get(self::PRESET_CATEGORY_SYSNAME_INPUT_PARAM);
        if ($presetCategorySysname !== null) {
            $rotationDto->presetCategorySysname = $presetCategorySysname;
        }

        // order
        $orders = $this->request->get(self::ORDERS_INPUT_PARAM);
        if ($orders !== null) {
            $rotationDto->orders = $orders;
        }

        // limit
        $limit = $this->request->get(self::LIMIT_INPUT_PARAM);
        if ($limit !== null) {
            $rotationDto->limit = (int)$limit;
        }

        // offset
        $offset = $this->request->get(self::OFFSET_INPUT_PARAM);
        if ($offset !== null) {
            $rotationDto->offset = (int)$offset;
        }

        // page
        $page = $this->request->get(self::PAGE_INPUT_PARAM);
        if ($page !== null) {
            $rotationDto->page = (int)$page;
        }

        // itemsPerPage
        $itemsPerPage = $this->request->get(self::ITEMS_PER_PAGE_INPUT_PARAM);
        if ($itemsPerPage !== null) {
            $rotationDto->itemsPerPage = (int)$itemsPerPage;
        }

        if (!$presetSysname) {
            if (!$presetCategorySysname || !($presetCityId || $regionId)) {

                $errorMsg = 'Specify ' . self::PRESET_SYSNAME_INPUT_PARAM .
                    ' or (' . self::PRESET_CATEGORY_SYSNAME_INPUT_PARAM .
                    ' and (' . self::PRESET_CITY_ID_INPUT_PARAM .
                    ' or ' . self::PRESET_REGION_ID_INPUT_PARAM . '))';

                throw new \InvalidArgumentException($errorMsg);
            }
        }

        return $rotationDto;
    }
}
