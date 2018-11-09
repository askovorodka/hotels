<?php

use AppBundle\Entity\Hotel;
use AppBundle\Entity\Room;
use Codeception\Example;
use Faker\Factory;

class MultiplePhotosUploadCest
{
    /**
     * @var \ApiTester
     */
    protected $tester;

    protected function _before(ApiTester $I)
    {
    }

    protected function _after(ApiTester $I)
    {

    }

    /**
     * @example ["hotels", "hotel-photos"]
     * @example ["rooms", "room-photos"]
     *
     * @param ApiTester $I
     * @param Example $example
     * @throws \Codeception\Exception\ModuleException
     */
    public function tryToUpload(ApiTester $I, Example $example)
    {
        $faker = Factory::create();

        $resourceEntityMap = [
            'hotels' => Hotel::class,
            'rooms' => Room::class,
        ];

        $I->loginAsTester();

        list($resourceName, $subResourceName) = $example;

        $filesNumber = $faker->numberBetween(2, 5);

        /** @var Hotel|Room $entity */
        $entity = $I->getRandomEntity($resourceEntityMap[$resourceName]);
        $route = "/api/v3/{$resourceName}/{$entity->getId()}/{$subResourceName}/upload";

        // Генерация массивов параметров и файлов
        $parameters = [];
        $files = [];
        for ($i = 0; $i < $filesNumber; ++$i) {
            $parameters['alt'][] = $faker->text(5);
            $parameters['title'][] = $faker->text(20);
            $parameters['description'][] = $faker->text(20);
            $parameters['listOrder'][] = $faker->randomNumber();
            $parameters['width'][] = $faker->numberBetween(10, 200);
            $parameters['height'][] = $faker->numberBetween(10, 200);
            $parameters['areaWidth'][] = $faker->numberBetween(10, 200);
            $parameters['areaHeight'][] = $faker->numberBetween(10, 200);
            $parameters['top'][] = $faker->numberBetween(10, 200);
            $parameters['left'][] = $faker->numberBetween(10, 200);

            $files[] = $I->copyFileAndGetNewPath(codecept_data_dir('sign-check-icon.png'));
        }

        $I->haveHttpHeader('Content-Type', 'multipart/form-data');
        $I->sendPOST($route, $parameters, ['file' => $files]);
        $I->seeResponseCodeIs(201);
    }
}