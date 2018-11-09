<?php

use AppBundle\Entity\DealOffer;
use AppBundle\Entity\Hotel;

class ConnectHotelCest
{
    protected function _before(ApiTester $I)
    {
    }

    protected function _after(ApiTester $I)
    {
    }

    /**
     * @param ApiTester $I
     * @throws \Codeception\Exception\ModuleException
     */
    public function tryToConnectHotel(ApiTester $I)
    {
        $I->loginAsTester();

        $dealOffer = $I->getRandomEntity(DealOffer::class);
        $hotel = $I->getRandomEntity(Hotel::class);

        // отправляем запрос на привязку
        $route = "/api/v3/deal-offers/{$dealOffer->getId()}/connect-hotel/{$hotel->getId()}";
        $I->haveHttpHeader('Accept', 'application/json, text/plain, */*');
        $I->sendPOST($route);

        // проверяем результат
        $I->seeResponseCodeIs(201);
        /** @var DealOffer $updatedDealOffer */
        $updatedDealOffer = $I->grabEntityFromRepository(DealOffer::class, ['id' => $dealOffer->getId()]);
        $I->assertEquals($updatedDealOffer->getHotel()->getId(), $hotel->getId());

        // проверяем, что старые акции переведены в неактивное состояние
        /** @var DealOffer[] $oldDealOffers */
        $oldDealOffers = $I->grabEntitiesFromRepository(DealOffer::class, ['hotel' => $hotel]);
        foreach ($oldDealOffers as $oldDealOffer) {
            if ($oldDealOffer->getId() === $updatedDealOffer->getId()) {
                continue;
            }

            $I->assertFalse($oldDealOffer->getIsActive(), 'Старая акция осталась в активном состоянии');
        }
    }
}