<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/api/dashboard', name: 'dashboard', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return new JsonResponse(['username' => 'sttavos'], 200);
    }
}
