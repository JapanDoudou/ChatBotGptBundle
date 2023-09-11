<?php

namespace JapanDoudou\ChatGptBundle\Services;

use JapanDoudou\ChatGptBundle\Contracts\Manager\ChatbotHistoryManagerInterface;
use JapanDoudou\ChatGptBundle\Contracts\Services\ChatGptServiceInterface;
use JapanDoudou\ChatGptBundle\DTO\ChatGptMessage;
use JapanDoudou\ChatGptBundle\Entity\ChatbotHistory;
use Symfony\Contracts\Translation\TranslatorInterface;

class ChatGptService implements ChatGptServiceInterface
{
    public const USER_NAME = 'user';
    public const BOT_NAME = 'glados';
    
    private \OpenAI\Client $client;

    public function __construct(
        string                                          $openaiKey,
        private readonly TranslatorInterface            $translator,
        private readonly ChatbotHistoryManagerInterface $chatbotHistoryManager,
        private bool                                    $isDebug = false,
        private bool                                    $saveHistory = true
    )
    {
        $this->client = \OpenAI::client($openaiKey);
    }

    public function getResponse(string $message, float $temperature = 0.7): ChatGptMessage
    {
        $userMessage = new ChatGptMessage(self::USER_NAME, $message, false, 200);
        if ($this->saveHistory) {
            $this->chatbotHistoryManager->createOrUpdate(
                (new ChatbotHistory())->setMessage(json_encode($userMessage))
            );
        }
        //On est en debug si le message contient le mot debug
        $chatGptResponse = null;
        if ($this->isDebug) {
            $isDebug = str_contains($message, 'debug');
            if ($isDebug) {
                sleep(3);
                $message = $this->translator->trans('chatbot.debug');
                $chatGptResponse = new ChatGptMessage(self::BOT_NAME, $message, false, 200);
            } else {
                $isError = str_contains($message, 'error');
                if ($isError) {
                    sleep(3);
                    $message = $this->translator->trans('chatbot.error');
                    $chatGptResponse = new ChatGptMessage(self::BOT_NAME, $message, true, 500);
                }
            }

        }
        if ($chatGptResponse === null) {
            try {
                $result = $this->client->chat()->create(
                    [
                        'model' => 'gpt-3.5-turbo',
                        'messages' => [
                            [
                                'role' => 'user',
                                'content' => $message
                            ]
                        ],
                        'temperature' => $temperature
                    ]
                );
                $response = $result['choices'][0]['message']['content'];
                $chatGptResponse = new ChatGptMessage(self::BOT_NAME, $response, false, 200);
            } catch (\Exception $e) {
                $message = $this->translator->trans('chatbot.error');
                $chatGptResponse = new ChatGptMessage(self::BOT_NAME, $message . ': ' . $e->getMessage(), true, $e->getCode());
            }
        }
        if ($this->saveHistory) {
            $this->chatbotHistoryManager->createOrUpdate(
                (new ChatbotHistory())->setMessage(json_encode($chatGptResponse))
            );
        }
        return $chatGptResponse;
    }
}