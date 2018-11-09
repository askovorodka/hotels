<?php

namespace AppBundle\Action;

use AppBundle\Entity\CityRegion;
use AppBundle\Entity\Hotel;
use AppBundle\Services\Rotation\Catalog\Catalog;
use AppBundle\Services\Rotation\Dto\RotationDtoAssembler;
use AppBundle\Services\Rotation\Preset\Exception\PresetNotFoundException;
use AppBundle\Services\Rotation\RotationServiceInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GetCatalogAction
 *
 * @package AppBundle\Action
 */
class GetCatalogAction
{

    /**
     * @var RotationServiceInterface
     */
    private $rotationService;

    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    /**
     * GetCatalogAction constructor.
     *
     * @param RotationServiceInterface $rotationService
     * @param ManagerRegistry          $managerRegistry
     */
    public function __construct(RotationServiceInterface $rotationService, ManagerRegistry $managerRegistry)
    {
        $this->rotationService = $rotationService;
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @Route(
     *     name="get_catalog",
     *     path="/api/v3/catalog",
     * )
     *
     * @Method({"GET"})
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        $rotationDtoAssembler = new RotationDtoAssembler($request);

        try {
            $rotationDto = $rotationDtoAssembler->assemble();
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['error' => $e->getMessage()], 422);
        }

        if ($rotationDto->presetRegionId === null && $rotationDto->presetCityId) {
            $cityRegionRepository = $this->managerRegistry->getRepository(CityRegion::class);
            $rotationDto->presetRegionId = $cityRegionRepository->getRegionIdByCityId($rotationDto->presetCityId);
        }

        try {
            $catalog = $this->rotationService->getCatalog($rotationDto);
        } catch (PresetNotFoundException $e) {
            $catalog = new Catalog();
        }

        // todo: вынести этот код
        // вычисление оффсета и лимита
        $offset = $rotationDto->offset;
        $limit = $rotationDto->limit;
        $page = $rotationDto->page;
        $itemsPerPage = $rotationDto->itemsPerPage;

        if ($page !== null) {
            $itemsPerPage = $itemsPerPage ?: 20;
            $offset = (($page - 1) * $itemsPerPage) ?: 0;
            $limit = $itemsPerPage;
        }

        $offset = $offset ?: 0;
        $limit = $limit ?: 20;

        $items = \array_slice($catalog->getItems(), $offset, $limit);

        $response = [
            'banners' => $catalog->getBanners(),
            'items' => $items,
            'countHotels' => $this->managerRegistry->getRepository(Hotel::class)->getCountActiveHotels(),
            'totalItems' => $catalog->getItemsCount(),
        ];

        if ($page !== null && $itemsPerPage) {
            $response['itemsPerPage'] = $itemsPerPage;
            $response['page'] = $page;
        } else {
            $response['offset'] = $offset;
            $response['limit'] = $limit;
        }

        return new JsonResponse($response);
    }
}
