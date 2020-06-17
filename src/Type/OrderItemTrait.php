<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

trait OrderItemTrait
{
    /** @var null|string */
    protected $description;

    /** @var null|float|int|string */
    protected $grossUnitPrice;

    /** @var null|float|int|string */
    protected $netUnitPrice;

    /** @var null|string */
    protected $productId;

    /** @var null|int|string */
    protected $quantity;

    /** @var null|float|int|string */
    protected $vatAmount;

    /** @var null|float|int|string */
    protected $vatPercent;

    /** @var null|string */
    protected $groupId;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return null|float|int|string
     */
    public function getGrossUnitPrice()
    {
        return $this->grossUnitPrice;
    }

    /**
     * @param null|float|int|string $grossUnitPrice
     *
     * @return self
     */
    public function setGrossUnitPrice($grossUnitPrice)
    {
        $this->grossUnitPrice = $grossUnitPrice;

        return $this;
    }

    /**
     * @return null|float|int|string
     */
    public function getNetUnitPrice()
    {
        return $this->netUnitPrice;
    }

    /**
     * @param null|float|int|string $netUnitPrice
     *
     * @return self
     */
    public function setNetUnitPrice($netUnitPrice)
    {
        $this->netUnitPrice = $netUnitPrice;

        return $this;
    }

    public function getProductId(): ?string
    {
        return $this->productId;
    }

    public function setProductId(?string $productId): self
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * @return null|int|string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param null|int|string $quantity
     *
     * @return self
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return null|float|int|string
     */
    public function getVatAmount()
    {
        return $this->vatAmount;
    }

    /**
     * @param null|float|int|string $vatAmount
     *
     * @return self
     */
    public function setVatAmount($vatAmount)
    {
        $this->vatAmount = $vatAmount;

        return $this;
    }

    /**
     * @return null|float|int|string
     */
    public function getVatPercent()
    {
        return $this->vatPercent;
    }

    /**
     * @param null|float|int|string $vatPercent
     *
     * @return self
     */
    public function setVatPercent($vatPercent)
    {
        $this->vatPercent = $vatPercent;

        return $this;
    }

    /**
     * @param null|float|int|string $netUnitPrice
     * @param null|float|int|string $vatAmount
     * @param null|float|int|string $vatPercent
     */
    public function withPrice($netUnitPrice, $vatAmount, $vatPercent): self
    {
        $this->netUnitPrice = $netUnitPrice;
        $this->vatAmount = $vatAmount;
        $this->vatPercent = $vatPercent;
        $this->grossUnitPrice = $netUnitPrice;
        if (null !== $this->grossUnitPrice) {
            $this->grossUnitPrice += $vatAmount ?? 0;
        } elseif (null !== $vatAmount) {
            $this->grossUnitPrice = $vatAmount;
        }

        return $this;
    }

    public function getGroupId(): ?string
    {
        return $this->groupId;
    }

    public function setGroupId(?string $groupId): self
    {
        $this->groupId = $groupId;

        return $this;
    }
}
