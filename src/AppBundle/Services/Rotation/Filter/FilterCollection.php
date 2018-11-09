<?php

namespace AppBundle\Services\Rotation\Filter;

use AppBundle\Services\Rotation\Filter\ValueObject\Filter;

/**
 * Class FilterCollection
 *
 * @package AppBundle\Services\Rotation\Filter
 */
class FilterCollection implements \Iterator
{
    /**
     * @var Filter[]
     */
    private $filters = [];

    /**
     * @param Filter $filterDto
     * @return FilterCollection
     */
    public function add(Filter $filterDto): FilterCollection
    {
        $this->filters[$filterDto->field] = $filterDto;
        return $this;
    }

    /**
     * @inheritdoc
     * @return Filter
     */
    public function current(): Filter
    {
        return current($this->filters);
    }

    /**
     * @inheritdoc
     */
    public function next(): void
    {
        next($this->filters);
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        return key($this->filters);
    }

    /**
     * @inheritdoc
     */
    public function valid(): bool
    {
        return key($this->filters) !== null;
    }

    /**
     * @inheritdoc
     */
    public function rewind(): void
    {
        reset($this->filters);
    }
}
