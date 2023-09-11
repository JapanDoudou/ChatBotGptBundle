<?php

namespace JapanDoudou\ChatGptBundle\Manager;

use Doctrine\Common\Collections\Collection;
use JapanDoudou\ChatGptBundle\Entity\ChatbotHistory;
use JapanDoudou\ChatGptBundle\Repository\ChatbotHistoryRepository;
use JapanDoudou\ChatGptBundle\Contracts\Manager\ChatbotHistoryManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Pagerfanta;

class ChatbotHistoryManager implements ChatbotHistoryManagerInterface
{
    private ChatbotHistoryRepository $chatbotRepo;

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
        $repo = $entityManager->getRepository(ChatbotHistory::class);
        if (!$repo instanceof ChatbotHistoryRepository)
        {
            // @codeCoverageIgnoreStart
            throw new \InvalidArgumentException(
                "The repository class for " . ChatbotHistory::class .
                " must be " . ChatbotHistoryRepository::class . " and given " . get_class($repo) . "!".
                "Maybe look the 'repositoryClass' declaration on " . ChatbotHistory::class . " ?");
        }
        // @codeCoverageIgnoreEnd
        $this->chatbotRepo = $repo;
    }

    public function createOrUpdate(ChatbotHistory $chatbotHistory, bool $flush = true): void
    {
        /** @var int|null $id */
        $id = $chatbotHistory->getId();
        if (null === $id)
        {
            $this->entityManager->persist($chatbotHistory);
        }
        if (true === $flush)
        {
            $this->entityManager->flush();
        }
    }
    
    public function getLastMessages(int $count = 10, int $page = 1): Pagerfanta
    {
        return $this->chatbotRepo->getLastMessages($count, $page);
    }
}