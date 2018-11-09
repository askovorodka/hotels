<?php

namespace AppBundle\Services\Rotation\Dto;

/**
 * Class HotelCategoryDto
 *
 * @package AppBundle\Services\Rotation\Dto
 */
class HotelCategoryDto
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * HotelCategoryDto constructor.
     *
     * @param int    $id
     * @param string $title
     */
    public function __construct(int $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
    }

}
