<?php

namespace ModelBundle\Entity;

/**
 * Programacion
 */
class Programacion {
    /*     * ****************** Modificaciones ***************** */

    public function __toString() {
        return $this->getCentroRecoleccion() ? $this->getCentroRecoleccion()->getCliente()->getNombre() : "";
    }

    /**
     * Get validada
     *
     * @return boolean
     */
    public function getValidada() {
        $tipoResiduo = new TipoResiduoTransporte();
        foreach ($this->getTiposResiduosTransporte() as $tipoResiduo) {
            if (!$tipoResiduo->getValidado()) {
                return false;
            }
        }
        return true;
    }

    /*     * ****************** FIN Modificaciones **************** */

        /**
     * @var string
     */
    private $observacion;

    /**
     * @var boolean
     */
    private $pesado_en_centro_recoleccion;

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
    private $tipos_residuos_transporte;

    /**
     * @var \ModelBundle\Entity\CentroRecoleccion
     */
    private $centro_recoleccion;

    /**
     * @var \ModelBundle\Entity\User
     */
    private $gestor_ambiental;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tipos_residuos_transporte = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     *
     * @return Programacion
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Set pesadoEnCentroRecoleccion
     *
     * @param boolean $pesadoEnCentroRecoleccion
     *
     * @return Programacion
     */
    public function setPesadoEnCentroRecoleccion($pesadoEnCentroRecoleccion)
    {
        $this->pesado_en_centro_recoleccion = $pesadoEnCentroRecoleccion;

        return $this;
    }

    /**
     * Get pesadoEnCentroRecoleccion
     *
     * @return boolean
     */
    public function getPesadoEnCentroRecoleccion()
    {
        return $this->pesado_en_centro_recoleccion;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Programacion
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
     * @return Programacion
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
     * Add tiposResiduosTransporte
     *
     * @param \ModelBundle\Entity\TipoResiduoTransporte $tiposResiduosTransporte
     *
     * @return Programacion
     */
    public function addTiposResiduosTransporte(\ModelBundle\Entity\TipoResiduoTransporte $tiposResiduosTransporte)
    {
        $this->tipos_residuos_transporte[] = $tiposResiduosTransporte;

        return $this;
    }

    /**
     * Remove tiposResiduosTransporte
     *
     * @param \ModelBundle\Entity\TipoResiduoTransporte $tiposResiduosTransporte
     */
    public function removeTiposResiduosTransporte(\ModelBundle\Entity\TipoResiduoTransporte $tiposResiduosTransporte)
    {
        $this->tipos_residuos_transporte->removeElement($tiposResiduosTransporte);
    }

    /**
     * Get tiposResiduosTransporte
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTiposResiduosTransporte()
    {
        return $this->tipos_residuos_transporte;
    }

    /**
     * Set centroRecoleccion
     *
     * @param \ModelBundle\Entity\CentroRecoleccion $centroRecoleccion
     *
     * @return Programacion
     */
    public function setCentroRecoleccion(\ModelBundle\Entity\CentroRecoleccion $centroRecoleccion)
    {
        $this->centro_recoleccion = $centroRecoleccion;

        return $this;
    }

    /**
     * Get centroRecoleccion
     *
     * @return \ModelBundle\Entity\CentroRecoleccion
     */
    public function getCentroRecoleccion()
    {
        return $this->centro_recoleccion;
    }

    /**
     * Set gestorAmbiental
     *
     * @param \ModelBundle\Entity\User $gestorAmbiental
     *
     * @return Programacion
     */
    public function setGestorAmbiental(\ModelBundle\Entity\User $gestorAmbiental)
    {
        $this->gestor_ambiental = $gestorAmbiental;

        return $this;
    }

    /**
     * Get gestorAmbiental
     *
     * @return \ModelBundle\Entity\User
     */
    public function getGestorAmbiental()
    {
        return $this->gestor_ambiental;
    }
}
