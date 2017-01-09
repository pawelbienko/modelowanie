<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="booking")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Booking")
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
     * @ORM\ManyToOne(targetEntity="Book", inversedBy="booking", cascade={"all"})
     * @ORM\JoinColumn(name="book_id", referencedColumnName="id")
     */
    protected $item;   

    /**
     * @var AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User")
     */
    protected $reserving;  

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $status;

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

    /**
     * Set item
     *
     * @param  
     * @return Booking
     */
    public function setItem(Book $item)
    {
        $this->item = $item;
        return $this;
    }
    /**
     * Get item
     *
     * @return 
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set item
     *
     * @param  
     * @return Booking
     */
    public function setReserving(User $reserving)
    {
        $this->reserving = $reserving;
        return $this;
    }
    /**
     * Get item
     *
     * @return 
     */
    public function getReserving()
    {
        return $this->reserving;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Booking
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}
