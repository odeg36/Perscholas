<?php

namespace ModelBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * ManualUsuario
 */
class ManualUsuario {

    public function __toString() {
        return $this->getInteraccion() ? $this->getInteraccion() : '';
    }

    /**
     * @var string
     */
    private $interaccion;

    /**
     * @var string
     */
    private $respuesta;

    /**
     * @var array
     */
    private $roles;

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
     * Set interaccion
     *
     * @param string $interaccion
     *
     * @return ManualUsuario
     */
    public function setInteraccion($interaccion) {
        $this->interaccion = $interaccion;

        return $this;
    }

    /**
     * Get interaccion
     *
     * @return string
     */
    public function getInteraccion() {
        return $this->interaccion;
    }

    /**
     * Set respuesta
     *
     * @param string $respuesta
     *
     * @return ManualUsuario
     */
    public function setRespuesta($respuesta) {
        $this->respuesta = $respuesta;

        return $this;
    }

    /**
     * Get respuesta
     *
     * @return string
     */
    public function getRespuesta() {
        return $this->respuesta;
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return ManualUsuario
     */
    public function setRoles($roles) {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles() {
        return $this->roles;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return ManualUsuario
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
     * @return ManualUsuario
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

}
