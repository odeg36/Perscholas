<?php

namespace ModelBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * Soporte
 */
class Soporte {
//--------------------------------- Modify -------------------------------------
//------------------------------------------------------------------------------
    
    const SERVER_PATH_TO_IMAGE_FOLDER = '/uploads/soporte';
    
    public function __toString() {
        return $this->getId() ? (string)$this->getId() : '';
    }
    
    /**
     * @Assert\File()
     */
    private $archivoSoporte;
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
    
    /**
     * @var string
     */
    private $descripcion;

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
     * @var \ModelBundle\Entity\Cliente
     */
    private $cliente;

    /**
     * @var \ModelBundle\Entity\TipoSoporte
     */
    private $tipoSoporte;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Soporte
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set archivoSoporte
     *
     * @param string $archivoSoporte
     *
     * @return Soporte
     */
    public function setArchivoSoporte($archivoSoporte)
    {
        $this->archivoSoporte = $archivoSoporte;

        return $this;
    }

    /**
     * Get archivoSoporte
     *
     * @return string
     */
    public function getArchivoSoporte()
    {
        return $this->archivoSoporte;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Soporte
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
     * @return Soporte
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
     * Set cliente
     *
     * @param \ModelBundle\Entity\Cliente $cliente
     *
     * @return Soporte
     */
    public function setCliente(\ModelBundle\Entity\Cliente $cliente)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \ModelBundle\Entity\Cliente
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set tipoSoporte
     *
     * @param \ModelBundle\Entity\TipoSoporte $tipoSoporte
     *
     * @return Soporte
     */
    public function setTipoSoporte(\ModelBundle\Entity\TipoSoporte $tipoSoporte)
    {
        $this->tipoSoporte = $tipoSoporte;

        return $this;
    }

    /**
     * Get tipoSoporte
     *
     * @return \ModelBundle\Entity\TipoSoporte
     */
    public function getTipoSoporte()
    {
        return $this->tipoSoporte;
    }
}
