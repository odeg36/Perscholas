<?php

namespace ModelBundle\Entity;

/**
 * Residuo
 */
class Residuo {

//--------------------------------- Modify -------------------------------------
//------------------------------------------------------------------------------
    public function __toString() {
        return $this->getCodigo() ? $this->getNombre() . " - " . $this->getCodigo() : "";
    }

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
      /**
     * @var string
     */
    private $codigo;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var float
     */
    private $densidad;

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
    private $residuos_recoleccion;

    /**
     * @var \ModelBundle\Entity\TipoResiduo
     */
    private $tipo_residuo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->residuos_recoleccion = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     *
     * @return Residuo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Residuo
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
     * @return Residuo
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
     * Set densidad
     *
     * @param float $densidad
     *
     * @return Residuo
     */
    public function setDensidad($densidad)
    {
        $this->densidad = $densidad;

        return $this;
    }

    /**
     * Get densidad
     *
     * @return float
     */
    public function getDensidad()
    {
        return $this->densidad;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Residuo
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
     * @return Residuo
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
     * Add residuosRecoleccion
     *
     * @param \ModelBundle\Entity\ResiduoRecoleccion $residuosRecoleccion
     *
     * @return Residuo
     */
    public function addResiduosRecoleccion(\ModelBundle\Entity\ResiduoRecoleccion $residuosRecoleccion)
    {
        $this->residuos_recoleccion[] = $residuosRecoleccion;

        return $this;
    }

    /**
     * Remove residuosRecoleccion
     *
     * @param \ModelBundle\Entity\ResiduoRecoleccion $residuosRecoleccion
     */
    public function removeResiduosRecoleccion(\ModelBundle\Entity\ResiduoRecoleccion $residuosRecoleccion)
    {
        $this->residuos_recoleccion->removeElement($residuosRecoleccion);
    }

    /**
     * Get residuosRecoleccion
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResiduosRecoleccion()
    {
        return $this->residuos_recoleccion;
    }

    /**
     * Set tipoResiduo
     *
     * @param \ModelBundle\Entity\TipoResiduo $tipoResiduo
     *
     * @return Residuo
     */
    public function setTipoResiduo(\ModelBundle\Entity\TipoResiduo $tipoResiduo)
    {
        $this->tipo_residuo = $tipoResiduo;

        return $this;
    }

    /**
     * Get tipoResiduo
     *
     * @return \ModelBundle\Entity\TipoResiduo
     */
    public function getTipoResiduo()
    {
        return $this->tipo_residuo;
    }
}
