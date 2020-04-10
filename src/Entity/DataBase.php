<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="App\Repository\DataBaseRepository")
 */
class DataBase
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
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return DataBase
     */
    public function setId(?int $id): DataBase
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
     * @return DataBase
     */
    public function setAlias(?string $alias): DataBase
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
     * @return DataBase
     */
    public function setHost(?string $host): DataBase
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
     * @return DataBase
     */
    public function setPort(?string $port): DataBase
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
     * @return DataBase
     */
    public function setUser(?string $user): DataBase
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
     * @return DataBase
     */
    public function setPassword(?string $password): DataBase
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
     * @return DataBase
     */
    public function setDb(?string $db): DataBase
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
     * @return DataBase
     */
    public function setIsActive(bool $isActive): DataBase
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
     * @return DataBase
     */
    public function setIsDeleted(bool $isDeleted): DataBase
    {
        $this->isDeleted = $isDeleted;
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