<?php

namespace ModelBundle\Entity;

/**
 * Disposicion
 */
class Disposicion {

//--------------------------------- Modify -------------------------------------
//------------------------------------------------------------------------------
    public function __toString() {
        return $this->getNombre() ? (string) $this->getNombre() : '';
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
    private $disposiciones;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $residuos_recoleccion;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $tipos_residuo;

    /**
     * @var \ModelBundle\Entity\Disposicion
     */
    private $disposicion;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->disposiciones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->residuos_recoleccion = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tipos_residuo = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Disposicion
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
     * @return Disposicion
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
     * @return Disposicion
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
     * @return Disposicion
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
     * Add disposicione
     *
     * @param \ModelBundle\Entity\Disposicion $disposicione
     *
     * @return Disposicion
     */
    public function addDisposicione(\ModelBundle\Entity\Disposicion $disposicione)
    {
        $this->disposiciones[] = $disposicione;

        return $this;
    }

    /**
     * Remove disposicione
     *
     * @param \ModelBundle\Entity\Disposicion $disposicione
     */
    public function removeDisposicione(\ModelBundle\Entity\Disposicion $disposicione)
    {
        $this->disposiciones->removeElement($disposicione);
    }

    /**
     * Get disposiciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDisposiciones()
    {
        return $this->disposiciones;
    }

    /**
     * Add residuosRecoleccion
     *
     * @param \ModelBundle\Entity\ResiduoRecoleccion $residuosRecoleccion
     *
     * @return Disposicion
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
     * Add tiposResiduo
     *
     * @param \ModelBundle\Entity\TipoResiduo $tiposResiduo
     *
     * @return Disposicion
     */
    public function addTiposResiduo(\ModelBundle\Entity\TipoResiduo $tiposResiduo)
    {
        $this->tipos_residuo[] = $tiposResiduo;

        return $this;
    }

    /**
     * Remove tiposResiduo
     *
     * @param \ModelBundle\Entity\TipoResiduo $tiposResiduo
     */
    public function removeTiposResiduo(\ModelBundle\Entity\TipoResiduo $tiposResiduo)
    {
        $this->tipos_residuo->removeElement($tiposResiduo);
    }

    /**
     * Get tiposResiduo
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTiposResiduo()
    {
        return $this->tipos_residuo;
    }

    /**
     * Set disposicion
     *
     * @param \ModelBundle\Entity\Disposicion $disposicion
     *
     * @return Disposicion
     */
    public function setDisposicion(\ModelBundle\Entity\Disposicion $disposicion = null)
    {
        $this->disposicion = $disposicion;

        return $this;
    }

    /**
     * Get disposicion
     *
     * @return \ModelBundle\Entity\Disposicion
     */
    public function getDisposicion()
    {
        return $this->disposicion;
    }
}
