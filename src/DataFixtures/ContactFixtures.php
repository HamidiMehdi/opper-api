<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ContactFixtures extends Fixture
{
    const NAMES = [
        'roger',
        'vincent',
        'francois',
        'dylan',
        'caliste',
        'saken',
        'lucie',
        'marge',
        'pedro',
        'leila',
        'peter',
        'marie'
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::NAMES as $name) {
            $contact = (new Contact())
                ->setFirstname(ucfirst($name))
                ->setName(ucfirst(strrev($name)));

            $manager->persist($contact);
        }

        $manager->flush();
    }
}