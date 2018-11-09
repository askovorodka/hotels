<?php

namespace AppBundle\Services\Rotation\Filter\ValueObject;

/**
 * Class FilterDto
 *
 * @package AppBundle\Services\Rotation\Filter\Dto
 */
class Filter
{
    /**
     * @var string
     */
    public $field;

    /**
     * @var array
     */
    public $values;

    /**
     * FilterDto constructor.
     *
     * @param string $field
     * @param array  $values
     */
    public function __construct(string $field, array $values)
    {
        $this->field = $field;
        $this->values = $values;
    }

}
