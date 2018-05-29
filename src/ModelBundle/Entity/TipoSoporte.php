<?php

namespace ModelBundle\Entity;

/**
 * TipoSoporte
 */
class TipoSoporte {
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
    private $soportes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->soportes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return TipoSoporte
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
     * @return TipoSoporte
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
     * @return TipoSoporte
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
     * @return TipoSoporte
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
     * Add soporte
     *
     * @param \ModelBundle\Entity\Soporte $soporte
     *
     * @return TipoSoporte
     */
    public function addSoporte(\ModelBundle\Entity\Soporte $soporte)
    {
        $this->soportes[] = $soporte;

        return $this;
    }

    /**
     * Remove soporte
     *
     * @param \ModelBundle\Entity\Soporte $soporte
     */
    public function removeSoporte(\ModelBundle\Entity\Soporte $soporte)
    {
        $this->soportes->removeElement($soporte);
    }

    /**
     * Get soportes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSoportes()
    {
        return $this->soportes;
    }
}
