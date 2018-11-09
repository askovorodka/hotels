<?php

class AuthCheckCest
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
    public function tryWithLogin(ApiTester $I)
    {
        $I->loginAsTester();
        $I->haveHttpHeader('Accept', 'application/json, text/plain, */*');
        $I->sendGET('/auth-check');
        $I->seeResponseCodeIs(200);
    }

    public function tryWithoutLogin(ApiTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json, text/plain, */*');
        $I->sendGET('/auth-check');
        $I->seeResponseCodeIs(401);
    }
}