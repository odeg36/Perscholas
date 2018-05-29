<?php

namespace ModelBundle\Entity;

/**
 * SeguimientoPMIRS
 */
class SeguimientoPMIRS {

//--------------------------------- Modify -------------------------------------
//------------------------------------------------------------------------------
    public function __toString() {
        if ($this->getCentroRecoleccion()) {
            return $this->getCentroRecoleccion()->getCliente()->getNombre() . " - " . $this->getCentroRecoleccion()->getNombre();
        } else {
            return '';
        }
    }
    public function getArchivoEncuesta() {
        if ($this->archivoEncuesta) {
            return "/" . $this->getUploadDir() . '/' . $this->archivoEncuesta;
        } else {
            return '';
        }
    }

    /**
     * @var string
     */
    static $UPLOAD_DIR = "uploads/pmirs";

    public function upload($archivo) {
        if ($archivo) {
            $nombre_archivo = $this->obtenerNuevoNombreArchivo($archivo->getClientOriginalName());
            $archivo->move($this->getUploadRootDir(), $nombre_archivo);
            $this->setArchivoEncuesta($nombre_archivo);
        }
    }

    protected function getUploadRootDir() {
        $basepath = __DIR__ . '/../../../web/';
        return $basepath . $this->getUploadDir();
    }

    protected function getUploadDir() {
        return self::$UPLOAD_DIR;
    }

    public function obtenerNuevoNombreArchivo($nombre_original) {
        $nombre_archivo_array = explode('.', $nombre_original);
        $extension_archivo = $nombre_archivo_array[count($nombre_archivo_array) - 1];
        $nombre_file = rand(1, 9999) . '_file_' . date('YmsHis') . '.' . $extension_archivo;
        return $nombre_file;
    }

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
        /**
     * @var boolean
     */
    private $cumple_seguimiento;

    /**
     * @var string
     */
    private $conclusiones;

    /**
     * @var \DateTime
     */
    private $fecha_ejecucion;

    /**
     * @var string
     */
    private $atendio;

    /**
     * @var string
     */
    private $elaboro;

    /**
     * @var string
     */
    private $archivoEncuesta;

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
    private $preguntas;

    /**
     * @var \ModelBundle\Entity\CentroRecoleccion
     */
    private $centro_recoleccion;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->preguntas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set cumpleSeguimiento
     *
     * @param boolean $cumpleSeguimiento
     *
     * @return SeguimientoPMIRS
     */
    public function setCumpleSeguimiento($cumpleSeguimiento)
    {
        $this->cumple_seguimiento = $cumpleSeguimiento;

        return $this;
    }

    /**
     * Get cumpleSeguimiento
     *
     * @return boolean
     */
    public function getCumpleSeguimiento()
    {
        return $this->cumple_seguimiento;
    }

    /**
     * Set conclusiones
     *
     * @param string $conclusiones
     *
     * @return SeguimientoPMIRS
     */
    public function setConclusiones($conclusiones)
    {
        $this->conclusiones = $conclusiones;

        return $this;
    }

    /**
     * Get conclusiones
     *
     * @return string
     */
    public function getConclusiones()
    {
        return $this->conclusiones;
    }

    /**
     * Set fechaEjecucion
     *
     * @param \DateTime $fechaEjecucion
     *
     * @return SeguimientoPMIRS
     */
    public function setFechaEjecucion($fechaEjecucion)
    {
        $this->fecha_ejecucion = $fechaEjecucion;

        return $this;
    }

    /**
     * Get fechaEjecucion
     *
     * @return \DateTime
     */
    public function getFechaEjecucion()
    {
        return $this->fecha_ejecucion;
    }

    /**
     * Set atendio
     *
     * @param string $atendio
     *
     * @return SeguimientoPMIRS
     */
    public function setAtendio($atendio)
    {
        $this->atendio = $atendio;

        return $this;
    }

    /**
     * Get atendio
     *
     * @return string
     */
    public function getAtendio()
    {
        return $this->atendio;
    }

    /**
     * Set elaboro
     *
     * @param string $elaboro
     *
     * @return SeguimientoPMIRS
     */
    public function setElaboro($elaboro)
    {
        $this->elaboro = $elaboro;

        return $this;
    }

    /**
     * Get elaboro
     *
     * @return string
     */
    public function getElaboro()
    {
        return $this->elaboro;
    }

    /**
     * Set archivoEncuesta
     *
     * @param string $archivoEncuesta
     *
     * @return SeguimientoPMIRS
     */
    public function setArchivoEncuesta($archivoEncuesta)
    {
        $this->archivoEncuesta = $archivoEncuesta;

        return $this;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return SeguimientoPMIRS
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
     * @return SeguimientoPMIRS
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
     * Add pregunta
     *
     * @param \ModelBundle\Entity\PreguntaSeguimiento $pregunta
     *
     * @return SeguimientoPMIRS
     */
    public function addPregunta(\ModelBundle\Entity\PreguntaSeguimiento $pregunta)
    {
        $this->preguntas[] = $pregunta;

        return $this;
    }

    /**
     * Remove pregunta
     *
     * @param \ModelBundle\Entity\PreguntaSeguimiento $pregunta
     */
    public function removePregunta(\ModelBundle\Entity\PreguntaSeguimiento $pregunta)
    {
        $this->preguntas->removeElement($pregunta);
    }

    /**
     * Get preguntas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPreguntas()
    {
        return $this->preguntas;
    }

    /**
     * Set centroRecoleccion
     *
     * @param \ModelBundle\Entity\CentroRecoleccion $centroRecoleccion
     *
     * @return SeguimientoPMIRS
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
}
