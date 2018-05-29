<?php

namespace ModelBundle\Entity;

/**
 * Zona
 */
class Zona {

    public function __toString() {
        return $this->getNombre() ? $this->getNombre() : '';
    }

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $clientes;

    /**
     * Constructor
     */
    public function __construct() {
        $this->clientes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Zona
     */
    public function setNombre($nombre) {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Add cliente
     *
     * @param \ModelBundle\Entity\Cliente $cliente
     *
     * @return Zona
     */
    public function addCliente(\ModelBundle\Entity\Cliente $cliente) {
        $this->clientes[] = $cliente;

        return $this;
    }

    /**
     * Remove cliente
     *
     * @param \ModelBundle\Entity\Cliente $cliente
     */
    public function removeCliente(\ModelBundle\Entity\Cliente $cliente) {
        $this->clientes->removeElement($cliente);
    }

    /**
     * Get clientes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClientes() {
        return $this->clientes;
    }

    /**
     * @var \ModelBundle\Entity\Municipio
     */
    private $municipio;


    /**
     * Set municipio
     *
     * @param \ModelBundle\Entity\Municipio $municipio
     *
     * @return Zona
     */
    public function setMunicipio(\ModelBundle\Entity\Municipio $municipio)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return \ModelBundle\Entity\Municipio
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }
}
