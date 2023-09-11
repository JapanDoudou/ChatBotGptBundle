<?php

namespace JapanDoudou\ChatGptBundle\DTO;

class ChatGptResponse {

    public function __construct(
        private string $message,
        private bool $isError = false,
        private int $errorCode = 0
    ) {
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): ChatGptResponse
    {
        $this->message = $message;
        return $this;
    }

    public function isError(): bool
    {
        return $this->isError;
    }

    public function setIsError(bool $isError): ChatGptResponse
    {
        $this->isError = $isError;
        return $this;
    }

    public function getErrorCode(): int
    {
        return $this->errorCode;
    }

    public function setErrorCode(int $errorCode): ChatGptResponse
    {
        $this->errorCode = $errorCode;
        return $this;
    }
}