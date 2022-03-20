<?php

namespace App\Entity;

use App\Collection\TableInfoCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DataBaseRepository")
 */
class DataBaseInfo
{
    use IdentifierTrait;

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
     * @ORM\Column(type="boolean", options={"default": "1"})
     * @var boolean
     */
    private $isActive = true;
    /**
     * @ORM\Column(type="boolean", options={"default": "0"})
     * @var boolean
     */
    private $isDeleted = false;
    /**
     * @OneToMany(targetEntity="App\Entity\TableInfo", mappedBy="database", fetch="EXTRA_LAZY")
     *
     * @var PersistentCollection
     */
    private $tables;
    /**
     * @ORM\Column(type="string", length=40, options={"default": "UTF8"})
     *
     * @var string
     */
    private $charset = 'UTF8';


    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return DataBaseInfo
     */
    public function setId(?int $id): DataBaseInfo
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
     * @return DataBaseInfo
     */
    public function setAlias(?string $alias): DataBaseInfo
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
     * @return DataBaseInfo
     */
    public function setHost(?string $host): DataBaseInfo
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
     * @return DataBaseInfo
     */
    public function setPort(?string $port): DataBaseInfo
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
     * @return DataBaseInfo
     */
    public function setUser(?string $user): DataBaseInfo
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
     * @return DataBaseInfo
     */
    public function setPassword(?string $password): DataBaseInfo
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
     * @return DataBaseInfo
     */
    public function setDb(?string $db): DataBaseInfo
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
     * @return DataBaseInfo
     */
    public function setIsActive(bool $isActive): DataBaseInfo
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
     * @return DataBaseInfo
     */
    public function setIsDeleted(bool $isDeleted): DataBaseInfo
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }

    /**
     * @return TableInfoCollection
     */
    public function getTables(): TableInfoCollection
    {
        $tables = $this->tables ? iterator_to_array($this->tables): [];
        return new TableInfoCollection($tables);
    }

    /**
     * @param TableInfoCollection $tables
     * @return DataBaseInfo
     */
    public function setTables(TableInfoCollection $tables): DataBaseInfo
    {
        $this->tables = $tables;
        return $this;
    }

    /**
     * @return string
     */
    public function getCharset(): string
    {
        return $this->charset;
    }

    /**
     * @param string $charset
     * @return DataBaseInfo
     */
    public function setCharset(string $charset): DataBaseInfo
    {
        $this->charset = $charset;
        return $this;
    }

    /**
     * @return string
     */
    public function getConnectionUrl(): string
    {
        return sprintf('mysql://%s:%s@%s:%s/%s?charset=%s',
            $this->user,
            $this->password,
            $this->host,
            $this->port,
            $this->db,
            $this->charset);
    }
}