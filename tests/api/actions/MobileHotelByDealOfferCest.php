<?php

class MobileHotelByDealOfferCest
{
    private $dealOfferId;

    public function _before(ApiTester $I)
    {
        $I->sendGET('/api/v3/active-deal-offers/');
        $data = $I->grabDataFromResponseByJsonPath('$[0].id');
        if (!empty($data[0])) {
            $this->dealOfferId = $data[0];
        }

        $I->assertNotEmpty($this->dealOfferId);
    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
        $I->haveHttpHeader('Accept','application/json');
        $I->sendGET(sprintf('/api/v3/mobile/hotel-by-deal-offer/%d', $this->dealOfferId));

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->canSeeHttpHeader('cache-control','max-age=3600, public');
        $I->assertEmpty($I->grabHttpHeader('vary'));

        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'hotel' => [
                'id'        => 'integer',
                'sysname'   => 'string',
                'title'     => 'string',
                'isActive'  => 'boolean',
                'isProduction'  => 'boolean',
                'hotelAmenities' => 'array|null',
            ],
        ]);
    }
}
