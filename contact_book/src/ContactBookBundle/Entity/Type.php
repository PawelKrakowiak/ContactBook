<?php

namespace ContactBookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Type
 *
 * @ORM\Table(name="type")
 * @ORM\Entity(repositoryClass="ContactBookBundle\Repository\TypeRepository")
 */
class Type {

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
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @ORM\OneToOne(targetEntity="Phone", mappedBy="type")
     */
    private $phone;

    /**
     * @ORM\OneToOne(targetEntity="Email", mappedBy="type")
     */
    private $email;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Type
     */
    public function setType($type) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Set phone
     *
     * @param \ContactBookBundle\Entity\Phone $phone
     * @return Type
     */
    public function setPhone(\ContactBookBundle\Entity\Phone $phone = null) {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return \ContactBookBundle\Entity\Phone 
     */
    public function getPhone() {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param \ContactBookBundle\Entity\Email $email
     * @return Type
     */
    public function setEmail(\ContactBookBundle\Entity\Email $email = null) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return \ContactBookBundle\Entity\Email 
     */
    public function getEmail() {
        return $this->email;
    }

}
