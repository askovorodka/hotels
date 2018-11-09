<?php

namespace AppBundle\Services\Rotation\Dto;

/**
 * Class PresetDto
 *
 * @package AppBundle\Services\Rotation\Dto
 */
class PresetDto
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
    public $description;

    /**
     * @var null|string
     */
    public $photo;

    /**
     * PresetDto constructor.
     *
     * @param int         $id
     * @param string      $sysname
     * @param string      $title
     * @param string      $description
     * @param null|string $photo
     */
    public function __construct(int $id, ?string $sysname, string $title, string $description, ?string $photo)
    {
        $this->id = $id;
        $this->sysname = $sysname;
        $this->title = $title;
        $this->description = $description;
        $this->photo = $photo;
    }

}
