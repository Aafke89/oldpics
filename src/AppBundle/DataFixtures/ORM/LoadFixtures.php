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

            'http://photographyheat.com/wp-content/uploads/2013/01/Snake-Photography-.jpg',
            'http://photographyheat.com/wp-content/uploads/2013/01/Snake-Photography-1.jpg',
            'http://gq-images.condecdn.net/image/qG931qY850k/crop/1020',
            'http://piqtura.com/wp-content/uploads/2015/08/1447691764Modern-Art.jpg',
            'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f3/Gustav_Klimt_016.jpg/266px-Gustav_Klimt_016.jpg',
            'http://www.vanderkrogt.net/standbeelden/extra/gl/GL02ci-10086.jpg'
        ];

        $key = array_rand($files);

        return $files[$key];
    }
}