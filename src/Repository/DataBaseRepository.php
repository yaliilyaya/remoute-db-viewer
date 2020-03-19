<?php


namespace App\Repository;

use App\Entity\DataBase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class DataBaseRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, ManagerRegistry $registry)
    {
        parent::__construct($registry, DataBase::class);
        $this->entityManager = $entityManager;
    }

    /**
     * @param DataBase $dataBase
     */
    public function save($dataBase)
    {
        $this->entityManager->persist($dataBase);
        $this->entityManager->flush();
    }

    public function remove(DataBase $dataBase)
    {
        $this->entityManager->remove($dataBase);
        $this->entityManager->flush();
    }
}