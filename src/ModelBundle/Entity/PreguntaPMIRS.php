<?php

namespace ModelBundle\Entity;

/**
 * PreguntaPMIRS
 */
class PreguntaPMIRS
{
    public function __toString() {
        return $this->pregunta ? $this->pregunta : '';
    }
    
    /**
     * @var string
     */
    private $pregunta;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $seguimientos;

    /**
     * @var \ModelBundle\Entity\ComponentePMIRS
     */
    private $componente;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->seguimientos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set pregunta
     *
     * @param string $pregunta
     *
     * @return PreguntaPMIRS
     */
    public function setPregunta($pregunta)
    {
        $this->pregunta = $pregunta;

        return $this;
    }

    /**
     * Get pregunta
     *
     * @return string
     */
    public function getPregunta()
    {
        return $this->pregunta;
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
     * Add seguimiento
     *
     * @param \ModelBundle\Entity\PreguntaSeguimiento $seguimiento
     *
     * @return PreguntaPMIRS
     */
    public function addSeguimiento(\ModelBundle\Entity\PreguntaSeguimiento $seguimiento)
    {
        $this->seguimientos[] = $seguimiento;

        return $this;
    }

    /**
     * Remove seguimiento
     *
     * @param \ModelBundle\Entity\PreguntaSeguimiento $seguimiento
     */
    public function removeSeguimiento(\ModelBundle\Entity\PreguntaSeguimiento $seguimiento)
    {
        $this->seguimientos->removeElement($seguimiento);
    }

    /**
     * Get seguimientos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSeguimientos()
    {
        return $this->seguimientos;
    }

    /**
     * Set componente
     *
     * @param \ModelBundle\Entity\ComponentePMIRS $componente
     *
     * @return PreguntaPMIRS
     */
    public function setComponente(\ModelBundle\Entity\ComponentePMIRS $componente)
    {
        $this->componente = $componente;

        return $this;
    }

    /**
     * Get componente
     *
     * @return \ModelBundle\Entity\ComponentePMIRS
     */
    public function getComponente()
    {
        return $this->componente;
    }
}
