<?php


namespace App\Repository;

use App\Entity\RelativeInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class DataBaseRepository
 * @package App\Repository
 * @method RelativeInfo find($id, $lockMode = null, $lockVersion = null)
 * @method RelativeInfo findOneBy(array $criteria, array $orderBy = null)
 * @method RelativeInfo[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RemoteRelativeRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var RemoteTableColumnRepository
     */
    private $remoteTableColumnRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ManagerRegistry $registry,
        RemoteTableColumnRepository $remoteTableColumnRepository
    ) {
        parent::__construct($registry, RelativeInfo::class);
        $this->entityManager = $entityManager;
        $this->remoteTableColumnRepository = $remoteTableColumnRepository;
    }

    /**
     * @param RelativeInfo $dataBase
     */
    public function save($dataBase)
    {
        $this->entityManager->persist($dataBase);
        $this->entityManager->flush();
    }

    public function remove(RelativeInfo $dataBase)
    {
        $this->entityManager->remove($dataBase);
        $this->entityManager->flush();
    }

    /**
     * @param $tableId
     * @return ArrayCollection|RelativeInfo[]
     */
    public function findByTableId($tableId)
    {
        $columnIds = $this->remoteTableColumnRepository->findIdsByTable($tableId);

        return new ArrayCollection($this->findBy(['columnFrom' => $columnIds]));
    }
}