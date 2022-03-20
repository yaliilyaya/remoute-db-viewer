<?php


namespace App\Repository;

use App\Entity\DataBaseInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class DataBaseRepository
 * @package App\Repository
 * @method DataBaseInfo findOneBy(array $criteria, array $orderBy = null)
 * @method DataBaseInfo[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DataBaseInfoRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, ManagerRegistry $registry)
    {
        parent::__construct($registry, DataBaseInfo::class);
        $this->entityManager = $entityManager;
    }

    /**
     * @param DataBaseInfo $dataBase
     */
    public function save(DataBaseInfo $dataBase)
    {
        $this->entityManager->persist($dataBase);
        $this->entityManager->flush();
    }

    public function remove(DataBaseInfo $dataBase)
    {
        $this->entityManager->remove($dataBase);
        $this->entityManager->flush();
    }

    /**
     * @param string $alias
     * @return DataBaseInfo|null
     */
    public function findByAlias(string $alias): ?DataBaseInfo
    {
        return $this->findOneBy(['alias' => $alias]);
    }
}