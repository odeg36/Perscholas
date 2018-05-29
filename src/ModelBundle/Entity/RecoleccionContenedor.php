<?php

namespace ModelBundle\Entity;

/**
 * RecoleccionContenedor
 */
class RecoleccionContenedor
{
    /**
     * @var float
     */
    private $volumen;

    /**
     * @var integer
     */
    private $cantidad;

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
     * @var \ModelBundle\Entity\Recoleccion
     */
    private $recoleccion;

    /**
     * @var \ModelBundle\Entity\Contenedor
     */
    private $contenedor;


    /**
     * Set volumen
     *
     * @param float $volumen
     *
     * @return RecoleccionContenedor
     */
    public function setVolumen($volumen)
    {
        $this->volumen = $volumen;

        return $this;
    }

    /**
     * Get volumen
     *
     * @return float
     */
    public function getVolumen()
    {
        return $this->volumen;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return RecoleccionContenedor
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return RecoleccionContenedor
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
     * @return RecoleccionContenedor
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
     * Set recoleccion
     *
     * @param \ModelBundle\Entity\Recoleccion $recoleccion
     *
     * @return RecoleccionContenedor
     */
    public function setRecoleccion(\ModelBundle\Entity\Recoleccion $recoleccion = null)
    {
        $this->recoleccion = $recoleccion;

        return $this;
    }

    /**
     * Get recoleccion
     *
     * @return \ModelBundle\Entity\Recoleccion
     */
    public function getRecoleccion()
    {
        return $this->recoleccion;
    }

    /**
     * Set contenedor
     *
     * @param \ModelBundle\Entity\Contenedor $contenedor
     *
     * @return RecoleccionContenedor
     */
    public function setContenedor(\ModelBundle\Entity\Contenedor $contenedor)
    {
        $this->contenedor = $contenedor;

        return $this;
    }

    /**
     * Get contenedor
     *
     * @return \ModelBundle\Entity\Contenedor
     */
    public function getContenedor()
    {
        return $this->contenedor;
    }
}
