<?php

namespace ModelBundle\Entity;

/**
 * TipoResiduoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TipoResiduoRepository extends \Doctrine\ORM\EntityRepository {

    public function findAllArray() {
        $tipos = $this->findAll();
        $tipos_array = array();
        $tipo = new TipoResiduo();
        foreach ($tipos as $tipo) {
            $tipos_array[] = array(
                'id' => $tipo->getId(),
                'codigo' => $tipo->getCodigo(),
                'nombre' => $tipo->getColor(),
                'nombre' => $tipo->getNombre(),
                'usa_contenedor' => $tipo->getUsaContenedor(),
                'usa_volqueta' => $tipo->getUsaVolqueta(),
                'fecha_creacion' => $tipo->getFechaCreacion(),
                'fecha_actualizacion' => $tipo->getFechaActualizacion(),
            );
        }
        return $tipos_array;
    }

}
