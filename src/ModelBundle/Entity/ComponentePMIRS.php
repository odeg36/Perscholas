<?php

namespace ModelBundle\Entity;

/**
 * ComponentePMIRS
 */
class ComponentePMIRS
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $preguntas_PMIRS;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->preguntas_PMIRS = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return ComponentePMIRS
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add preguntasPMIR
     *
     * @param \ModelBundle\Entity\PreguntaPMIRS $preguntasPMIR
     *
     * @return ComponentePMIRS
     */
    public function addPreguntasPMIR(\ModelBundle\Entity\PreguntaPMIRS $preguntasPMIR)
    {
        $this->preguntas_PMIRS[] = $preguntasPMIR;

        return $this;
    }

    /**
     * Remove preguntasPMIR
     *
     * @param \ModelBundle\Entity\PreguntaPMIRS $preguntasPMIR
     */
    public function removePreguntasPMIR(\ModelBundle\Entity\PreguntaPMIRS $preguntasPMIR)
    {
        $this->preguntas_PMIRS->removeElement($preguntasPMIR);
    }

    /**
     * Get preguntasPMIRS
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPreguntasPMIRS()
    {
        return $this->preguntas_PMIRS;
    }
}
