<?php

namespace ContactBookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Phone
 *
 * @ORM\Table(name="phone")
 * @ORM\Entity(repositoryClass="ContactBookBundle\Repository\PhoneRepository")
 */
class Phone {

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
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @ORM\OneToOne(targetEntity="Type", inversedBy="phone")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $type;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set number
     *
     * @param integer $number
     * @return Phone
     */
    public function setNumber($number) {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber() {
        return $this->number;
    }

    /**
     * Set type
     *
     * @param \ContactBookBundle\Entity\Type $type
     * @return Phone
     */
    public function setType(\ContactBookBundle\Entity\Type $type = null) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \ContactBookBundle\Entity\Type 
     */
    public function getType() {
        return $this->type;
    }

}
