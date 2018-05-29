<?php

namespace ModelBundle\Entity;

/**
 * Facturacion
 */
class Facturacion {

//--------------------------------- Modify -------------------------------------
//------------------------------------------------------------------------------
    public function __toString() {
        return $this->getId() ? (string) $this->getId() : '';
    }

    public function getFactura() {
        if ($this->factura) {
            return "/" . $this->getUploadDirTransporte() . '/' . $this->factura;
        } else {
            return '';
        }
    }

    static $UPLOAD_DIR_TRANSPORTE = "uploads/facturas";

    protected function getUploadDirTransporte() {
        return self::$UPLOAD_DIR_TRANSPORTE;
    }

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
    /**
     * @var float
     */
    private $valor_a_pagar;

    /**
     * @var string
     */
    private $factura;

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
     * Set valorAPagar
     *
     * @param float $valorAPagar
     *
     * @return Facturacion
     */
    public function setValorAPagar($valorAPagar) {
        $this->valor_a_pagar = $valorAPagar;

        return $this;
    }

    /**
     * Get valorAPagar
     *
     * @return float
     */
    public function getValorAPagar() {
        return $this->valor_a_pagar;
    }

    /**
     * Set factura
     *
     * @param string $factura
     *
     * @return Facturacion
     */
    public function setFactura($factura) {
        $this->factura = $factura;

        return $this;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Facturacion
     */
    public function setFechaCreacion($fechaCreacion) {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime
     */
    public function getFechaCreacion() {
        return $this->fechaCreacion;
    }

    /**
     * Set fechaActualizacion
     *
     * @param \DateTime $fechaActualizacion
     *
     * @return Facturacion
     */
    public function setFechaActualizacion($fechaActualizacion) {
        $this->fechaActualizacion = $fechaActualizacion;

        return $this;
    }

    /**
     * Get fechaActualizacion
     *
     * @return \DateTime
     */
    public function getFechaActualizacion() {
        return $this->fechaActualizacion;
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
     * Set cliente
     *
     * @param \ModelBundle\Entity\Cliente $cliente
     *
     * @return Facturacion
     */
    public function setCliente(\ModelBundle\Entity\Cliente $cliente) {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \ModelBundle\Entity\Cliente
     */
    public function getCliente() {
        return $this->cliente;
    }

}
