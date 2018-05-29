<?php

namespace ModelBundle\Entity;

/**
 * TipoCliente
 */
class TipoCliente {
//--------------------------------- Modify -------------------------------------
//------------------------------------------------------------------------------
    public function __toString() {
        return $this->getNombre() ? (string)$this->getNombre() : '';
    }
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var \DateTime
     */
    private $fechaCreacion;

    /**
     * @var \DateTime
     */
    private $fechaActualizacion;

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
    public function __construct()
    {
        $this->clientes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return TipoCliente
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return TipoCliente
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return TipoCliente
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Set fechaActualizacion
     *
     * @param \DateTime $fechaActualizacion
     *
     * @return TipoCliente
     */
    public function setFechaActualizacion($fechaActualizacion)
    {
        $this->fechaActualizacion = $fechaActualizacion;

        return $this;
    }

    /**
     * Get fechaActualizacion
     *
     * @return \DateTime
     */
    public function getFechaActualizacion()
    {
        return $this->fechaActualizacion;
    }

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
     * Add cliente
     *
     * @param \ModelBundle\Entity\Cliente $cliente
     *
     * @return TipoCliente
     */
    public function addCliente(\ModelBundle\Entity\Cliente $cliente)
    {
        $this->clientes[] = $cliente;

        return $this;
    }

    /**
     * Remove cliente
     *
     * @param \ModelBundle\Entity\Cliente $cliente
     */
    public function removeCliente(\ModelBundle\Entity\Cliente $cliente)
    {
        $this->clientes->removeElement($cliente);
    }

    /**
     * Get clientes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClientes()
    {
        return $this->clientes;
    }
}
