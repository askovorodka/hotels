<?php

class ActiveDealOffersCest
{
    public function tryToTest(ApiTester $I)
    {
        $I->haveHttpHeader('Accept','application/json');
        $I->sendGET('/api/v3/active-deal-offers/');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->canSeeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id'        => 'integer',
            'titleLink' => 'string',
            'sysname'   => 'string',
        ]);
    }
}
