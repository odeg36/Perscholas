<?php

namespace ModelBundle\Entity;

/**
 * Contenedor
 */
class Contenedor
{
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
     * @var float
     */
    private $volumen;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $recoleccion_contenedor;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->recoleccion_contenedor = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Contenedor
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
     * Set volumen
     *
     * @param float $volumen
     *
     * @return Contenedor
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add recoleccionContenedor
     *
     * @param \ModelBundle\Entity\RecoleccionContenedor $recoleccionContenedor
     *
     * @return Contenedor
     */
    public function addRecoleccionContenedor(\ModelBundle\Entity\RecoleccionContenedor $recoleccionContenedor)
    {
        $this->recoleccion_contenedor[] = $recoleccionContenedor;

        return $this;
    }

    /**
     * Remove recoleccionContenedor
     *
     * @param \ModelBundle\Entity\RecoleccionContenedor $recoleccionContenedor
     */
    public function removeRecoleccionContenedor(\ModelBundle\Entity\RecoleccionContenedor $recoleccionContenedor)
    {
        $this->recoleccion_contenedor->removeElement($recoleccionContenedor);
    }

    /**
     * Get recoleccionContenedor
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecoleccionContenedor()
    {
        return $this->recoleccion_contenedor;
    }
}
