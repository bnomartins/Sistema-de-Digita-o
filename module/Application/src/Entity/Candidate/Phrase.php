<?php

namespace Application\Entity\Candidate;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity,
 * @ORM\Table(schema="projects", name="phrase", options={"auto_increment": 5000, "collate"="utf8_swedish_ci", "charset"="utf8"})
 */
class Phrase
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned" = true})
     * @ORM\SequenceGenerator(sequenceName="id", initialValue=5000)
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true, unique=true)
     */
    private $phrase;

    /**
     * @ORM\Column(type="boolean", nullable=true, unique=true)
     */
    private $active;

    /**
     * ModifiedDate
     *
     * @ORM\Column(type="datetime")
     * @var \datetime
     */
    protected $modifiedDate;



    public function __construct()
    {
        $this->modifiedDate = new DateTime(); 
    }
    
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getPhrase()
    {
        return $this->phrase;
    }

    /**
     * @param mixed $phrase
     */
    public function setPhrase($phrase): void
    {
        $this->phrase = $phrase;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active): void
    {
        $this->active = $active;
    }

    /**
     * @return \Datetime
     */
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }
}
