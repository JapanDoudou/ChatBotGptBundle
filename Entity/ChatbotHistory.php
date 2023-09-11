<?php

namespace JapanDoudou\ChatGptBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use JapanDoudou\ChatGptBundle\Repository\ChatbotHistoryRepository;

#[ORM\Entity(repositoryClass: ChatbotHistoryRepository::class)]
#[UniqueEntity('id')]
class ChatbotHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    /**
     * @var string $message
     */
    #[ORM\Column(type: 'text', nullable: false)]
    private $message;

    #[ORM\Column(type: 'datetime_immutable', nullable: false)]
    #[Groups(['list', 'item'])]
    protected \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    public function getResponse(): array
    {
        return json_decode($this->message, true);
    }

    /**
     * @param string $message
     * @return ChatbotHistory
     */
    public function setMessage(string $message): ChatbotHistory
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeImmutable $createdAt
     * @return ChatbotHistory
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): ChatbotHistory
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}