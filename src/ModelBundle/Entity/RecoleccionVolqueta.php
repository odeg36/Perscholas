<?php

namespace ModelBundle\Entity;

/**
 * RecoleccionVolqueta
 */
class RecoleccionVolqueta
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
     * @var \ModelBundle\Entity\Volqueta
     */
    private $volqueta;


    /**
     * Set volumen
     *
     * @param float $volumen
     *
     * @return RecoleccionVolqueta
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
     * @return RecoleccionVolqueta
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
     * @return RecoleccionVolqueta
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
     * @return RecoleccionVolqueta
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
     * @return RecoleccionVolqueta
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
     * Set volqueta
     *
     * @param \ModelBundle\Entity\Volqueta $volqueta
     *
     * @return RecoleccionVolqueta
     */
    public function setVolqueta(\ModelBundle\Entity\Volqueta $volqueta)
    {
        $this->volqueta = $volqueta;

        return $this;
    }

    /**
     * Get volqueta
     *
     * @return \ModelBundle\Entity\Volqueta
     */
    public function getVolqueta()
    {
        return $this->volqueta;
    }
}
