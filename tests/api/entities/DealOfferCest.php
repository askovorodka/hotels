<?php

class DealOfferCest
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
    public function tryGetDealOffers(ApiTester $I)
    {
        $I->loginAsTester();
        $I->checkGetEntity('/api/v3/deal-offers');
    }

    /**
     * @param ApiTester $I
     * @throws \Codeception\Exception\ModuleException
     */
    public function tryGetDealOffersWithoutHotels(ApiTester $I)
    {
        $I->loginAsTester();
        $I->checkGetEntity('/api/v3/deal-offers-without-hotel');
    }
}