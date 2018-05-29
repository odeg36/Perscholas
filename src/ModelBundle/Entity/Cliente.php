<?php

namespace ModelBundle\Entity;

/**
 * Cliente
 */
class Cliente {

//--------------------------------- Modify -------------------------------------
//------------------------------------------------------------------------------
    public function __toString() {
        return $this->getNombre() ? (string) $this->getNombre() : '';
    }

    public function getGestores() {
        $usuario = new User();
        $array_usuarios = array();
        foreach ($this->getUsuarios() as $usuario) {
            if ($usuario->hasRole("ROLE_GESTOR")) {
                $array_usuarios[] = $usuario;
            }
        }
        return $array_usuarios;
    }

//------------------------------------------------------------------------------
    

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $direccion;

    /**
     * @var string
     */
    private $indicativo;

    /**
     * @var string
     */
    private $telefono;

    /**
     * @var string
     */
    private $celular;

    /**
     * @var string
     */
    private $nit;

    /**
     * @var string
     */
    private $correo_electronico;

    /**
     * @var string
     */
    private $nombre_replegal;

    /**
     * @var string
     */
    private $cedula_replegal;

    /**
     * @var string
     */
    private $observaciones;

    /**
     * @var boolean
     */
    private $exentopago;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var float
     */
    private $valor_a_pagar;

    /**
     * @var \DateTime
     */
    private $fecha_inicio_facturacion;

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
    private $usuarios;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $centros_recoleccion;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $soportes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $facturas;

    /**
     * @var \ModelBundle\Entity\TipoCliente
     */
    private $tipoCliente;

    /**
     * @var \ModelBundle\Entity\Municipio
     */
    private $municipio;

    /**
     * @var \ModelBundle\Entity\Zona
     */
    private $zona;

    /**
     * @var \ModelBundle\Entity\Estrato
     */
    private $estrato;

    /**
     * @var \ModelBundle\Entity\FormaPago
     */
    private $forma_pago;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->usuarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->centros_recoleccion = new \Doctrine\Common\Collections\ArrayCollection();
        $this->soportes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->facturas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Cliente
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
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Cliente
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set indicativo
     *
     * @param string $indicativo
     *
     * @return Cliente
     */
    public function setIndicativo($indicativo)
    {
        $this->indicativo = $indicativo;

        return $this;
    }

    /**
     * Get indicativo
     *
     * @return string
     */
    public function getIndicativo()
    {
        return $this->indicativo;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Cliente
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set celular
     *
     * @param string $celular
     *
     * @return Cliente
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get celular
     *
     * @return string
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * Set nit
     *
     * @param string $nit
     *
     * @return Cliente
     */
    public function setNit($nit)
    {
        $this->nit = $nit;

        return $this;
    }

    /**
     * Get nit
     *
     * @return string
     */
    public function getNit()
    {
        return $this->nit;
    }

    /**
     * Set correoElectronico
     *
     * @param string $correoElectronico
     *
     * @return Cliente
     */
    public function setCorreoElectronico($correoElectronico)
    {
        $this->correo_electronico = $correoElectronico;

        return $this;
    }

    /**
     * Get correoElectronico
     *
     * @return string
     */
    public function getCorreoElectronico()
    {
        return $this->correo_electronico;
    }

    /**
     * Set nombreReplegal
     *
     * @param string $nombreReplegal
     *
     * @return Cliente
     */
    public function setNombreReplegal($nombreReplegal)
    {
        $this->nombre_replegal = $nombreReplegal;

        return $this;
    }

    /**
     * Get nombreReplegal
     *
     * @return string
     */
    public function getNombreReplegal()
    {
        return $this->nombre_replegal;
    }

    /**
     * Set cedulaReplegal
     *
     * @param string $cedulaReplegal
     *
     * @return Cliente
     */
    public function setCedulaReplegal($cedulaReplegal)
    {
        $this->cedula_replegal = $cedulaReplegal;

        return $this;
    }

    /**
     * Get cedulaReplegal
     *
     * @return string
     */
    public function getCedulaReplegal()
    {
        return $this->cedula_replegal;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return Cliente
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set exentopago
     *
     * @param boolean $exentopago
     *
     * @return Cliente
     */
    public function setExentopago($exentopago)
    {
        $this->exentopago = $exentopago;

        return $this;
    }

    /**
     * Get exentopago
     *
     * @return boolean
     */
    public function getExentopago()
    {
        return $this->exentopago;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Cliente
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
     * Set valorAPagar
     *
     * @param float $valorAPagar
     *
     * @return Cliente
     */
    public function setValorAPagar($valorAPagar)
    {
        $this->valor_a_pagar = $valorAPagar;

        return $this;
    }

    /**
     * Get valorAPagar
     *
     * @return float
     */
    public function getValorAPagar()
    {
        return $this->valor_a_pagar;
    }

    /**
     * Set fechaInicioFacturacion
     *
     * @param \DateTime $fechaInicioFacturacion
     *
     * @return Cliente
     */
    public function setFechaInicioFacturacion($fechaInicioFacturacion)
    {
        $this->fecha_inicio_facturacion = $fechaInicioFacturacion;

        return $this;
    }

    /**
     * Get fechaInicioFacturacion
     *
     * @return \DateTime
     */
    public function getFechaInicioFacturacion()
    {
        return $this->fecha_inicio_facturacion;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Cliente
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
     * @return Cliente
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
     * Add usuario
     *
     * @param \ModelBundle\Entity\User $usuario
     *
     * @return Cliente
     */
    public function addUsuario(\ModelBundle\Entity\User $usuario)
    {
        $this->usuarios[] = $usuario;

        return $this;
    }

    /**
     * Remove usuario
     *
     * @param \ModelBundle\Entity\User $usuario
     */
    public function removeUsuario(\ModelBundle\Entity\User $usuario)
    {
        $this->usuarios->removeElement($usuario);
    }

    /**
     * Get usuarios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }

    /**
     * Add centrosRecoleccion
     *
     * @param \ModelBundle\Entity\CentroRecoleccion $centrosRecoleccion
     *
     * @return Cliente
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
     * Add soporte
     *
     * @param \ModelBundle\Entity\Soporte $soporte
     *
     * @return Cliente
     */
    public function addSoporte(\ModelBundle\Entity\Soporte $soporte)
    {
        $this->soportes[] = $soporte;

        return $this;
    }

    /**
     * Remove soporte
     *
     * @param \ModelBundle\Entity\Soporte $soporte
     */
    public function removeSoporte(\ModelBundle\Entity\Soporte $soporte)
    {
        $this->soportes->removeElement($soporte);
    }

    /**
     * Get soportes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSoportes()
    {
        return $this->soportes;
    }

    /**
     * Add factura
     *
     * @param \ModelBundle\Entity\Facturacion $factura
     *
     * @return Cliente
     */
    public function addFactura(\ModelBundle\Entity\Facturacion $factura)
    {
        $this->facturas[] = $factura;

        return $this;
    }

    /**
     * Remove factura
     *
     * @param \ModelBundle\Entity\Facturacion $factura
     */
    public function removeFactura(\ModelBundle\Entity\Facturacion $factura)
    {
        $this->facturas->removeElement($factura);
    }

    /**
     * Get facturas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFacturas()
    {
        return $this->facturas;
    }

    /**
     * Set tipoCliente
     *
     * @param \ModelBundle\Entity\TipoCliente $tipoCliente
     *
     * @return Cliente
     */
    public function setTipoCliente(\ModelBundle\Entity\TipoCliente $tipoCliente)
    {
        $this->tipoCliente = $tipoCliente;

        return $this;
    }

    /**
     * Get tipoCliente
     *
     * @return \ModelBundle\Entity\TipoCliente
     */
    public function getTipoCliente()
    {
        return $this->tipoCliente;
    }

    /**
     * Set municipio
     *
     * @param \ModelBundle\Entity\Municipio $municipio
     *
     * @return Cliente
     */
    public function setMunicipio(\ModelBundle\Entity\Municipio $municipio = null)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return \ModelBundle\Entity\Municipio
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * Set zona
     *
     * @param \ModelBundle\Entity\Zona $zona
     *
     * @return Cliente
     */
    public function setZona(\ModelBundle\Entity\Zona $zona = null)
    {
        $this->zona = $zona;

        return $this;
    }

    /**
     * Get zona
     *
     * @return \ModelBundle\Entity\Zona
     */
    public function getZona()
    {
        return $this->zona;
    }

    /**
     * Set estrato
     *
     * @param \ModelBundle\Entity\Estrato $estrato
     *
     * @return Cliente
     */
    public function setEstrato(\ModelBundle\Entity\Estrato $estrato)
    {
        $this->estrato = $estrato;

        return $this;
    }

    /**
     * Get estrato
     *
     * @return \ModelBundle\Entity\Estrato
     */
    public function getEstrato()
    {
        return $this->estrato;
    }

    /**
     * Set formaPago
     *
     * @param \ModelBundle\Entity\FormaPago $formaPago
     *
     * @return Cliente
     */
    public function setFormaPago(\ModelBundle\Entity\FormaPago $formaPago = null)
    {
        $this->forma_pago = $formaPago;

        return $this;
    }

    /**
     * Get formaPago
     *
     * @return \ModelBundle\Entity\FormaPago
     */
    public function getFormaPago()
    {
        return $this->forma_pago;
    }
}
