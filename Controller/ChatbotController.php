<?php

namespace JapanDoudou\ChatGptBundle\Controller;

use JapanDoudou\ChatGptBundle\Contracts\Services\ChatGptServiceInterface;
use JsonException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ChatbotController extends AbstractController
{

    /**
     * @throws JsonException
     */
    public function getResponse(Request $request, ChatGptServiceInterface $chatGptService): JsonResponse
    {
        //Get the json from the front
        $json = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $result = $chatGptService->getResponse($json['message']);
        return new JsonResponse(json_encode(['message' => $result->getMessage()]), $result->getErrorCode(), [], true);
    }
}