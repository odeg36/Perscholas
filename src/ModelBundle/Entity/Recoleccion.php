<?php

namespace ModelBundle\Entity;

/**
 * Recoleccion
 */
class Recoleccion {
    /* --------- Manifiesto de transporte ---------- */

    public function getManifiestoTransporte() {
        if ($this->manifiesto_transporte) {
            return "/" . $this->getUploadDirTransporte() . '/' . $this->manifiesto_transporte;
        } else {
            return '';
        }
    }

    static $UPLOAD_DIR_TRANSPORTE = "uploads/manifiesto_transporte";

    public function uploadTransporte($archivo) {
        $nombre_archivo = $this->obtenerNuevoNombreArchivo($archivo->getClientOriginalName());
        $archivo->move($this->getUploadRootDirTransporte(), $nombre_archivo);
        $this->setManifiestoTransporte($nombre_archivo);
    }

    protected function getUploadRootDirTransporte() {
        $basepath = __DIR__ . '/../../../web/';
        return $basepath . $this->getUploadDirTransporte();
    }

    protected function getUploadDirTransporte() {
        return self::$UPLOAD_DIR_TRANSPORTE;
    }

    public function uploadFiles() {
        $this->uploadTransporte();
    }

    public function obtenerNuevoNombreArchivo($nombre_original) {
        $nombre_archivo_array = explode('.', $nombre_original);
        $extension_archivo = $nombre_archivo_array[count($nombre_archivo_array) - 1];
        $nombre_file = rand(1, 9999) . '_file_' . date('YmsHis') . '.' . $extension_archivo;
        return $nombre_file;
    }

        /**
     * @var \DateTime
     */
    private $fecha_programacion;

    /**
     * @var \DateTime
     */
    private $fecha_recoleccion_ejecutada;

    /**
     * @var string
     */
    private $manifiesto_transporte;

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
     * @var \ModelBundle\Entity\RecoleccionVolqueta
     */
    private $recoleccion_volqueta;

    /**
     * @var \ModelBundle\Entity\RecoleccionContenedor
     */
    private $recoleccion_contenedor;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $residuos;

    /**
     * @var \ModelBundle\Entity\TipoResiduoTransporte
     */
    private $tipo_residuo_transporte;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->residuos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set fechaProgramacion
     *
     * @param \DateTime $fechaProgramacion
     *
     * @return Recoleccion
     */
    public function setFechaProgramacion($fechaProgramacion)
    {
        $this->fecha_programacion = $fechaProgramacion;

        return $this;
    }

    /**
     * Get fechaProgramacion
     *
     * @return \DateTime
     */
    public function getFechaProgramacion()
    {
        return $this->fecha_programacion;
    }

    /**
     * Set fechaRecoleccionEjecutada
     *
     * @param \DateTime $fechaRecoleccionEjecutada
     *
     * @return Recoleccion
     */
    public function setFechaRecoleccionEjecutada($fechaRecoleccionEjecutada)
    {
        $this->fecha_recoleccion_ejecutada = $fechaRecoleccionEjecutada;

        return $this;
    }

    /**
     * Get fechaRecoleccionEjecutada
     *
     * @return \DateTime
     */
    public function getFechaRecoleccionEjecutada()
    {
        return $this->fecha_recoleccion_ejecutada;
    }

    /**
     * Set manifiestoTransporte
     *
     * @param string $manifiestoTransporte
     *
     * @return Recoleccion
     */
    public function setManifiestoTransporte($manifiestoTransporte)
    {
        $this->manifiesto_transporte = $manifiestoTransporte;

        return $this;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Recoleccion
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
     * @return Recoleccion
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
     * Set recoleccionVolqueta
     *
     * @param \ModelBundle\Entity\RecoleccionVolqueta $recoleccionVolqueta
     *
     * @return Recoleccion
     */
    public function setRecoleccionVolqueta(\ModelBundle\Entity\RecoleccionVolqueta $recoleccionVolqueta = null)
    {
        $this->recoleccion_volqueta = $recoleccionVolqueta;

        return $this;
    }

    /**
     * Get recoleccionVolqueta
     *
     * @return \ModelBundle\Entity\RecoleccionVolqueta
     */
    public function getRecoleccionVolqueta()
    {
        return $this->recoleccion_volqueta;
    }

    /**
     * Set recoleccionContenedor
     *
     * @param \ModelBundle\Entity\RecoleccionContenedor $recoleccionContenedor
     *
     * @return Recoleccion
     */
    public function setRecoleccionContenedor(\ModelBundle\Entity\RecoleccionContenedor $recoleccionContenedor = null)
    {
        $this->recoleccion_contenedor = $recoleccionContenedor;

        return $this;
    }

    /**
     * Get recoleccionContenedor
     *
     * @return \ModelBundle\Entity\RecoleccionContenedor
     */
    public function getRecoleccionContenedor()
    {
        return $this->recoleccion_contenedor;
    }

    /**
     * Add residuo
     *
     * @param \ModelBundle\Entity\ResiduoRecoleccion $residuo
     *
     * @return Recoleccion
     */
    public function addResiduo(\ModelBundle\Entity\ResiduoRecoleccion $residuo)
    {
        $this->residuos[] = $residuo;

        return $this;
    }

    /**
     * Remove residuo
     *
     * @param \ModelBundle\Entity\ResiduoRecoleccion $residuo
     */
    public function removeResiduo(\ModelBundle\Entity\ResiduoRecoleccion $residuo)
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
     * Set tipoResiduoTransporte
     *
     * @param \ModelBundle\Entity\TipoResiduoTransporte $tipoResiduoTransporte
     *
     * @return Recoleccion
     */
    public function setTipoResiduoTransporte(\ModelBundle\Entity\TipoResiduoTransporte $tipoResiduoTransporte)
    {
        $this->tipo_residuo_transporte = $tipoResiduoTransporte;

        return $this;
    }

    /**
     * Get tipoResiduoTransporte
     *
     * @return \ModelBundle\Entity\TipoResiduoTransporte
     */
    public function getTipoResiduoTransporte()
    {
        return $this->tipo_residuo_transporte;
    }
}
