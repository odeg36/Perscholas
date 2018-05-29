<?php

namespace ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Capacitacion
 */
class Capacitacion {

//--------------------------------- Modify -------------------------------------
//------------------------------------------------------------------------------

    public function getArchivoCapacitacion() {
        if ($this->archivoCapacitacion) {
            return "/" . $this->getUploadDir() . '/' . $this->archivoCapacitacion;
        } else {
            return '';
        }
    }

    public function getEvidenciaFotografica() {
        if ($this->evidenciaFotografica) {
            return "/" . $this->getUploadDir() . '/' . $this->evidenciaFotografica;
        } else {
            return '';
        }
    }

    /**
     * @var string
     */
    private $archivoCapacitacion;
    private $evidenciaFotografica;
    static $UPLOAD_DIR = "uploads/capacitaciones";

    public function upload($archivo) {
        if ($archivo) {
            $nombre_archivo = $this->obtenerNuevoNombreArchivo($archivo->getClientOriginalName());
            $archivo->move($this->getUploadRootDir(), $nombre_archivo);
            $this->setArchivoCapacitacion($nombre_archivo);
        }
    }

    public function uploade($archivo) {
        if ($archivo) {
            $nombre_archivo = $this->obtenerNuevoNombreArchivo($archivo->getClientOriginalName());
            $archivo->move($this->getUploadRootDir(), $nombre_archivo);
            $this->setEvidenciaFotografica($nombre_archivo);
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

    public function __toString() {
        return $this->getId() ? (string) $this->getId() : '';
    }

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

    /**
     * @var \DateTime
     */
    private $fechaCapacitacion;

    /**
     * @var integer
     */
    private $numeroAsistentes;

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
     * @var \ModelBundle\Entity\User
     */
    private $gestor;

    /**
     * @var \ModelBundle\Entity\TipoCapacitacion
     */
    private $tipoCapacitacion;

    /**
     * Set fechaCapacitacion
     *
     * @param \DateTime $fechaCapacitacion
     *
     * @return Capacitacion
     */
    public function setFechaCapacitacion($fechaCapacitacion) {
        $this->fechaCapacitacion = $fechaCapacitacion;

        return $this;
    }

    /**
     * Get fechaCapacitacion
     *
     * @return \DateTime
     */
    public function getFechaCapacitacion() {
        return $this->fechaCapacitacion;
    }

    /**
     * Set numeroAsistentes
     *
     * @param integer $numeroAsistentes
     *
     * @return Capacitacion
     */
    public function setNumeroAsistentes($numeroAsistentes) {
        $this->numeroAsistentes = $numeroAsistentes;

        return $this;
    }

    /**
     * Get numeroAsistentes
     *
     * @return integer
     */
    public function getNumeroAsistentes() {
        return $this->numeroAsistentes;
    }

    /**
     * Set archivoCapacitacion
     *
     * @param string $archivoCapacitacion
     *
     * @return Capacitacion
     */
    public function setArchivoCapacitacion($archivoCapacitacion) {
        $this->archivoCapacitacion = $archivoCapacitacion;

        return $this;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Capacitacion
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
     * @return Capacitacion
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
     * Set gestor
     *
     * @param \ModelBundle\Entity\User $gestor
     *
     * @return Capacitacion
     */
    public function setGestor(\ModelBundle\Entity\User $gestor) {
        $this->gestor = $gestor;

        return $this;
    }

    /**
     * Get gestor
     *
     * @return \ModelBundle\Entity\User
     */
    public function getGestor() {
        return $this->gestor;
    }

    /**
     * Set tipoCapacitacion
     *
     * @param \ModelBundle\Entity\TipoCapacitacion $tipoCapacitacion
     *
     * @return Capacitacion
     */
    public function setTipoCapacitacion(\ModelBundle\Entity\TipoCapacitacion $tipoCapacitacion) {
        $this->tipoCapacitacion = $tipoCapacitacion;

        return $this;
    }

    /**
     * Get tipoCapacitacion
     *
     * @return \ModelBundle\Entity\TipoCapacitacion
     */
    public function getTipoCapacitacion() {
        return $this->tipoCapacitacion;
    }

    /**
     * @var \ModelBundle\Entity\CentroRecoleccion
     */
    private $centro_recoleccion;

    /**
     * Set centroRecoleccion
     *
     * @param \ModelBundle\Entity\CentroRecoleccion $centroRecoleccion
     *
     * @return Capacitacion
     */
    public function setCentroRecoleccion(\ModelBundle\Entity\CentroRecoleccion $centroRecoleccion) {
        $this->centro_recoleccion = $centroRecoleccion;

        return $this;
    }

    /**
     * Get centroRecoleccion
     *
     * @return \ModelBundle\Entity\CentroRecoleccion
     */
    public function getCentroRecoleccion() {
        return $this->centro_recoleccion;
    }
    
    /**
     * Set evidenciaFotografica
     *
     * @param string $evidenciaFotografica
     *
     * @return Capacitacion
     */
    public function setEvidenciaFotografica($evidenciaFotografica)
    {
        $this->evidenciaFotografica = $evidenciaFotografica;

        return $this;
    }
}
