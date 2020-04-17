<?php

namespace App\Entity;

use App\Collection\TableCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DataBaseRepository")
 */
class RemoteDataBase
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int|null
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=50)
     * @var string|null
     */
    private $alias;
    /**
     * @ORM\Column(type="string", length=50)
     * @var string|null
     */
    private $host;
    /**
     * @ORM\Column(type="string", length=50)
     * @var string|null
     */
    private $port;
    /**
     * @ORM\Column(type="string", length=50)
     * @var string|null
     */
    private $user;
    /**
     * @ORM\Column(type="string", length=50)
     * @var string|null
     */
    private $password;
    /**
     * @ORM\Column(type="string", length=255)
     * @var string|null
     */
    private $db;
    /**
     * @ORM\Column(type="boolean", options={"default": "TRUE"})
     * @var boolean
     */
    private $isActive = true;
    /**
     * @ORM\Column(type="boolean", options={"default": "FALSE"})
     * @var boolean
     */
    private $isDeleted = false;
    /**
     * @OneToMany(targetEntity="App\Entity\RemoteTable", mappedBy="database", fetch="EXTRA_LAZY")
     *
     * @var PersistentCollection
     */
    private $tables;


    public function __construct()
    {
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return RemoteDataBase
     */
    public function setId(?int $id): RemoteDataBase
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAlias(): ?string
    {
        return $this->alias;
    }

    /**
     * @param string|null $alias
     * @return RemoteDataBase
     */
    public function setAlias(?string $alias): RemoteDataBase
    {
        $this->alias = $alias;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHost(): ?string
    {
        return $this->host;
    }

    /**
     * @param string|null $host
     * @return RemoteDataBase
     */
    public function setHost(?string $host): RemoteDataBase
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPort(): ?string
    {
        return $this->port;
    }

    /**
     * @param string|null $port
     * @return RemoteDataBase
     */
    public function setPort(?string $port): RemoteDataBase
    {
        $this->port = $port;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUser(): ?string
    {
        return $this->user;
    }

    /**
     * @param string|null $user
     * @return RemoteDataBase
     */
    public function setUser(?string $user): RemoteDataBase
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     * @return RemoteDataBase
     */
    public function setPassword(?string $password): RemoteDataBase
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDb(): ?string
    {
        return $this->db;
    }

    /**
     * @param string|null $db
     * @return RemoteDataBase
     */
    public function setDb(?string $db): RemoteDataBase
    {
        $this->db = $db;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     * @return RemoteDataBase
     */
    public function setIsActive(bool $isActive): RemoteDataBase
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->isDeleted;
    }

    /**
     * @param bool $isDeleted
     * @return RemoteDataBase
     */
    public function setIsDeleted(bool $isDeleted): RemoteDataBase
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }

    /**
     * @return TableCollection
     */
    public function getTables(): TableCollection
    {
        $tables = $this->tables ? iterator_to_array($this->tables): [];
        return new TableCollection($tables);
    }

    /**
     * @param TableCollection $tables
     * @return RemoteDataBase
     */
    public function setTables(TableCollection $tables): TableCollection
    {
        $this->tables = $tables;
        return $this;
    }

    public function getConnectionUrl()
    {
        return sprintf('mysql://%s:%s@%s:%s/%s',
            $this->user,
            $this->password,
            $this->host,
            $this->port,
            $this->db);
    }
}