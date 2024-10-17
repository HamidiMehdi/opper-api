<?php

namespace App\Service;

use App\Dto\CreateSubscriptionDto;
use App\Dto\EditSubscriptionDto;
use App\Entity\Contact;
use App\Entity\Product;
use App\Entity\Subscription;
use App\Repository\SubscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SubscriptionService
{
    private SubscriptionRepository $repository;
    private EntityManagerInterface $manager;

    public function __construct(SubscriptionRepository $repository, EntityManagerInterface $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    public function getAllSubscriptionsByContact($id): array
    {
        $contact = $this->getEntity($id, Contact::class);
        return $this->repository->findBy(['contact' => $contact]);
    }

    public function deleteSubscription($id): void
    {
        $subscription = $this->getEntity($id, Subscription::class);
        $this->manager->remove($subscription);
        $this->manager->flush();
    }

    public function editSubscription($id, EditSubscriptionDto $editSubscriptionDto): Subscription
    {
        /** @var Subscription $subscription */
        $subscription = $this->getEntity($id, Subscription::class);

        if (isset($editSubscriptionDto->contact->id)) {
            $contact = $this->getEntity($editSubscriptionDto->contact->id, Contact::class);
            $subscription->setContact($contact);
        }
        if (isset($editSubscriptionDto->product->id)) {
            $product = $this->getEntity($editSubscriptionDto->product->id, Product::class);
            $subscription->setProduct($product);
        }
        if (isset($editSubscriptionDto->beginDate)){
            $subscription->setBeginDate($editSubscriptionDto->beginDate);
        }
        if (isset($editSubscriptionDto->endDate)){
            $subscription->setEndDate($editSubscriptionDto->endDate);
        }

        $canSubscribe = $this->checkIfContactCanSubscribe($subscription->getContact(), $subscription->getProduct());
        if (!$canSubscribe) {
            throw new AccessDeniedHttpException('Contact has already subscribed to this product');
        }

        $this->manager->persist($subscription);
        $this->manager->flush();

        return $subscription;
    }

    public function createSubscription(CreateSubscriptionDto $createSubscriptionDto): Subscription
    {
        $contact = $this->getEntity($createSubscriptionDto->contact->id, Contact::class);
        $product = $this->getEntity($createSubscriptionDto->product->id, Product::class);

        $canSubscribe = $this->checkIfContactCanSubscribe($contact, $product);
        if (!$canSubscribe) {
            throw new AccessDeniedHttpException('Contact has already subscribed to this product');
        }

        $subscription = (new Subscription())
            ->setContact($contact)
            ->setProduct($product)
            ->setBeginDate($createSubscriptionDto->beginDate)
            ->setEndDate($createSubscriptionDto->endDate);

        $this->manager->persist($subscription);
        $this->manager->flush();

        return $subscription;
    }

    public function checkIfContactCanSubscribe(Contact $contact, Product $product): bool
    {
        $subscription = $this->repository->findOneBy(['contact' => $contact, 'product' => $product]);
        return !$subscription;
    }

    private function getEntity($id, $class)
    {
        $entity = $this->manager->getRepository($class)->find($id);
        if (!$entity) {
            throw new NotFoundHttpException($class . ' not found');
        }

        return $entity;
    }
}
