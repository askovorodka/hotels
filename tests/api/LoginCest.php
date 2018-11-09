<?php

class LoginCest
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
    public function login(ApiTester $I)
    {
        $username = 'test@user';
        $email = 'test@example.ru';
        $password = 'p@ssword';

        $I->generateUser($username, $email, $password);

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/login_check', [
            'username' => $username,
            'password' => $password,
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $response = json_decode($I->grabResponse(), true);
        $I->assertArrayHasKey('token', $response);
        $I->assertNotEmpty($response['token']);
    }
}
