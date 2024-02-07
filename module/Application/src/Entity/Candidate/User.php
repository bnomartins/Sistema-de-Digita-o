<?php

namespace Application\Entity\Candidate;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity,
 * @ORM\Table(schema="projects", name="user", options={"auto_increment": 5000, "collate"="utf8_swedish_ci", "charset"="utf8"})
 */
class User
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned" = true})
     * @ORM\SequenceGenerator(sequenceName="id", initialValue=5000)
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(length=14, nullable=true, unique=true)
     */
    private $cpf;

    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $senha;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $nivel;
    /**
     * @ORM\Column(length=120, nullable=true)
     */
    private $nome;

    /**
     * @ORM\Column(length=120, nullable=true)
     */
    private $social;

    /**
     * @ORM\Column(type="date", length=100, nullable=true)
     */
    private $nascimento;

    /**
     * @ORM\Column(length=100, nullable=true)
     */
    private $telefone;

    /**
     * @ORM\Column(length=120, nullable=true, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(length=100, nullable=true)
     */
    private $cep;

    /**
     * @ORM\Column(length=100, nullable=true)
     */
    private $endereco;

    /**
     * @ORM\Column(length=100, nullable=true)
     */
    private $bairro;

    /**
     * @ORM\Column(length=100, nullable=true)
     */
    private $cidade;

    /**
     * @ORM\Column(length=100, nullable=true)
     */
    private $estado;

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
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param mixed $cpf
     */
    public function setCpf($cpf): void
    {
        $this->cpf = $cpf;
    }

    /**
     * @return mixed
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * @param mixed $nivel
     */
    public function setNivel($nivel): void
    {
        $this->nivel = $nivel;
    }

    /**
     * @return mixed
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * @param mixed $senha
     */
    public function setSenha($senha): void
    {
        $this->senha = $senha;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $name
     */
    public function setNome($nome): void
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getSocial()
    {
        return $this->social;
    }

    /**
     * @param mixed $social
     */
    public function setSocial($social): void
    {
        $this->social = $social;
    }

    /**
     * @return mixed
     */
    public function getNascimento()
    {
        return $this->nascimento;
    }

    /**
     * @param mixed $nascimento
     */
    public function setNascimento($nascimento): void
    {
        $this->nascimento = $nascimento;
    }

    /**
     * @return mixed
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * @param mixed $telefone
     */
    public function setTelefone($telefone): void
    {
        $this->telefone = $telefone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * @param mixed $cep
     */
    public function setCep($cep): void
    {
        $this->cep = $cep;
    }

    /**
     * @return mixed
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * @param mixed $endereco
     */
    public function setEndereco($endereco): void
    {
        $this->endereco = $endereco;
    }

    /**
     * @return mixed
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * @param mixed $bairro
     */
    public function setBairro($bairro): void
    {
        $this->bairro = $bairro;
    }

    /**
     * @return mixed
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * @param mixed $cidade
     */
    public function setCidade($cidade): void
    {
        $this->cidade = $cidade;
    }

    /**
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed $estado
     */
    public function setEstado($estado): void
    {
        $this->estado = $estado;
    }

    /**
     * @return \Datetime
     */
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }
}
