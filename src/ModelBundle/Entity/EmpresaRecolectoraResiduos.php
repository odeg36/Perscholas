<?php

namespace ModelBundle\Entity;

/**
 * EmpresaRecolectoraResiduos
 */
class EmpresaRecolectoraResiduos {

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
    private $residuos_recoleccion;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->residuos_recoleccion = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return EmpresaRecolectoraResiduos
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
     * @return EmpresaRecolectoraResiduos
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
}
