<?php

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = null)
 *
 * @SuppressWarnings(PHPMD)
 */
class ApiTester extends \Codeception\Actor
{
    use _generated\ApiTesterActions;

    const TESTER_DEFAULT_ROLES = [
        'ROLE_ADMIN',
        'ROLE_MANAGER'
    ];

    /**
     * @var bool
     */
    private $isTesterCreated = false;

    public function login(string $username, string $password)
    {
        $this->haveHttpHeader('Content-Type', 'application/json');
        $this->sendPOST('/login_check', [
            'username' => $username,
            'password' => $password,
        ]);

        $response = json_decode($this->grabResponse());

        $this->amBearerAuthenticated($response->token);
    }

    /**
     * @param array $roles
     * @throws \Codeception\Exception\ModuleException
     */
    public function loginAsTester($roles = self::TESTER_DEFAULT_ROLES)
    {
        $username = 'test@user';
        $password = 'p@ssword';

        if (!$this->isTesterCreated) {
            $this->generateUser($username, 'test@example.ru', $password, $roles);

            $this->isTesterCreated = true;
        }

        $this->login($username, $password);
    }

    public function checkGetEntity(string $route)
    {
        $this->haveHttpHeader('Accept', 'application/json, text/plain, */*');
        $this->sendGET($route);

        $this->seeResponseCodeIs(200);
        $this->seeResponseIsJson();

        $this->seeResponseMatchesJsonType([
            'itemsPerPage' => 'integer',
            'totalItems' => 'integer',
        ]);

        $response = json_decode($this->grabResponse(), true);

        if ($response['totalItems']) {
            $this->seeResponseJsonMatchesJsonPath('_embedded.item[*]');
        }
    }
}
