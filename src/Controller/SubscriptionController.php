<?php

namespace App\Controller;

use App\Service\SubscriptionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class SubscriptionController extends AbstractController
{

    private SubscriptionService $service;

    public function __construct(SubscriptionService $service)
    {
        $this->service = $service;
    }

    #[Route('/subscription/{id}', name: 'api_subscription_by_contact', methods: ['GET'], requirements: ['id' => '\d+'] )]
    public function getSubscriptionsByContact($id)
    {
        $subscriptions = $this->service->getAllSubscriptionsByContact($id);
        return $this->json($subscriptions, 200, [], ['Default']);
    }

}
