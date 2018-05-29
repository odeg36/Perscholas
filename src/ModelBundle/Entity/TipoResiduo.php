<?php

namespace ModelBundle\Entity;

/**
 * TipoResiduo
 */
class TipoResiduo {

    public function __toString() {
        return $this->getCodigo() ? $this->getNombre() . " - " . $this->getCodigo() : "";
    }

    public function getDensidades() {
        $densidades = array();
        foreach ($this->getResiduos() as $residuo) {
            $densidades[] = $residuo->getDensidad();
        }
        return $densidades;
    }
    
    /**
     * @var string
     */
    private $codigo;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $color;

    /**
     * @var boolean
     */
    private $usa_contenedor;

    /**
     * @var boolean
     */
    private $usa_volqueta;

    /**
     * @var boolean
     */
    private $validar_disposicion;

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
    private $residuos;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $tipos_residuos_transporte;

    /**
     * @var \ModelBundle\Entity\Disposicion
     */
    private $disposicion;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->residuos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tipos_residuos_transporte = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     *
     * @return TipoResiduo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return TipoResiduo
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
     * Set slug
     *
     * @param string $slug
     *
     * @return TipoResiduo
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return TipoResiduo
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set usaContenedor
     *
     * @param boolean $usaContenedor
     *
     * @return TipoResiduo
     */
    public function setUsaContenedor($usaContenedor)
    {
        $this->usa_contenedor = $usaContenedor;

        return $this;
    }

    /**
     * Get usaContenedor
     *
     * @return boolean
     */
    public function getUsaContenedor()
    {
        return $this->usa_contenedor;
    }

    /**
     * Set usaVolqueta
     *
     * @param boolean $usaVolqueta
     *
     * @return TipoResiduo
     */
    public function setUsaVolqueta($usaVolqueta)
    {
        $this->usa_volqueta = $usaVolqueta;

        return $this;
    }

    /**
     * Get usaVolqueta
     *
     * @return boolean
     */
    public function getUsaVolqueta()
    {
        return $this->usa_volqueta;
    }

    /**
     * Set validarDisposicion
     *
     * @param boolean $validarDisposicion
     *
     * @return TipoResiduo
     */
    public function setValidarDisposicion($validarDisposicion)
    {
        $this->validar_disposicion = $validarDisposicion;

        return $this;
    }

    /**
     * Get validarDisposicion
     *
     * @return boolean
     */
    public function getValidarDisposicion()
    {
        return $this->validar_disposicion;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return TipoResiduo
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
     * @return TipoResiduo
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
     * Add residuo
     *
     * @param \ModelBundle\Entity\Residuo $residuo
     *
     * @return TipoResiduo
     */
    public function addResiduo(\ModelBundle\Entity\Residuo $residuo)
    {
        $this->residuos[] = $residuo;

        return $this;
    }

    /**
     * Remove residuo
     *
     * @param \ModelBundle\Entity\Residuo $residuo
     */
    public function removeResiduo(\ModelBundle\Entity\Residuo $residuo)
    {
        $this->residuos->removeElement($residuo);
    }

    /**
     * Get residuos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResiduos()
    {
        return $this->residuos;
    }

    /**
     * Add tiposResiduosTransporte
     *
     * @param \ModelBundle\Entity\TipoResiduoTransporte $tiposResiduosTransporte
     *
     * @return TipoResiduo
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
     * Set disposicion
     *
     * @param \ModelBundle\Entity\Disposicion $disposicion
     *
     * @return TipoResiduo
     */
    public function setDisposicion(\ModelBundle\Entity\Disposicion $disposicion)
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
     * @var \ModelBundle\Entity\EmpresaRecolectoraResiduos
     */
    private $empresa_recolectora_residuos;


    /**
     * Set empresaRecolectoraResiduos
     *
     * @param \ModelBundle\Entity\EmpresaRecolectoraResiduos $empresaRecolectoraResiduos
     *
     * @return TipoResiduo
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
    /**
     * @var boolean
     */
    private $reciclabe;


    /**
     * Set reciclabe
     *
     * @param boolean $reciclabe
     *
     * @return TipoResiduo
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
}
