<?php

namespace AppBundle\Services\Rotation\Dto;

/**
 * Class RotationDto
 *
 * @package AppBundle\Services\Rotation\Dto
 */
final class RotationDto
{
    /** @var null|int */
    public $presetCityId;

    /** @var null|int */
    public $presetRegionId;

    /** @var null|string */
    public $presetSysname;

    /** @var null|string */
    public $presetCategorySysname;

    /** @var array|null */
    public $orders;

    /** @var int|null */
    public $limit;

    /** @var int|null */
    public $offset;

    /** @var int|null */
    public $page;

    /** @var int|null */
    public $itemsPerPage;

}
