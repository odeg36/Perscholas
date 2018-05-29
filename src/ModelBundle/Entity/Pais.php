<?php

namespace ModelBundle\Entity;

/**
 * Pais
 */
class Pais {

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
    private $departamentos;

    /**
     * Constructor
     */
    public function __construct() {
        $this->departamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Pais
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
     * Add departamento
     *
     * @param \ModelBundle\Entity\Departamento $departamento
     *
     * @return Pais
     */
    public function addDepartamento(\ModelBundle\Entity\Departamento $departamento) {
        $this->departamentos[] = $departamento;

        return $this;
    }

    /**
     * Remove departamento
     *
     * @param \ModelBundle\Entity\Departamento $departamento
     */
    public function removeDepartamento(\ModelBundle\Entity\Departamento $departamento) {
        $this->departamentos->removeElement($departamento);
    }

    /**
     * Get departamentos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDepartamentos() {
        return $this->departamentos;
    }

}
