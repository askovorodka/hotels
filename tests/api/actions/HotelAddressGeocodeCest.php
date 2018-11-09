<?php

class HotelAddressGeocodeCest
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
    public function tryGet(ApiTester $I)
    {
        $I->loginAsTester();

        $I->haveHttpHeader('Accept', 'application/json, text/plain, */*');
        $I->sendGET('/api/v3/hotels/address/geocode');

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('country');
        $I->seeResponseJsonMatchesJsonPath('administrativeArea');
        $I->seeResponseJsonMatchesJsonPath('subAdministrativeArea');
        $I->seeResponseJsonMatchesJsonPath('locality');
        $I->seeResponseJsonMatchesJsonPath('thoroughfare');
        $I->seeResponseJsonMatchesJsonPath('premise');
        $I->seeResponseJsonMatchesJsonPath('postalCode');
    }
}
