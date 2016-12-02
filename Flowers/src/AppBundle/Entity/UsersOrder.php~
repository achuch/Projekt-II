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
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Seller", inversedBy="orders")
     * @ORM\JoinColumn(name="sellerId", referencedColumnName="id", nullable=true)
     */
    private $seller;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="OrderProducts", mappedBy="order")
     */
    private $products;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date", type="datetime")
     */
    private $date;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_finished", type="boolean")
     */
    private $isFinished;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_realized", type="boolean")
     */
    private $isRealized;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Address", inversedBy="orders")
     * @ORM\JoinColumn(name="addressId", referencedColumnName="id", nullable=true)
     */
    private $address;

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
     * @param \AppBundle\Entity\OrderProducts $product
     *
     * @return UsersOrder
     */
    public function addProduct(\AppBundle\Entity\OrderProducts $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \AppBundle\Entity\OrderProducts $product
     */
    public function removeProduct(\AppBundle\Entity\OrderProducts $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Set seller
     *
     * @param \AppBundle\Entity\Seller $seller
     *
     * @return UsersOrder
     */
    public function setSeller(\AppBundle\Entity\Seller $seller = null)
    {
        $this->seller = $seller;

        return $this;
    }

    /**
     * Get seller
     *
     * @return \AppBundle\Entity\Seller
     */
    public function getSeller()
    {
        return $this->seller;
    }

    /**
     * Set isFinished
     *
     * @param boolean $isFinished
     *
     * @return UsersOrder
     */
    public function setIsFinished($isFinished)
    {
        $this->isFinished = $isFinished;

        return $this;
    }



    /**
     * Get isFinished
     *
     * @return boolean
     */
    public function getIsFinished()
    {
        return $this->isFinished;
    }

    /**
     * Set isRealized
     *
     * @param boolean $isRealized
     *
     * @return UsersOrder
     */
    public function setIsRealized($isRealized)
    {
        $this->isRealized = $isRealized;

        return $this;
    }

    /**
     * Get isRealized
     *
     * @return boolean
     */
    public function getIsRealized()
    {
        return $this->isRealized;
    }

    /**
     * Set address
     *
     * @param \AppBundle\Entity\Address $address
     *
     * @return UsersOrder
     */
    public function setAddress(\AppBundle\Entity\Address $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \AppBundle\Entity\Address
     */
    public function getAddress()
    {
        return $this->address;
    }
}
