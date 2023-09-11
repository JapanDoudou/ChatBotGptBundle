<?php

namespace JapanDoudou\ChatGptBundle\Repository;

use Doctrine\Persistence\ManagerRegistry;
use JapanDoudou\ChatGptBundle\Entity\ChatbotHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

/**
 * @method ChatbotHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChatbotHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChatbotHistory[]    findAll()
 * @method ChatbotHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChatbotHistoryRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChatbotHistory::class);
    }

    /**
     * @param int $count
     * @param int $page
     * @return Pagerfanta|ChatbotHistory[]
     */
    public function getLastMessages(int $count = 10, int $page = 1): Pagerfanta
    {
        $query = $this->createQueryBuilder('c')
            ->orderBy('c.id', 'DESC');
        $pagerfanta = new Pagerfanta(new QueryAdapter($query, true, false));
        $pagerfanta->setMaxPerPage($count)
            ->setCurrentPage($page);
        return $pagerfanta;
    }
}