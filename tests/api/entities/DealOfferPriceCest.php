<?php

class DealOfferPriceCest
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
    public function tryGetDealOfferPricesWithoutRooms(ApiTester $I)
    {
        $I->loginAsTester();
        $I->checkGetEntity('/api/v3/deal-offer-prices-without-rooms');
    }
}