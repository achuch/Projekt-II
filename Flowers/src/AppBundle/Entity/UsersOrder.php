<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * UsersOrder
 *
 * @ORM\Table(name="UsersOrder")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsersOrderRepository")
 */
class UsersOrder
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="orders")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private $user;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="OrderProducts", mappedBy="order")
     */
    private $products;

    /**
     * @var int
     *
     * @ORM\Column(name="ProductAmount", type="integer")
     */
    private $productAmount;

    /**
     * @var int
     *
     * @ORM\Column(name="Cost", type="integer")
     */
    private $cost;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date", type="datetime")
     */
    private $date;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userId
     *
     * @param integer $user
     *
     * @return UsersOrder
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set productId
     *
     * @param integer $products
     *
     * @return UsersOrder
     */
    public function setProducts($products)
    {
        $this->products = $products;

        return $this;
    }

    /**
     * Get productId
     *
     * @return int
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set productAmount
     *
     * @param integer $productAmount
     *
     * @return UsersOrder
     */
    public function setProductAmount($productAmount)
    {
        $this->productAmount = $productAmount;

        return $this;
    }

    /**
     * Get productAmount
     *
     * @return int
     */
    public function getProductAmount()
    {
        return $this->productAmount;
    }

    /**
     * Set cost
     *
     * @param integer $cost
     *
     * @return UsersOrder
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return int
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return UsersOrder
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add product
     *
     * @param \AppBundle\Entity\OrderProduct $product
     *
     * @return UsersOrder
     */
    public function addProduct(\AppBundle\Entity\OrderProduct $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \AppBundle\Entity\OrderProduct $product
     */
    public function removeProduct(\AppBundle\Entity\OrderProduct $product)
    {
        $this->products->removeElement($product);
    }
}