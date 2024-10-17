<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    const NAMES = [
        'FORXIGA',
        'SPASFON',
        'DOLIPRANE',
        'AUGMENTIN',
        'SERESTA',
        'LYRICA',
        'KARDEGIC',
        'ELIQUIS',
        'AMOXICILLINE',
        'OZEMPIC',
        'FUCIDINE',
        'TRAMADOL'
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::NAMES as $name) {
            $product = (new Product())
                ->setLabel($name);

            $manager->persist($product);
        }

        $manager->flush();
    }
}