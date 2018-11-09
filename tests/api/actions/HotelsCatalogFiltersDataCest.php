<?php

class HotelsCatalogFiltersDataCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    /**
     * @param ApiTester $I
     * @throws \Codeception\Exception\ModuleException
     */
    public function tryGetFiltersData(ApiTester $I)
    {
        $I->loginAsTester();

        $I->haveHttpHeader('Accept', 'application/json, text/plain, */*');
        $I->sendGET('/api/v3/hotels-catalog/filters-data');

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('areas[]');
        $I->seeResponseJsonMatchesJsonPath('hotelCategories[]');
        $I->seeResponseJsonMatchesJsonPath('hotelAmenities[]');
        $I->seeResponseJsonMatchesJsonPath('roomAmenities[]');
        $I->seeResponseJsonMatchesJsonPath('counters.forHotelAmenities[]');
        $I->seeResponseJsonMatchesJsonPath('counters.forRoomAmenities[]');
        $I->seeResponseJsonMatchesJsonPath('counters.forHotelCategories[]');
        $I->seeResponseJsonMatchesJsonPath('counters.forAdministrativeAreas[]');
        $I->seeResponseJsonMatchesJsonPath('counters.totalItems');
    }
}
