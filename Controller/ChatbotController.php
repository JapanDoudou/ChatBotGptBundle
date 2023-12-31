<?php

namespace JapanDoudou\ChatGptBundle\Controller;

use JapanDoudou\ChatGptBundle\Contracts\Manager\ChatbotHistoryManagerInterface;
use JapanDoudou\ChatGptBundle\Contracts\Services\ChatGptServiceInterface;
use JsonException;
use Symfony\Component\HttpFoundation\Response;
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
        return new JsonResponse(json_encode(['message' => $result->getMessage()]), $result->getCode(), [], true);
    }
    
    public function getHistory(Request $request, ChatbotHistoryManagerInterface $chatbotHistoryManager): Response
    {
        $page= $request->get('page', 1);
        $chatbotMessages = $chatbotHistoryManager->getLastMessages(10, $page);
        return $this->render('@JapanDoudouChatGpt/history.html.twig', [
            'chatbot_messages' => $chatbotMessages,
        ]);
    }
}