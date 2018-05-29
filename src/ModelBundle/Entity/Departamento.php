<?php

namespace ModelBundle\Entity;

/**
 * Departamento
 */
class Departamento {

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
    private $municipios;

    /**
     * Constructor
     */
    public function __construct() {
        $this->municipios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Departamento
     */
    public function setNombre($nombre) {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Add municipio
     *
     * @param \ModelBundle\Entity\Municipio $municipio
     *
     * @return Departamento
     */
    public function addMunicipio(\ModelBundle\Entity\Municipio $municipio) {
        $this->municipios[] = $municipio;

        return $this;
    }

    /**
     * Remove municipio
     *
     * @param \ModelBundle\Entity\Municipio $municipio
     */
    public function removeMunicipio(\ModelBundle\Entity\Municipio $municipio) {
        $this->municipios->removeElement($municipio);
    }

    /**
     * Get municipios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMunicipios() {
        return $this->municipios;
    }

    /**
     * @var \ModelBundle\Entity\Pais
     */
    private $pais;


    /**
     * Set pais
     *
     * @param \ModelBundle\Entity\Pais $pais
     *
     * @return Departamento
     */
    public function setPais(\ModelBundle\Entity\Pais $pais)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return \ModelBundle\Entity\Pais
     */
    public function getPais()
    {
        return $this->pais;
    }
}
