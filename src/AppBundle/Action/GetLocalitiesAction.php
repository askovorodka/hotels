<?php

namespace AppBundle\Action;

use AppBundle\Entity\Hotel;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class GetLocalitiesAction
 *
 * @package AppBundle\Action
 */
class GetLocalitiesAction
{
    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    /**
     * GetLocalitiesAction constructor.
     *
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @Route(
     *     name="localities",
     *     path="/api/v3/localities",
     * )
     *
     * @Method({"GET"})
     *
     * @return JsonResponse
     */
    public function __invoke()
    {
        $hotelRepository = $this->managerRegistry->getRepository(Hotel::class);
        $qb = $hotelRepository->getLocalitiesQuery();
        $queryResult = $qb->getQuery()->getArrayResult();

        return new JsonResponse(array_column($queryResult, 'locality'));
    }

}
