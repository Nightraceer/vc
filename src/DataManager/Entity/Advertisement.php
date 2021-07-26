<?php


namespace TestWork\DataManager\Entity;


use TestWork\Utils\DateTime;
use ReflectionException;
use TestWork\DataManager\Serializer\SerializableTrait;
use TestWork\Utils\Arr;

/**
 * Class Advertisement
 * @package TestWork\DataManager\Entity
 */
class Advertisement implements EntityInterface
{
    use SerializableTrait;

    private EntityProperty $property;
    private ?int $id;
    private ?string $text;
    private ?float $price;
    private ?int $limit;
    private ?string $banner;
    private ?int $showing;
    private ?DateTime $updatedAt;
    private ?DateTime $createdAt;

    /**
     * Advertisement constructor.
     * @param int|null $id
     * @param string|null $text
     * @param float|null $price
     * @param int|null $limit
     * @param string|null $banner
     * @param int|null $showing
     * @param DateTime|null $updatedAt
     * @param DateTime|null $createdAt
     */
    public function __construct(
        ?int $id = null,
        ?string $text = null,
        ?float $price = null,
        ?int $limit = null,
        ?string $banner = null,
        ?int $showing = 0,
        ?DateTime $updatedAt = null,
        ?DateTime $createdAt = null
    )
    {
        $this->property = new EntityProperty('id', 'advertisements');

        $this->id = $id;
        $this->text = $text;
        $this->price = $price;
        $this->limit = $limit;
        $this->banner = $banner;
        $this->showing = $showing;
        $this->updatedAt = $updatedAt;
        $this->createdAt = $createdAt;
    }

    /**
     * @return EntityProperty
     */
    public function getProperty(): EntityProperty
    {
        return $this->property;
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
     * @return $this
     */
    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string|null $text
     * @return $this
     */
    public function setText(?string $text): self
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     * @return $this
     */
    public function setPrice(?float $price): self
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * @param int|null $limit
     * @return $this
     */
    public function setLimit(?int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBanner(): ?string
    {
        return $this->banner;
    }

    /**
     * @param string|null $banner
     * @return $this
     */
    public function setBanner(?string $banner): self
    {
        $this->banner = $banner;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getShowing(): ?int
    {
        return $this->showing;
    }

    /**
     * @param int|null $showing
     * @return $this
     */
    public function setShowing(?int $showing): self
    {
        $this->showing = $showing;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime|null $updatedAt
     * @return $this
     */
    public function setUpdatedAt(?DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime|null $createdAt
     * @return $this
     */
    public function setCreatedAt(?DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return $this
     */
    public function increaseShowing(): self
    {
        ++$this->showing;
        return $this;
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    public function toArray(): array
    {
        return Arr::exclude(static::normalizeValue($this), ['property']);
    }
}
