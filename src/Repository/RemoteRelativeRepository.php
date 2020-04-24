<?php


namespace App\Repository;

use App\Entity\RemoteRelative;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class DataBaseRepository
 * @package App\Repository
 * @method RemoteRelative find($id, $lockMode = null, $lockVersion = null)
 * @method RemoteRelative findOneBy(array $criteria, array $orderBy = null)
 * @method RemoteRelative[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RemoteRelativeRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, ManagerRegistry $registry)
    {
        parent::__construct($registry, RemoteRelative::class);
        $this->entityManager = $entityManager;
    }

    /**
     * @param RemoteRelative $dataBase
     */
    public function save($dataBase)
    {
        $this->entityManager->persist($dataBase);
        $this->entityManager->flush();
    }

    public function remove(RemoteRelative $dataBase)
    {
        $this->entityManager->remove($dataBase);
        $this->entityManager->flush();
    }
}