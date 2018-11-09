<?php

namespace AppBundle\Services\Rotation;

use AppBundle\Services\Rotation\Catalog\Catalog;
use AppBundle\Services\Rotation\Dto\RotationDto;
use AppBundle\Services\Rotation\Preset\Exception\PresetNotFoundException;

/**
 * Interface RotationServiceInterface
 *
 * @package AppBundle\Services\Rotation
 */
interface RotationServiceInterface
{

    /**
     * @param RotationDto $rotationDto
     * @return Catalog
     * @throws PresetNotFoundException
     */
    public function getCatalog(RotationDto $rotationDto): Catalog;
}
