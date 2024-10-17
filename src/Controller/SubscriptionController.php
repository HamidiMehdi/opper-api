<?php

namespace App\Controller;

use App\Dto\CreateSubscriptionDto;
use App\Dto\EditSubscriptionDto;
use App\Service\SubscriptionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class SubscriptionController extends AbstractController
{

    private SubscriptionService $service;

    public function __construct(SubscriptionService $service)
    {
        $this->service = $service;
    }

    #[Route('/subscription/{id}', name: 'get_subscription_by_contact', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function get($id): JsonResponse
    {
        $subscriptions = $this->service->getAllSubscriptionsByContact($id);
        return $this->json($subscriptions, Response::HTTP_OK, [], ['Default']);
    }

    #[Route('/subscription', name: 'post_subscription', methods: ['POST'])]
    public function post(#[MapRequestPayload] CreateSubscriptionDto $createSubscription): JsonResponse
    {
        $subscriptions = $this->service->createSubscription($createSubscription);
        return $this->json($subscriptions, Response::HTTP_CREATED, [], ['Default']);
    }

    #[Route('/subscription/{id}', name: 'put_subscription', methods: ['PUT'])]
    public function put($id, #[MapRequestPayload] EditSubscriptionDto $editSubscriptionDto)
    {
        $subscriptions = $this->service->editSubscription($id, $editSubscriptionDto);
        return $this->json($subscriptions, Response::HTTP_OK, [], ['Default']);
    }

    #[Route('/subscription/{id}', name: 'delete_subscription', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function delete($id): JsonResponse
    {
        $this->service->deleteSubscription($id);
        return $this->json([], Response::HTTP_NO_CONTENT, [], ['Default']);
    }
}
