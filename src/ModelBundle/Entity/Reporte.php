<?php

namespace ModelBundle\Entity;

/**
 * Reporte
 */
class Reporte {
//--------------------------------- Modify -------------------------------------
//------------------------------------------------------------------------------
    public function __toString() {
        return $this->getId() ? (string)$this->getId() : '';
    }
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
    /**
     * @var string
     */
    private $consultaReporte;

    /**
     * @var \DateTime
     */
    private $fechaCreacion;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \ModelBundle\Entity\User
     */
    private $usuario;


    /**
     * Set consultaReporte
     *
     * @param string $consultaReporte
     *
     * @return Reporte
     */
    public function setConsultaReporte($consultaReporte)
    {
        $this->consultaReporte = $consultaReporte;

        return $this;
    }

    /**
     * Get consultaReporte
     *
     * @return string
     */
    public function getConsultaReporte()
    {
        return $this->consultaReporte;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Reporte
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set usuario
     *
     * @param \ModelBundle\Entity\User $usuario
     *
     * @return Reporte
     */
    public function setUsuario(\ModelBundle\Entity\User $usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \ModelBundle\Entity\User
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
