<?php

namespace JapanDoudou\ChatGptBundle\DTO;

class ChatGptMessage {

    public function __construct(
        public string $user,
        public string $message,
        public bool $isError = false,
        public int $code = 0
    ) {
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @param string $user
     * @return ChatGptMessage
     */
    public function setUser(string $user): ChatGptMessage
    {
        $this->user = $user;
        return $this;
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

    public function getCode(): int
    {
        return $this->code;
    }

    public function setCode(int $code): ChatGptResponse
    {
        $this->code = $code;
        return $this;
    }
}