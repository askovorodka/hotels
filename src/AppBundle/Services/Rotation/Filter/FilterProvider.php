<?php

namespace AppBundle\Services\Rotation\Filter;

use AppBundle\Entity\Preset;
use AppBundle\Services\Rotation\Filter\ValueObject\Filter;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

/**
 * Class FilterProvider
 *
 * @package AppBundle\Services\Rotation\Filter
 */
class FilterProvider implements FilterProviderInterface
{
    /**
     * @var CamelCaseToSnakeCaseNameConverter
     */
    private $nameConverter;

    /**
     * FilterProvider constructor.
     *
     * @param CamelCaseToSnakeCaseNameConverter $nameConverter
     */
    public function __construct(CamelCaseToSnakeCaseNameConverter $nameConverter)
    {
        $this->nameConverter = $nameConverter;
    }
    
    /**
     * @inheritdoc
     */
    public function getFilters(Preset $preset): FilterCollection
    {
        $filterCollection = new FilterCollection();

        $presetParams = $preset->getParams();

        $rawFilters = $presetParams['filters'] ?? [];
        foreach ($rawFilters as $field => $values) {
            if (!$values) {
                continue;
            }

            // Преобразуем имя поля из camelCase в snake_case
            $field = $this->nameConverter->normalize($field);

            $filter = new Filter($field, $values);
            $filterCollection->add($filter);
        }

        return $filterCollection;
    }
}
