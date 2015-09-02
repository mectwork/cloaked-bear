<?php

namespace HatueySoft\SequenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Sequence.
 *
 * @ORM\Table(name="hatueysoft_sequence")
 * @ORM\Entity(repositoryClass="HatueySoft\SequenceBundle\Entity\Repository\SequenceRepository")
 */
class Sequence
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string")
     * @Assert\Choice(choices={"incremental"})
     * @Assert\NotNull
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="prefix", type="string", nullable=true)
     */
    private $prefix;

    /**
     * @var string
     *
     * @ORM\Column(name="suffix", type="string", nullable=true)
     */
    private $suffix;

    /**
     * @var string
     *
     * @ORM\Column(name="number_next_interval", type="bigint", nullable=true)
     * @Assert\NotBlank
     */
    private $numberNextInterval;

    /**
     * @var integer
     *
     * @ORM\Column(name="number_increment", type="integer", nullable=true)
     * @Assert\NotBlank
     */
    private $numberIncrement;

    /**
     * @var integer
     *
     * @ORM\Column(name="padding", type="integer", nullable=true)
     * @Assert\NotBlank
     */
    private $padding;

    /**
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;


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
     * Set name
     *
     * @param string $name
     * @return Sequence
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
     * Set type
     *
     * @param string $type
     * @return Sequence
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set prefix
     *
     * @param string $prefix
     * @return Sequence
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get prefix
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set suffix
     *
     * @param string $suffix
     * @return Sequence
     */
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;

        return $this;
    }

    /**
     * Get suffix
     *
     * @return string
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    /**
     * Set numberNextInterval
     *
     * @param integer $numberNextInterval
     * @return Sequence
     */
    public function setNumberNextInterval($numberNextInterval)
    {
        $this->numberNextInterval = $numberNextInterval;

        return $this;
    }

    /**
     * Get numberNextInterval
     *
     * @return integer
     */
    public function getNumberNextInterval()
    {
        return $this->numberNextInterval;
    }

    /**
     * Set numberIncrement
     *
     * @param integer $numberIncrement
     * @return Sequence
     */
    public function setNumberIncrement($numberIncrement)
    {
        $this->numberIncrement = $numberIncrement;

        return $this;
    }

    /**
     * Get numberIncrement
     *
     * @return integer
     */
    public function getNumberIncrement()
    {
        return $this->numberIncrement;
    }

    /**
     * Set padding
     *
     * @param integer $padding
     * @return Sequence
     */
    public function setPadding($padding)
    {
        $this->padding = $padding;

        return $this;
    }

    /**
     * Get padding
     *
     * @return integer
     */
    public function getPadding()
    {
        return $this->padding;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Sequence
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }
}
