<?php

namespace JapanDoudou\ChatGptBundle\Services;

use JapanDoudou\ChatGptBundle\Contracts\Services\ChatGptServiceInterface;
use JapanDoudou\ChatGptBundle\DTO\ChatGptResponse;
use Symfony\Contracts\Translation\TranslatorInterface;

class ChatGptService implements ChatGptServiceInterface
{
    private \OpenAI\Client $client;

    public function __construct(string $openaiKey, private readonly TranslatorInterface $translator, private bool $isDebug = false)
    {
        $this->client = \OpenAI::client($openaiKey);
    }

    public function getResponse(string $message, float $temperature = 0.7): ChatGptResponse
    {
        //On est en debug si le message contient le mot debug
        if ($this->isDebug) {
            $isDebug = str_contains($message, 'debug');
            if ($isDebug) {
                sleep(3);
                $message = $this->translator->trans('chatbot.debug');
                return new ChatGptResponse($message, false, 200);
            }
            $isError = str_contains($message, 'error');
            if ($isError) {
                sleep(3);
                $message = $this->translator->trans('chatbot.error');
                return new ChatGptResponse($message, true, 500);            }
        }
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
            return new ChatGptResponse($response, false, 200);
        } catch (\Exception $e) {
            $message = $this->translator->trans('chatbot.error');
            return new ChatGptResponse($message . ': ' . $e->getMessage(), true, $e->getCode());
        }
    }
}