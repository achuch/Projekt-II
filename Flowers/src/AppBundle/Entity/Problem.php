<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Problem
 *
 * @ORM\Table(name="problem")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProblemRepository")
 */
class Problem
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
     * @var string
     *
     * @ORM\Column(name="ProblemContent", type="text")
     */
    private $problemContent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateOfProblem", type="datetime")
     */
    private $dateOfProblem;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    protected $user;


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
     * Set problemContent
     *
     * @param string $problemContent
     *
     * @return Problem
     */
    public function setProblemContent($problemContent)
    {
        $this->problemContent = $problemContent;

        return $this;
    }

    /**
     * Get problemContent
     *
     * @return string
     */
    public function getProblemContent()
    {
        return $this->problemContent;
    }

    /**
     * Set dateOfProblem
     *
     * @param \DateTime $dateOfProblem
     *
     * @return Problem
     */
    public function setDateOfProblem($dateOfProblem)
    {
        $this->dateOfProblem = $dateOfProblem;

        return $this;
    }

    /**
     * Get dateOfProblem
     *
     * @return \DateTime
     */
    public function getDateOfProblem()
    {
        return $this->dateOfProblem;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Problem
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
