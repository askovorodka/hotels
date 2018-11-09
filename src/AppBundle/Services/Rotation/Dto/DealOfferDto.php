<?php

namespace AppBundle\Services\Rotation\Dto;

/**
 * Class DealOfferDto
 *
 * @package AppBundle\Services\Rotation\Dto
 */
class DealOfferDto
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
     * @var string
     */
    public $titleLink;

    /**
     * @var \DateTimeInterface|null
     */
    public $startAt;

    /**
     * DealOfferDto constructor.
     *
     * @param int                     $id
     * @param string                  $title
     * @param string                  $titleLink
     * @param \DateTimeInterface|null $startAt
     */
    public function __construct(int $id, string $title, string $titleLink, ?\DateTimeInterface $startAt)
    {
        $this->id = $id;
        $this->title = $title;
        $this->titleLink = $titleLink;
        $this->startAt = $startAt;
    }
}
