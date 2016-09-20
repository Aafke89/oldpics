<?php

/**
 * Created by PhpStorm.
 * User: Aafke
 * Date: 19/09/16
 * Time: 10:56
 */

namespace AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;


class LoadFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $objects = Fixtures::load(
            __DIR__.'/fixtures.yml',
            $manager,
            [
                'providers' => [$this]
            ]
        );
    }

    public function files()
    {
        $files = [
            '2ee9b10118f3ac60357897db02e5b185.jpeg',
            '3e9a32f0eea50aa28ce520cecc308271.jpeg',
            '7fc80c397d72ec85e5a512f29f87bb4f.jpeg',
            '4981da5b0eb913b3a86036c75e930d8d.jpeg',
            'c41afaa4fe3fe33a9794547c3ac3bed5.jpeg'

        ];

        $key = array_rand($files);

        return $files[$key];
    }
}