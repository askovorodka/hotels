<?php

namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use AppBundle\Entity\User;
use Codeception\Module\Doctrine2;
use Codeception\Module\Symfony;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

class Api extends \Codeception\Module
{
    /**
     * Генерирует пользователя
     *
     * @param string $username
     * @param string $email
     * @param string $password
     * @param string[] $roles
     * @return User
     * @throws \Codeception\Exception\ModuleException
     * @throws \Exception
     */
    public function generateUser(string $username, string $email, string $password, array $roles = []): User
    {
        /** @var Symfony $symfony */
        $symfony = $this->getModule('Symfony');
        $kernel = $symfony->kernel;

        $app = new Application($kernel);
        $app->setAutoExit(false);

        $input = new StringInput("fos:user:create $username $email $password");
        $output = new NullOutput();

        $app->run($input, $output);

        /** @var Doctrine2 $doctrine */
        $doctrine = $this->getModule('Doctrine2');
        $em = $doctrine->_getEntityManager();

        /** @var User $user */
        $user = $em->getRepository(User::class)->findOneBy(['username' => $username]);

        foreach ($roles as $role) {
            $user->addRole($role);
        }

        $em->persist($user);
        $em->flush();

        return $user;
    }

    /**
     * @param string $entityClass
     * @param bool $createIfNotExists
     * @return object|null
     * @throws \Codeception\Exception\ModuleException
     */
    public function getRandomEntity(string $entityClass, bool $createIfNotExists = false)
    {
        $faker = Factory::create();

        /** @var \Codeception\Module\Doctrine2 $doctrine */
        $doctrine = $this->getModule('Doctrine2');
        $em = $doctrine->_getEntityManager();

        $entities = $em->getRepository($entityClass)->findBy([], null, 50);

        if (!$entities) {
            return null;
        }

        $entityNumber = $faker->numberBetween(0, \count($entities) - 1);

        return $entities[$entityNumber];
    }

    /**
     * Копирует файл и возвращает полное имя нового файла
     *
     * @param string $originalFilePath
     * @return string
     */
    public function copyFileAndGetNewPath(string $originalFilePath): string
    {
        $copiedFilePath = $originalFilePath . '.copy.' . microtime();
        copy($originalFilePath, $copiedFilePath);

        return $copiedFilePath;
    }
}
