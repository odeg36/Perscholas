<?php

namespace ModelBundle\Entity;

/**
 * ResiduoRecoleccion
 */
class ResiduoRecoleccion {
    /**
     * @var boolean
     */
    private $reciclabe;

    /**
     * @var float
     */
    private $densidad;

    /**
     * @var float
     */
    private $peso;

    /**
     * @var float
     */
    private $precio;

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
     * @var \ModelBundle\Entity\Recoleccion
     */
    private $recoleccion;

    /**
     * @var \ModelBundle\Entity\Residuo
     */
    private $residuo;

    /**
     * @var \ModelBundle\Entity\Disposicion
     */
    private $disposicion;

    /**
     * @var \ModelBundle\Entity\EmpresaRecolectoraResiduos
     */
    private $empresa_recolectora_residuos;


    /**
     * Set reciclabe
     *
     * @param boolean $reciclabe
     *
     * @return ResiduoRecoleccion
     */
    public function setReciclabe($reciclabe)
    {
        $this->reciclabe = $reciclabe;

        return $this;
    }

    /**
     * Get reciclabe
     *
     * @return boolean
     */
    public function getReciclabe()
    {
        return $this->reciclabe;
    }

    /**
     * Set densidad
     *
     * @param float $densidad
     *
     * @return ResiduoRecoleccion
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
     * Set peso
     *
     * @param float $peso
     *
     * @return ResiduoRecoleccion
     */
    public function setPeso($peso)
    {
        $this->peso = $peso;

        return $this;
    }

    /**
     * Get peso
     *
     * @return float
     */
    public function getPeso()
    {
        return $this->peso;
    }

    /**
     * Set precio
     *
     * @param float $precio
     *
     * @return ResiduoRecoleccion
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return float
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return ResiduoRecoleccion
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
     * @return ResiduoRecoleccion
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
     * Set recoleccion
     *
     * @param \ModelBundle\Entity\Recoleccion $recoleccion
     *
     * @return ResiduoRecoleccion
     */
    public function setRecoleccion(\ModelBundle\Entity\Recoleccion $recoleccion)
    {
        $this->recoleccion = $recoleccion;

        return $this;
    }

    /**
     * Get recoleccion
     *
     * @return \ModelBundle\Entity\Recoleccion
     */
    public function getRecoleccion()
    {
        return $this->recoleccion;
    }

    /**
     * Set residuo
     *
     * @param \ModelBundle\Entity\Residuo $residuo
     *
     * @return ResiduoRecoleccion
     */
    public function setResiduo(\ModelBundle\Entity\Residuo $residuo)
    {
        $this->residuo = $residuo;

        return $this;
    }

    /**
     * Get residuo
     *
     * @return \ModelBundle\Entity\Residuo
     */
    public function getResiduo()
    {
        return $this->residuo;
    }

    /**
     * Set disposicion
     *
     * @param \ModelBundle\Entity\Disposicion $disposicion
     *
     * @return ResiduoRecoleccion
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

    /**
     * Set empresaRecolectoraResiduos
     *
     * @param \ModelBundle\Entity\EmpresaRecolectoraResiduos $empresaRecolectoraResiduos
     *
     * @return ResiduoRecoleccion
     */
    public function setEmpresaRecolectoraResiduos(\ModelBundle\Entity\EmpresaRecolectoraResiduos $empresaRecolectoraResiduos)
    {
        $this->empresa_recolectora_residuos = $empresaRecolectoraResiduos;

        return $this;
    }

    /**
     * Get empresaRecolectoraResiduos
     *
     * @return \ModelBundle\Entity\EmpresaRecolectoraResiduos
     */
    public function getEmpresaRecolectoraResiduos()
    {
        return $this->empresa_recolectora_residuos;
    }
}
