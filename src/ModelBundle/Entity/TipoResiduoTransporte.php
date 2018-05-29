<?php

namespace ModelBundle\Entity;

/**
 * TipoResiduoTransporte
 */
class TipoResiduoTransporte {

    public function __toString() {
        return $this->getTipoResiduo() ? $this->getTipoResiduo()->getNombre() . "" : '';
    }

    /* --------- Certificado disposicion ---------- */

    public function getCertificadoDisposicion() {
        if ($this->certificado_disposicion) {
            return "/" . $this->getUploadDirDisposicion() . '/' . $this->certificado_disposicion;
        } else {
            return '';
        }
    }

    static $UPLOAD_DIR_DISPOSICION = "uploads/certificado_disposicion";

    public function uploadDisposicion($archivo) {
        $nombre_archivo = $this->obtenerNuevoNombreArchivo($archivo->getClientOriginalName());
        $archivo->move($this->getUploadRootDirDisposicion(), $nombre_archivo);
        $this->setCertificadoDisposicion($nombre_archivo);
    }

    protected function getUploadRootDirDisposicion() {
        $basepath = __DIR__ . '/../../../web/';
        return $basepath . $this->getUploadDirDisposicion();
    }

    protected function getUploadDirDisposicion() {
        return self::$UPLOAD_DIR_DISPOSICION;
    }

    public function obtenerNuevoNombreArchivo($nombre_original) {
        $nombre_archivo_array = explode('.', $nombre_original);
        $extension_archivo = $nombre_archivo_array[count($nombre_archivo_array) - 1];
        $nombre_file = rand(1, 9999) . '_file_' . date('YmsHis') . '.' . $extension_archivo;
        return $nombre_file;
    }

    public function uploadFiles() {
        $this->uploadDisposicion();
    }

    public function getUltimaFechaRecoleccion() {
        if (count($this->getRecolecciones()) > 0) {
            $recolecciones = $this->getRecolecciones();
            $ultimaRecoleccion = $recolecciones[count($recolecciones) - 1];
            return $ultimaRecoleccion->getFechaRecoleccionEjecutada();
        }
    }
        /**
     * @var boolean
     */
    private $validado;

    /**
     * @var string
     */
    private $certificado_disposicion;

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
    private $recolecciones;

    /**
     * @var \ModelBundle\Entity\Programacion
     */
    private $programacion;

    /**
     * @var \ModelBundle\Entity\TipoResiduo
     */
    private $tipo_residuo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->recolecciones = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set validado
     *
     * @param boolean $validado
     *
     * @return TipoResiduoTransporte
     */
    public function setValidado($validado)
    {
        $this->validado = $validado;

        return $this;
    }

    /**
     * Get validado
     *
     * @return boolean
     */
    public function getValidado()
    {
        return $this->validado;
    }

    /**
     * Set certificadoDisposicion
     *
     * @param string $certificadoDisposicion
     *
     * @return TipoResiduoTransporte
     */
    public function setCertificadoDisposicion($certificadoDisposicion)
    {
        $this->certificado_disposicion = $certificadoDisposicion;

        return $this;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return TipoResiduoTransporte
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
     * @return TipoResiduoTransporte
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
     * Add recoleccione
     *
     * @param \ModelBundle\Entity\Recoleccion $recoleccione
     *
     * @return TipoResiduoTransporte
     */
    public function addRecoleccione(\ModelBundle\Entity\Recoleccion $recoleccione)
    {
        $this->recolecciones[] = $recoleccione;

        return $this;
    }

    /**
     * Remove recoleccione
     *
     * @param \ModelBundle\Entity\Recoleccion $recoleccione
     */
    public function removeRecoleccione(\ModelBundle\Entity\Recoleccion $recoleccione)
    {
        $this->recolecciones->removeElement($recoleccione);
    }

    /**
     * Get recolecciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecolecciones()
    {
        return $this->recolecciones;
    }

    /**
     * Set programacion
     *
     * @param \ModelBundle\Entity\Programacion $programacion
     *
     * @return TipoResiduoTransporte
     */
    public function setProgramacion(\ModelBundle\Entity\Programacion $programacion)
    {
        $this->programacion = $programacion;

        return $this;
    }

    /**
     * Get programacion
     *
     * @return \ModelBundle\Entity\Programacion
     */
    public function getProgramacion()
    {
        return $this->programacion;
    }

    /**
     * Set tipoResiduo
     *
     * @param \ModelBundle\Entity\TipoResiduo $tipoResiduo
     *
     * @return TipoResiduoTransporte
     */
    public function setTipoResiduo(\ModelBundle\Entity\TipoResiduo $tipoResiduo)
    {
        $this->tipo_residuo = $tipoResiduo;

        return $this;
    }

    /**
     * Get tipoResiduo
     *
     * @return \ModelBundle\Entity\TipoResiduo
     */
    public function getTipoResiduo()
    {
        return $this->tipo_residuo;
    }
}
