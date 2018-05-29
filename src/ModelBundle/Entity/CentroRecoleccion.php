<?php

namespace ModelBundle\Entity;

/**
 * CentroRecoleccion
 */
class CentroRecoleccion {

    public function __toString() {
        return $this->getNombre() ? $this->getNombre() : '';
    }
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $nombreContacto;

    /**
     * @var string
     */
    private $cargoContacto;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $direccion;

    /**
     * @var string
     */
    private $telefono;

    /**
     * @var string
     */
    private $celular;

    /**
     * @var integer
     */
    private $numero_empleados;

    /**
     * @var integer
     */
    private $numero_camillas;

    /**
     * @var integer
     */
    private $numero_locales;

    /**
     * @var integer
     */
    private $numero_apartamentos;

    /**
     * @var integer
     */
    private $numero_promedio_habitantes_apartamento;

    /**
     * @var integer
     */
    private $numero_torres;

    /**
     * @var integer
     */
    private $numero_estudiantes;

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
    private $capacitaciones;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $programaciones;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $seguimientos;

    /**
     * @var \ModelBundle\Entity\Cliente
     */
    private $cliente;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->capacitaciones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->programaciones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->seguimientos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CentroRecoleccion
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
     * Set nombreContacto
     *
     * @param string $nombreContacto
     *
     * @return CentroRecoleccion
     */
    public function setNombreContacto($nombreContacto)
    {
        $this->nombreContacto = $nombreContacto;

        return $this;
    }

    /**
     * Get nombreContacto
     *
     * @return string
     */
    public function getNombreContacto()
    {
        return $this->nombreContacto;
    }

    /**
     * Set cargoContacto
     *
     * @param string $cargoContacto
     *
     * @return CentroRecoleccion
     */
    public function setCargoContacto($cargoContacto)
    {
        $this->cargoContacto = $cargoContacto;

        return $this;
    }

    /**
     * Get cargoContacto
     *
     * @return string
     */
    public function getCargoContacto()
    {
        return $this->cargoContacto;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CentroRecoleccion
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return CentroRecoleccion
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return CentroRecoleccion
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return CentroRecoleccion
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set celular
     *
     * @param string $celular
     *
     * @return CentroRecoleccion
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get celular
     *
     * @return string
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * Set numeroEmpleados
     *
     * @param integer $numeroEmpleados
     *
     * @return CentroRecoleccion
     */
    public function setNumeroEmpleados($numeroEmpleados)
    {
        $this->numero_empleados = $numeroEmpleados;

        return $this;
    }

    /**
     * Get numeroEmpleados
     *
     * @return integer
     */
    public function getNumeroEmpleados()
    {
        return $this->numero_empleados;
    }

    /**
     * Set numeroCamillas
     *
     * @param integer $numeroCamillas
     *
     * @return CentroRecoleccion
     */
    public function setNumeroCamillas($numeroCamillas)
    {
        $this->numero_camillas = $numeroCamillas;

        return $this;
    }

    /**
     * Get numeroCamillas
     *
     * @return integer
     */
    public function getNumeroCamillas()
    {
        return $this->numero_camillas;
    }

    /**
     * Set numeroLocales
     *
     * @param integer $numeroLocales
     *
     * @return CentroRecoleccion
     */
    public function setNumeroLocales($numeroLocales)
    {
        $this->numero_locales = $numeroLocales;

        return $this;
    }

    /**
     * Get numeroLocales
     *
     * @return integer
     */
    public function getNumeroLocales()
    {
        return $this->numero_locales;
    }

    /**
     * Set numeroApartamentos
     *
     * @param integer $numeroApartamentos
     *
     * @return CentroRecoleccion
     */
    public function setNumeroApartamentos($numeroApartamentos)
    {
        $this->numero_apartamentos = $numeroApartamentos;

        return $this;
    }

    /**
     * Get numeroApartamentos
     *
     * @return integer
     */
    public function getNumeroApartamentos()
    {
        return $this->numero_apartamentos;
    }

    /**
     * Set numeroPromedioHabitantesApartamento
     *
     * @param integer $numeroPromedioHabitantesApartamento
     *
     * @return CentroRecoleccion
     */
    public function setNumeroPromedioHabitantesApartamento($numeroPromedioHabitantesApartamento)
    {
        $this->numero_promedio_habitantes_apartamento = $numeroPromedioHabitantesApartamento;

        return $this;
    }

    /**
     * Get numeroPromedioHabitantesApartamento
     *
     * @return integer
     */
    public function getNumeroPromedioHabitantesApartamento()
    {
        return $this->numero_promedio_habitantes_apartamento;
    }

    /**
     * Set numeroTorres
     *
     * @param integer $numeroTorres
     *
     * @return CentroRecoleccion
     */
    public function setNumeroTorres($numeroTorres)
    {
        $this->numero_torres = $numeroTorres;

        return $this;
    }

    /**
     * Get numeroTorres
     *
     * @return integer
     */
    public function getNumeroTorres()
    {
        return $this->numero_torres;
    }

    /**
     * Set numeroEstudiantes
     *
     * @param integer $numeroEstudiantes
     *
     * @return CentroRecoleccion
     */
    public function setNumeroEstudiantes($numeroEstudiantes)
    {
        $this->numero_estudiantes = $numeroEstudiantes;

        return $this;
    }

    /**
     * Get numeroEstudiantes
     *
     * @return integer
     */
    public function getNumeroEstudiantes()
    {
        return $this->numero_estudiantes;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return CentroRecoleccion
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
     * @return CentroRecoleccion
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
     * Add capacitacione
     *
     * @param \ModelBundle\Entity\Capacitacion $capacitacione
     *
     * @return CentroRecoleccion
     */
    public function addCapacitacione(\ModelBundle\Entity\Capacitacion $capacitacione)
    {
        $this->capacitaciones[] = $capacitacione;

        return $this;
    }

    /**
     * Remove capacitacione
     *
     * @param \ModelBundle\Entity\Capacitacion $capacitacione
     */
    public function removeCapacitacione(\ModelBundle\Entity\Capacitacion $capacitacione)
    {
        $this->capacitaciones->removeElement($capacitacione);
    }

    /**
     * Get capacitaciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCapacitaciones()
    {
        return $this->capacitaciones;
    }

    /**
     * Add programacione
     *
     * @param \ModelBundle\Entity\Programacion $programacione
     *
     * @return CentroRecoleccion
     */
    public function addProgramacione(\ModelBundle\Entity\Programacion $programacione)
    {
        $this->programaciones[] = $programacione;

        return $this;
    }

    /**
     * Remove programacione
     *
     * @param \ModelBundle\Entity\Programacion $programacione
     */
    public function removeProgramacione(\ModelBundle\Entity\Programacion $programacione)
    {
        $this->programaciones->removeElement($programacione);
    }

    /**
     * Get programaciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProgramaciones()
    {
        return $this->programaciones;
    }

    /**
     * Add seguimiento
     *
     * @param \ModelBundle\Entity\SeguimientoPMIRS $seguimiento
     *
     * @return CentroRecoleccion
     */
    public function addSeguimiento(\ModelBundle\Entity\SeguimientoPMIRS $seguimiento)
    {
        $this->seguimientos[] = $seguimiento;

        return $this;
    }

    /**
     * Remove seguimiento
     *
     * @param \ModelBundle\Entity\SeguimientoPMIRS $seguimiento
     */
    public function removeSeguimiento(\ModelBundle\Entity\SeguimientoPMIRS $seguimiento)
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
     * Set cliente
     *
     * @param \ModelBundle\Entity\Cliente $cliente
     *
     * @return CentroRecoleccion
     */
    public function setCliente(\ModelBundle\Entity\Cliente $cliente)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \ModelBundle\Entity\Cliente
     */
    public function getCliente()
    {
        return $this->cliente;
    }
}
