<?php

namespace JapanDoudou\ChatGptBundle\Contracts\Services;

use JapanDoudou\ChatGptBundle\DTO\ChatGptMessage;

interface ChatGptServiceInterface
{
    /**
     * $message is the message to send to the openAi API and the $temperature is the randomness of the response
     * $temperature is a float between 0 and 1, 1 mean no randomness and 0 mean a lot of randomness
     * @param string $message
     * @param float $temperature
     * @return ChatGptMessage
     */
    public function getResponse(string $message, float $temperature = 0.7): ChatGptMessage;
}