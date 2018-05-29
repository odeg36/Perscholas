<?php

namespace ModelBundle\Entity;

/**
 * Municipio
 */
class Municipio {

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
     * @var \ModelBundle\Entity\Departamento
     */
    private $departamento;

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Municipio
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
     * Set departamento
     *
     * @param \ModelBundle\Entity\Departamento $departamento
     *
     * @return Municipio
     */
    public function setDepartamento(\ModelBundle\Entity\Departamento $departamento) {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * Get departamento
     *
     * @return \ModelBundle\Entity\Departamento
     */
    public function getDepartamento() {
        return $this->departamento;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $centros_recoleccion;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->centros_recoleccion = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add centrosRecoleccion
     *
     * @param \ModelBundle\Entity\CentroRecoleccion $centrosRecoleccion
     *
     * @return Municipio
     */
    public function addCentrosRecoleccion(\ModelBundle\Entity\CentroRecoleccion $centrosRecoleccion)
    {
        $this->centros_recoleccion[] = $centrosRecoleccion;

        return $this;
    }

    /**
     * Remove centrosRecoleccion
     *
     * @param \ModelBundle\Entity\CentroRecoleccion $centrosRecoleccion
     */
    public function removeCentrosRecoleccion(\ModelBundle\Entity\CentroRecoleccion $centrosRecoleccion)
    {
        $this->centros_recoleccion->removeElement($centrosRecoleccion);
    }

    /**
     * Get centrosRecoleccion
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCentrosRecoleccion()
    {
        return $this->centros_recoleccion;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $clientes;


    /**
     * Add cliente
     *
     * @param \ModelBundle\Entity\Cliente $cliente
     *
     * @return Municipio
     */
    public function addCliente(\ModelBundle\Entity\Cliente $cliente)
    {
        $this->clientes[] = $cliente;

        return $this;
    }

    /**
     * Remove cliente
     *
     * @param \ModelBundle\Entity\Cliente $cliente
     */
    public function removeCliente(\ModelBundle\Entity\Cliente $cliente)
    {
        $this->clientes->removeElement($cliente);
    }

    /**
     * Get clientes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClientes()
    {
        return $this->clientes;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $zonas;


    /**
     * Add zona
     *
     * @param \ModelBundle\Entity\Zona $zona
     *
     * @return Municipio
     */
    public function addZona(\ModelBundle\Entity\Zona $zona)
    {
        $this->zonas[] = $zona;

        return $this;
    }

    /**
     * Remove zona
     *
     * @param \ModelBundle\Entity\Zona $zona
     */
    public function removeZona(\ModelBundle\Entity\Zona $zona)
    {
        $this->zonas->removeElement($zona);
    }

    /**
     * Get zonas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getZonas()
    {
        return $this->zonas;
    }
}
