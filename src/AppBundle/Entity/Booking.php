<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="booking")
 */
class Booking
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="date")
     */
    protected $start;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="date")
     */
    protected $end;

    /**
     * @var AppBundle\Entity\Book
     *
     * @ORM\ManyToOne(targetEntity="Booka", inversedBy="id")
     * @ORM\JoinColumn(name="id", referencedColumnName="id")
     */
    protected $item;    

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
     * Set start
     *
     * @param  \DateTime $start
     * @return Booking
     */
    public function setStart($start)
    {
        $this->start = $start;
        return $this;
    }
    /**
     * Get start
     *
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }
    /**
     * Set end
     *
     * @param  \DateTime $end
     * @return Booking
     */
    public function setEnd($end)
    {
        $this->end = $end;
        return $this;
    }
    /**
     * Get end
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }
}