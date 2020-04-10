<?php


namespace App\Repository;

use App\Entity\DataBase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class DataBaseRepository
 * @package App\Repository
 * @method DataBase findOneBy(array $criteria, array $orderBy = null)
 * @method DataBase[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
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

    /**
     * @param string $alias
     * @return DataBase|null
     */
    public function findByAlias(string $alias)
    {
        return $this->findOneBy(['alias' => $alias]);
    }
}