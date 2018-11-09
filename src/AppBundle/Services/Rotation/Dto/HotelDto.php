<?php

namespace AppBundle\Services\Rotation\Dto;

/**
 * Class HotelDto
 *
 * @package AppBundle\Services\Rotation\Dto
 */
class HotelDto
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $sysname;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $administrativeArea;

    /**
     * @var string
     */
    public $locality;

    /**
     * @var float|null
     */
    public $rating;

    /**
     * @var int
     */
    public $minPrice;

    /**
     * @var int
     */
    public $minOriginalPrice;

    /**
     * @var int
     */
    public $discount;

    /**
     * @var int
     */
    public $purchasesCount;

    /**
     * @var null|string
     */
    public $photo;

    /**
     * @var null|string
     */
    public $labelText;

    /**
     * @var null|string
     */
    public $labelColor;

    /** @var null|string */
    public $labelBackgroundColor;

    /**
     * @var HotelCategoryDto
     */
    public $hotelCategory;

    /**
     * @var DealOfferDto
     */
    public $activeDealOffer;

    /**
     * HotelDto constructor.
     *
     * @param int              $id
     * @param string           $sysname
     * @param string           $title
     * @param string           $administrativeArea
     * @param string           $locality
     * @param float|null       $rating
     * @param int              $minPrice
     * @param int              $minOriginalPrice
     * @param int              $discount
     * @param int|null         $purchasesCount
     * @param null|string      $photo
     * @param null|string      $labelText
     * @param null|string      $labelColor
     * @param null|string      $labelBackgroundColor
     * @param HotelCategoryDto $hotelCategory
     * @param DealOfferDto     $activeDealOffer
     */
    public function __construct(
        int $id,
        string $sysname,
        string $title,
        string $administrativeArea,
        string $locality,
        ?float $rating,
        int $minPrice,
        int $minOriginalPrice,
        int $discount,
        ?int $purchasesCount,
        ?string $photo,
        ?string $labelText,
        ?string $labelColor,
        ?string $labelBackgroundColor,
        HotelCategoryDto $hotelCategory,
        DealOfferDto $activeDealOffer
    ) {
        $this->id = $id;
        $this->sysname = $sysname;
        $this->title = $title;
        $this->administrativeArea = $administrativeArea;
        $this->locality = $locality;
        $this->rating = $rating;
        $this->minPrice = $minPrice;
        $this->minOriginalPrice = $minOriginalPrice;
        $this->discount = $discount;
        $this->purchasesCount = $purchasesCount;
        $this->photo = $photo;
        $this->labelText = $labelText;
        $this->labelColor = $labelColor;
        $this->labelBackgroundColor = $labelBackgroundColor;
        $this->hotelCategory = $hotelCategory;
        $this->activeDealOffer = $activeDealOffer;
    }

}
