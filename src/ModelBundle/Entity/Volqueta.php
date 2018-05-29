<?php

namespace ModelBundle\Entity;

/**
 * Volqueta
 */
class Volqueta
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
     * @var integer
     */
    private $volumen;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $recoleccion_volqueta;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->recoleccion_volqueta = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Volqueta
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
     * @param integer $volumen
     *
     * @return Volqueta
     */
    public function setVolumen($volumen)
    {
        $this->volumen = $volumen;

        return $this;
    }

    /**
     * Get volumen
     *
     * @return integer
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
     * Add recoleccionVolquetum
     *
     * @param \ModelBundle\Entity\RecoleccionVolqueta $recoleccionVolquetum
     *
     * @return Volqueta
     */
    public function addRecoleccionVolquetum(\ModelBundle\Entity\RecoleccionVolqueta $recoleccionVolquetum)
    {
        $this->recoleccion_volqueta[] = $recoleccionVolquetum;

        return $this;
    }

    /**
     * Remove recoleccionVolquetum
     *
     * @param \ModelBundle\Entity\RecoleccionVolqueta $recoleccionVolquetum
     */
    public function removeRecoleccionVolquetum(\ModelBundle\Entity\RecoleccionVolqueta $recoleccionVolquetum)
    {
        $this->recoleccion_volqueta->removeElement($recoleccionVolquetum);
    }

    /**
     * Get recoleccionVolqueta
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecoleccionVolqueta()
    {
        return $this->recoleccion_volqueta;
    }
}
