<?php

namespace Knib\TodoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Task
 * @ORM\Entity
 * @ORM\Table(name="Task")
 * @ORM\HasLifecycleCallbacks()
 */
class Task
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
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_done", type="boolean")
     */
    private $is_done = false;

      /**
       * @var datetime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;
    
     /**
     * @var datetime
     *
     * @ORM\Column(name="finished", type="datetime", nullable=true)
     */
    private $finished;
 
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
     * @return Task
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
     * Set is_done
     *
     * @param boolean $isDone
     * @return Task
     */
    public function setIsDone($isDone)
    {
        $this->is_done = $isDone;
    
        return $this;
    }

    /**
     * Get is_done
     *
     * @return boolean 
     */
    public function getIsDone()
    {
        return $this->is_done;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreated()
    {
        $this->created = new \DateTime;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }    

    /**
     * Set finished
     *
     * @param \DateTime $finished
     * @return Task
     */
    public function setFinished($finished)
    {
        $this->finished = $finished;
    
        return $this;
    }

    /**
     * Get finished
     *
     * @return \DateTime 
     */
    public function getFinished()
    {
        return $this->finished;
    }
}