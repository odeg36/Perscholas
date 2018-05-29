<?php

namespace ModelBundle\Entity;

use Sonata\UserBundle\Entity\BaseUser as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 */
class User extends BaseUser {

//--------------------------------- Modify -------------------------------------
//------------------------------------------------------------------------------
    public function __toString() {
        return $this->getUsername() ? (string) $this->getUsername() : '';
    }

    public function __construct() {
        parent::__construct();
        $this->setRoles(array('ROLE_USER'));
    }

    public function nombreCliente() {
        if ($this->getCliente()) {
            return $this->getUsername() . " - " . $this->getCliente()->getNombre();
        } else {
            return $this->getUsername(). " - Kontrolgrun" ;
        }
    }

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

    /**
     * @var string
     */
    private $picture;

    /**
     * @var integer
     */
    private $age;

    /**
     * @var string
     */
    private $direction;

    /**
     * @var integer
     */
    private $documentId;

    /**
     * @var \ModelBundle\Entity\Cliente
     */
    private $cliente;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $reportes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $alertas;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $programaciones;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $capacitaciones;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $soporteModificados;

    /**
     * Set picture
     *
     * @param string $picture
     *
     * @return User
     */
    public function setPicture($picture) {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string
     */
    public function getPicture() {
        return $this->picture;
    }

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return User
     */
    public function setAge($age) {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer
     */
    public function getAge() {
        return $this->age;
    }

    /**
     * Set direction
     *
     * @param string $direction
     *
     * @return User
     */
    public function setDirection($direction) {
        $this->direction = $direction;

        return $this;
    }

    /**
     * Get direction
     *
     * @return string
     */
    public function getDirection() {
        return $this->direction;
    }

    /**
     * Set documentId
     *
     * @param integer $documentId
     *
     * @return User
     */
    public function setDocumentId($documentId) {
        $this->documentId = $documentId;

        return $this;
    }

    /**
     * Get documentId
     *
     * @return integer
     */
    public function getDocumentId() {
        return $this->documentId;
    }

    /**
     * Set cliente
     *
     * @param \ModelBundle\Entity\Cliente $cliente
     *
     * @return User
     */
    public function setCliente(\ModelBundle\Entity\Cliente $cliente = null) {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \ModelBundle\Entity\Cliente
     */
    public function getCliente() {
        return $this->cliente;
    }

    /**
     * Add reporte
     *
     * @param \ModelBundle\Entity\Reporte $reporte
     *
     * @return User
     */
    public function addReporte(\ModelBundle\Entity\Reporte $reporte) {
        $this->reportes[] = $reporte;

        return $this;
    }

    /**
     * Remove reporte
     *
     * @param \ModelBundle\Entity\Reporte $reporte
     */
    public function removeReporte(\ModelBundle\Entity\Reporte $reporte) {
        $this->reportes->removeElement($reporte);
    }

    /**
     * Get reportes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReportes() {
        return $this->reportes;
    }

    /**
     * Add alerta
     *
     * @param \ModelBundle\Entity\Alerta $alerta
     *
     * @return User
     */
    public function addAlerta(\ModelBundle\Entity\Alerta $alerta) {
        $this->alertas[] = $alerta;

        return $this;
    }

    /**
     * Remove alerta
     *
     * @param \ModelBundle\Entity\Alerta $alerta
     */
    public function removeAlerta(\ModelBundle\Entity\Alerta $alerta) {
        $this->alertas->removeElement($alerta);
    }

    /**
     * Get alertas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAlertas() {
        return $this->alertas;
    }

    /**
     * Add programacione
     *
     * @param \ModelBundle\Entity\Programacion $programacione
     *
     * @return User
     */
    public function addProgramaciones(\ModelBundle\Entity\Programacion $programacione) {
        $this->programaciones[] = $programacione;

        return $this;
    }

    /**
     * Remove programacione
     *
     * @param \ModelBundle\Entity\Programacion $programacione
     */
    public function removeProgramaciones(\ModelBundle\Entity\Programacion $programacione) {
        $this->programaciones->removeElement($programacione);
    }

    /**
     * Get programaciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProgramaciones() {
        return $this->programaciones;
    }

    /**
     * Add capacitacione
     *
     * @param \ModelBundle\Entity\Capacitacion $capacitacione
     *
     * @return User
     */
    public function addCapacitacione(\ModelBundle\Entity\Capacitacion $capacitacione) {
        $this->capacitaciones[] = $capacitacione;

        return $this;
    }

    /**
     * Remove capacitacione
     *
     * @param \ModelBundle\Entity\Capacitacion $capacitacione
     */
    public function removeCapacitacione(\ModelBundle\Entity\Capacitacion $capacitacione) {
        $this->capacitaciones->removeElement($capacitacione);
    }

    /**
     * Get capacitaciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCapacitaciones() {
        return $this->capacitaciones;
    }

    /**
     * Add soporteModificado
     *
     * @param \ModelBundle\Entity\SoporteModificado $soporteModificado
     *
     * @return User
     */
    public function addSoporteModificado(\ModelBundle\Entity\SoporteModificado $soporteModificado) {
        $this->soporteModificados[] = $soporteModificado;

        return $this;
    }

    /**
     * Remove soporteModificado
     *
     * @param \ModelBundle\Entity\SoporteModificado $soporteModificado
     */
    public function removeSoporteModificado(\ModelBundle\Entity\SoporteModificado $soporteModificado) {
        $this->soporteModificados->removeElement($soporteModificado);
    }

    /**
     * Get soporteModificados
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSoporteModificados() {
        return $this->soporteModificados;
    }

    /**
     * Add programacione
     *
     * @param \ModelBundle\Entity\Programacion $programacione
     *
     * @return User
     */
    public function addProgramacione(\ModelBundle\Entity\Programacion $programacione) {
        $this->programaciones[] = $programacione;

        return $this;
    }

    /**
     * Remove programacione
     *
     * @param \ModelBundle\Entity\Programacion $programacione
     */
    public function removeProgramacione(\ModelBundle\Entity\Programacion $programacione) {
        $this->programaciones->removeElement($programacione);
    }

    /**
     * @var \ModelBundle\Entity\User
     */
    private $usuario;


    /**
     * Set usuario
     *
     * @param \ModelBundle\Entity\User $usuario
     *
     * @return User
     */
    public function setUsuario(\ModelBundle\Entity\User $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \ModelBundle\Entity\User
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Add cliente
     *
     * @param \ModelBundle\Entity\Cliente $cliente
     *
     * @return User
     */
    public function addCliente(\ModelBundle\Entity\Cliente $cliente)
    {
        $this->cliente[] = $cliente;

        return $this;
    }

    /**
     * Remove cliente
     *
     * @param \ModelBundle\Entity\Cliente $cliente
     */
    public function removeCliente(\ModelBundle\Entity\Cliente $cliente)
    {
        $this->cliente->removeElement($cliente);
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $clientes;


    /**
     * Get clientes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClientes()
    {
        return $this->clientes;
    }
    /**
     * @var \ModelBundle\Entity\User
     */
    private $usuarios;


    /**
     * Set usuarios
     *
     * @param \ModelBundle\Entity\User $usuarios
     *
     * @return User
     */
    public function setUsuarios(\ModelBundle\Entity\User $usuarios)
    {
        $this->usuarios = $usuarios;

        return $this;
    }

    /**
     * Get usuarios
     *
     * @return \ModelBundle\Entity\User
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }
    /**
     * @var boolean
     */
    private $es_kontrol_grun;


    /**
     * Set esKontrolGrun
     *
     * @param boolean $esKontrolGrun
     *
     * @return User
     */
    public function setEsKontrolGrun($esKontrolGrun)
    {
        $this->es_kontrol_grun = $esKontrolGrun;

        return $this;
    }

    /**
     * Get esKontrolGrun
     *
     * @return boolean
     */
    public function getEsKontrolGrun()
    {
        return $this->es_kontrol_grun;
    }
    
    public function setExpiresAt(\DateTime $date = null) {
        $this->expiresAt = $date;
        return $this;
    }
}
