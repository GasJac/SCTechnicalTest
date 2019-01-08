<?php

namespace SC\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Student
 *
 * @ORM\Table(name="student")
 * @ORM\Entity(repositoryClass="SC\CommonBundle\Repository\StudentRepository")
 */
class Student
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
     * @ORM\Column(name="FirstName", type="string", length=25)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="LastName", type="string", length=25)
     */
    private $lastName;

    /**
     * @var int
     *
     * @ORM\Column(name="NumEtud", type="integer", length=25)
     */
    private $numEtud;

    /**
    *
    * @ORM\ManyToOne(targetEntity="SC\CommonBundle\Entity\Department")
    * @ORM\JoinColumns({
    *   @ORM\JoinColumn(name="department", referencedColumnName="id")
    * })
    */
    private $department;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName.
     *
     * @param string $firstName
     *
     * @return Student
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName.
     *
     * @param string $lastName
     *
     * @return Student
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set numEtud.
     *
     * @param int $numEtud
     *
     * @return Student
     */
    public function setNumEtud($numEtud)
    {
        $this->numEtud = $numEtud;

        return $this;
    }

    /**
     * Get numEtud.
     *
     * @return int
     */
    public function getNumEtud()
    {
        return $this->numEtud;
    }

    /**
     * Set department.
     *
     * @param \SC\CommonBundle\Entity\Department|null $department
     *
     * @return Student
     */
    public function setDepartment(\SC\CommonBundle\Entity\Department $department = null)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department.
     *
     * @return \SC\CommonBundle\Entity\Department|null
     */
    public function getDepartment()
    {
        return $this->department;
    }
}
