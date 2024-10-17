<?php

namespace App\Service;

use App\Entity\Contact;
use App\Repository\SubscriptionRepository;
use Doctrine\Common\Collections\Collection;

class SubscriptionService
{
    private SubscriptionRepository $repository;

    public function __construct(SubscriptionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllSubscriptionsByContact($id) : array
    {
        //dd($this->repository->findBy(['contact' => $id]));
        return $this->repository->findBy(['contact' => $id]);
    }

}