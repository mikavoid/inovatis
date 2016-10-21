<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Department
 *
 * @ORM\Table(name="department")
 * @ORM\Entity
 */
class Department
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", inversedBy="department")
     * @ORM\JoinTable(name="user_departments",
     *   joinColumns={
     *     @ORM\JoinColumn(name="department_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *   }
     * )
     */
    private $user;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Newsletter", inversedBy="departments")
     * @ORM\JoinTable(name="subscription",
     *   joinColumns={
     *     @ORM\JoinColumn(name="departments_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="newsletter_id", referencedColumnName="id")
     *   }
     * )
     */
    private $newsletter;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
        $this->newsletter = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Department
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Department
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\User $user
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        $this->user->removeElement($user);
    }

    /**
     * Get user
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add newsletter
     *
     * @param \AppBundle\Entity\Newsletter $newsletter
     *
     * @return Department
     */
    public function addNewsletter(\AppBundle\Entity\Newsletter $newsletter)
    {
        $this->newsletter[] = $newsletter;

        return $this;
    }

    /**
     * Remove newsletter
     *
     * @param \AppBundle\Entity\Newsletter $newsletter
     */
    public function removeNewsletter(\AppBundle\Entity\Newsletter $newsletter)
    {
        $this->newsletter->removeElement($newsletter);
    }

    /**
     * Get newsletter
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }
}
