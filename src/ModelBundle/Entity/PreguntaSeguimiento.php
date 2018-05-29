<?php

namespace ModelBundle\Entity;

/**
 * PreguntaSeguimiento
 */
class PreguntaSeguimiento
{
    /**
     * @var boolean
     */
    private $cumple;

    /**
     * @var string
     */
    private $observaciones;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \ModelBundle\Entity\PreguntaPMIRS
     */
    private $pregunta;

    /**
     * @var \ModelBundle\Entity\SeguimientoPMIRS
     */
    private $seguimiento;


    /**
     * Set cumple
     *
     * @param boolean $cumple
     *
     * @return PreguntaSeguimiento
     */
    public function setCumple($cumple)
    {
        $this->cumple = $cumple;

        return $this;
    }

    /**
     * Get cumple
     *
     * @return boolean
     */
    public function getCumple()
    {
        return $this->cumple;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return PreguntaSeguimiento
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set pregunta
     *
     * @param \ModelBundle\Entity\PreguntaPMIRS $pregunta
     *
     * @return PreguntaSeguimiento
     */
    public function setPregunta(\ModelBundle\Entity\PreguntaPMIRS $pregunta)
    {
        $this->pregunta = $pregunta;

        return $this;
    }

    /**
     * Get pregunta
     *
     * @return \ModelBundle\Entity\PreguntaPMIRS
     */
    public function getPregunta()
    {
        return $this->pregunta;
    }

    /**
     * Set seguimiento
     *
     * @param \ModelBundle\Entity\SeguimientoPMIRS $seguimiento
     *
     * @return PreguntaSeguimiento
     */
    public function setSeguimiento(\ModelBundle\Entity\SeguimientoPMIRS $seguimiento)
    {
        $this->seguimiento = $seguimiento;

        return $this;
    }

    /**
     * Get seguimiento
     *
     * @return \ModelBundle\Entity\SeguimientoPMIRS
     */
    public function getSeguimiento()
    {
        return $this->seguimiento;
    }
}
