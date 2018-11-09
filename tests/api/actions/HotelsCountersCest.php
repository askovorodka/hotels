<?php

class HotelsCountersCest
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
    public function tryGetCounters(ApiTester $I)
    {
        $I->loginAsTester();

        $I->haveHttpHeader('Accept', 'application/json, text/plain, */*');
        $I->sendGET('/api/v3/hotels-catalog/hotels-counters');

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('forHotelAmenities[]');
        $I->seeResponseJsonMatchesJsonPath('forRoomAmenities[]');
    }
}
