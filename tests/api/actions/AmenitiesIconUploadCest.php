<?php

use AppBundle\Entity\Amenity;

class AmenitiesIconUploadCest
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
    public function tryToUpload(ApiTester $I)
    {
        $I->loginAsTester();
        $amenity = $I->getRandomEntity(Amenity::class);

        // получаем файл для отправки
        $filePath = $I->copyFileAndGetNewPath(codecept_data_dir('sign-check-icon.png'));

        // загружаем файл
        $route = "/api/v3/amenities/{$amenity->getId()}/icon/upload";
        $I->haveHttpHeader('Content-Type', 'multipart/form-data');

        // если передать вторым параметром null, файл не отправляется
        $I->sendPOST($route, [], [
            'file' => [$filePath],
        ]);

        // проверяем результат
        $I->seeResponseCodeIs(201);
    }
}