<?php

namespace ModelBundle\Entity;

/**
 * TipoCapacitacion
 */
class TipoCapacitacion {
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
    private $capacitaciones;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->capacitaciones = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return TipoCapacitacion
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
     * @return TipoCapacitacion
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
     * @return TipoCapacitacion
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
     * @return TipoCapacitacion
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
     * Add capacitacione
     *
     * @param \ModelBundle\Entity\Capacitacion $capacitacione
     *
     * @return TipoCapacitacion
     */
    public function addCapacitacione(\ModelBundle\Entity\Capacitacion $capacitacione)
    {
        $this->capacitaciones[] = $capacitacione;

        return $this;
    }

    /**
     * Remove capacitacione
     *
     * @param \ModelBundle\Entity\Capacitacion $capacitacione
     */
    public function removeCapacitacione(\ModelBundle\Entity\Capacitacion $capacitacione)
    {
        $this->capacitaciones->removeElement($capacitacione);
    }

    /**
     * Get capacitaciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCapacitaciones()
    {
        return $this->capacitaciones;
    }
}
