<?php

namespace JapanDoudou\ChatGptBundle\Contracts\Manager;

use JapanDoudou\ChatGptBundle\Entity\ChatbotHistory;
use Pagerfanta\Pagerfanta;

interface ChatbotHistoryManagerInterface
{
    public function createOrUpdate(ChatbotHistory $chatbotHistory, bool $flush = true): void;

    /**
     * @param int $count
     * @param int $page
     * @return Pagerfanta|ChatbotHistory[]
     */
    public function getLastMessages(int $count = 10, int $page = 1): Pagerfanta;
}