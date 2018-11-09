<?php

class HotelCest
{
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    /**
     * @param ApiTester $I
     * @throws \Codeception\Exception\ModuleException
     */
    public function tryGetHotels(ApiTester $I)
    {
        $I->loginAsTester();
        $I->checkGetEntity('/api/v3/hotels');
    }

    /**
     * @param ApiTester $I
     * @throws \Codeception\Exception\ModuleException
     */
    public function tryGetHotelsWithoutRooms(ApiTester $I)
    {
        $I->loginAsTester();
        $I->checkGetEntity('/api/v3/hotels-without-rooms');
    }

    /**
     * @param ApiTester $I
     * @throws \Codeception\Exception\ModuleException
     */
    public function tryGetHotelsWithoutAmenities(ApiTester $I)
    {
        $I->loginAsTester();
        $I->checkGetEntity('/api/v3/hotels-without-amenities');
    }
}