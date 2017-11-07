<?php
/**
 * Created by PhpStorm.
 * User: thalesmartins
 * Date: 06/11/2017
 * Time: 13:16
 */

namespace App\Entity;


use JsonSerializable;

class Endereco implements JsonSerializable
{
    /**
     * @ORM\id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\id
     * @ORM\Column(type="integer")
     */
    private $cliente_id;

    /**
     * @ORM\Column(name="cep", type="string")
     */
    private $cep;
    /**
     * @ORM\Column(name="logradouro", type="string")
     */
    private $logradouro;
    /**
     * @ORM\Column(name="cidade", type="string")
     */
    private $cidade;
    /**
     * @ORM\Column(name="estado", type="string")
     */
    private $estado;

    /**
     * Muitos endereços tem um cliente.
     * @ManyToOne(targetEntity="Cliente", inversedBy="enderecos")
     * @JoinColumn(name="cliente_id", referencedColumnName="id")
     */
    private $cliente;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Endereco
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClienteId()
    {
        return $this->cliente_id;
    }

    /**
     * @param mixed $cliente_id
     * @return Endereco
     */
    public function setClienteId($cliente_id)
    {
        $this->cliente_id = $cliente_id;
        return $this;
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
     * @return Endereco
     */
    public function setCep($cep)
    {
        $this->cep = $cep;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLogradouro()
    {
        return $this->logradouro;
    }

    /**
     * @param mixed $logradouro
     * @return Endereco
     */
    public function setLogradouro($logradouro)
    {
        $this->logradouro = $logradouro;
        return $this;
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
     * @return Endereco
     */
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
        return $this;
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
     * @return Endereco
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
        return $this;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}