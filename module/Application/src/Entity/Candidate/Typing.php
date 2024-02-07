<?php

namespace Application\Entity\Candidate;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity,
 * @ORM\Table(schema="projects", name="typing", options={"auto_increment": 5000, "collate"="utf8_swedish_ci", "charset"="utf8"})
 */
class Typing
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned" = true})
     * @ORM\SequenceGenerator(sequenceName="id", initialValue=5000)
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="float", scale="2", nullable=true)
     */

    private $tpm;
    /**
     * @ORM\Column(type="float", scale="2", nullable=true)
     */

    private $tpmp;

    /**
     * @ORM\Column(type="float", scale="2", nullable=true)
     */
    private $precisao;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $inicio;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $termino;

    /**
     * @ORM\ManyToOne(targetEntity="candidate")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $candidate;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $justify;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $cancel = false;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $term = true;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $characters;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $errors;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $hits;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $seconds;

    /**
     * @ORM\Column(length=120, nullable=true)
     */
    private $process;

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
    public function getDt()
    {
        return $this->cpf;
    }

    /**
     * @param mixed $dt
     */
    public function setDt($dt): void
    {
        $this->dt = $dt;
    }
    
    /**
     * @return mixed
     */
    public function getTpm()
    {
        return $this->tpm;
    }
    
    /**
     * @param mixed $tpm
     */
    public function setTpm($tpm): void
    {
        $this->tpm = $tpm;
    }
    
    /**
     * @return mixed
     */
    public function getPrecisao()
    {
        return $this->precisao;
    }
    
    /**
     * @param mixed $precisao
     */
    public function setPrecisao($precisao): void
    {
        $this->precisao = $precisao;
    }
    
    /**
     * @return mixed
     */
    public function getInicio()
    {
        return $this->inicio;
    }
    
    /**
     * @param mixed $inicio
     */
    public function setInicio($inicio): void
    {
        $this->inicio = $inicio;
    }
    
    /**
     * @return mixed
     */
    public function getTermino()
    {
        return $this->termino;
    }

    /**
     * @param mixed $termino
     */
    public function setTermino($termino): void
    {
        $this->termino = $termino;
    }

    /**
     * @return mixed
     */
    public function getCandidate()
    {
        return $this->candidate;
    }

    /**
     * @param mixed $justify
     */
    public function setCandidate($candidate): void
    {
        $this->candidate = $candidate;
    }

    /**
     * @return mixed
     */
    public function getJustify()
    {
        return $this->justify;
    }

    /**
     * @param mixed $justify
     */
    public function setJustify($justify): void
    {
        $this->justify = $justify;
    }

    /**
     * @return mixed
     */
    public function getCancel()
    {
        return $this->cancel;
    }

    /**
     * @param mixed $cancel
     */
    public function setCancel($cancel): void
    {
        $this->cancel = $cancel;
    }

    /**
     * @return mixed
     */
    public function getCharacters()
    {
        return $this->characters;
    }

    /**
     * @param mixed $characters
     */
    public function setCharacters($characters): void
    {
        $this->characters = $characters;
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param mixed $errors
     */
    public function setErrors($errors): void
    {
        $this->errors = $errors;
    }

    /**
     * @return mixed
     */
    public function getHits()
    {
        return $this->hits;
    }

    /**
     * @param mixed $hits
     */
    public function setHits($hits): void
    {
        $this->hits = $hits;
    }

    /**
     * @return mixed
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * @param mixed $term
     */
    public function setTerm($term): void
    {
        $this->term = $term;
    }

    /**
     * @return mixed
     */
    public function getSeconds()
    {
        return $this->seconds;
    }

    /**
     * @param mixed $seconds
     */
    public function setSeconds($seconds): void
    {
        $this->seconds = $seconds;
    }

    /**
     * @return mixed
     */
    public function getTpmp()
    {
        return $this->tpmp;
    }

    /**
     * @param mixed $tpmp
     */
    public function setTpmp($tpmp): void
    {
        $this->tpmp = $tpmp;
    }

    /**
     * @return mixed
     */
    public function getProcess()
    {
        return $this->process;
    }

    /**
     * @param mixed $process
     */
    public function setProcess($process): void
    {
        $this->process = $process;
    }


    /**
     * @return \Datetime
     */
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }
    
}
