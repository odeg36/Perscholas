<?php

namespace ModelBundle\Entity;

/**
 * PreguntaFrecuentre
 */
class PreguntaFrecuentre {

    public function __toString() {
        return $this->getPregunta() ? $this->getPregunta() : '';
    }

    /**
     * @var string
     */
    private $pregunta;

    /**
     * @var string
     */
    private $respuesta;

    /**
     * @var array
     */
    private $roles;

    /**
     * @var integer
     */
    private $id;

    /**
     * Set pregunta
     *
     * @param string $pregunta
     *
     * @return PreguntaFrecuentre
     */
    public function setPregunta($pregunta) {
        $this->pregunta = $pregunta;

        return $this;
    }

    /**
     * Get pregunta
     *
     * @return string
     */
    public function getPregunta() {
        return $this->pregunta;
    }

    /**
     * Set respuesta
     *
     * @param string $respuesta
     *
     * @return PreguntaFrecuentre
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
     * @return PreguntaFrecuentre
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
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @var \DateTime
     */
    private $fechaCreacion;

    /**
     * @var \DateTime
     */
    private $fechaActualizacion;


    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return PreguntaFrecuentre
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
     * @return PreguntaFrecuentre
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
}
