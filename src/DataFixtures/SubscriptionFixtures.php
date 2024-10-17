<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Product;
use App\Entity\Subscription;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SubscriptionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $contacts = $manager->getRepository(Contact::class)->findBy(criteria: [], limit: 8);
        $products = $manager->getRepository(Product::class)->findBy(criteria: [], limit: 8);

        foreach ($contacts as $key => $contact) {
            $subscription = (new Subscription())
                ->setContact($contact)
                ->setProduct($products[$key])
                ->setBeginDate(new \DateTime())
                ->setEndDate(new \DateTime('now +' . + $key === 0 ? 1 : $key . ' days'));

            $manager->persist($subscription);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
          ContactFixtures::class,
          ProductFixtures::class
        ];
    }
}
