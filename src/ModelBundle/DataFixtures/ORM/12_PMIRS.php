<?php

namespace ModelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ModelBundle\Entity\ComponentePMIRS;
use ModelBundle\Entity\PreguntaPMIRS;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FixturesPMIRS extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    public function getOrder() {
        return 12;
    }

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function load(ObjectManager $manager) {
        $pmirs = array(
            array(
                'componente' => 'Componente basico',
                'preguntas' => array(
                    '¿Fueron sensibilizadas todas las unidades habitacionales?',
                    '¿Hay un plan de capacitaciones implementado?',
                    '¿Existe un PMIRS fisico al alcance de todos elaborado por personal idoneo con los respectivos soportes?',
                    '¿Existen Los registros de las capacitaciones y/o sensibilizaciones?',
                )
            ),
            array(
                'componente' => 'Componente de almacenamiento central',
                'preguntas' => array(
                    '¿Localizado al interior de la organización y de acceso restringido?',
                    '¿Los acabados permiten su fácil limpieza e impiden la formación de ambientes propicios para el desarrollo de microorganismos?',
                    '¿Cubierto para protección de aguas lluvias, Iluminación y ventilación adecuada (rejillas o ventanas), sistema de drenaje y piso duro e impermeable?',
                    '¿Posee sistemas de control de incendios (equipo de extinción de incendios, suministro cercano de agua, etc)?',
                    '¿La unidad de almacenamiento evita el acceso y proliferación de animales domésticos, roedores y otras clases de vectores?',
                    '¿El sitio no causa molestias e impactos a la comunidad?',
                    '¿Cuenta con recipientes o cajas de almacenamiento para realizar su adecuada presentación?',
                    '¿La unidad de almacenamiento es aseada, fumigada y desinfectada frecuentemente?',
                    '¿Es de uso exclusivo para almacenar residuos y esta debidamente señalizado?',
                    '¿Dispone de espacios suficientes para acopiar de acuerdo al tipo de residuo (reciclable, peligroso, ordinario, etc.)?',
                    '¿Cuenta con una báscula o sistema de medición de peso y volumen de los residuos, con los respectivos registros?',
                )
            ),
            array(
                'componente' => 'Componente de presentacion y transporte',
                'preguntas' => array(
                    '¿Utilizan los recipientes adecuados para cada tipo de residuo?',
                    '¿Los recipientes estan rotulados o por codigo de color según el tipo de residuo?',
                    '¿Cuenta con micro rutas internas diseñadas, señalizadas e implementadas que permitan la identificación del acopio o almacenamiento central?',
                    '¿Posee horarios establecidos para la presentación de los residuos?',
                )
            ),
            array(
                'componente' => 'Componente de aprovechamiento y disposición final',
                'preguntas' => array(
                    '¿Poseen un programa de reciclaje donde cada unidad habitacional realiza la separación en la fuente?',
                    '¿El material reciclable es entregado a empresas autorizadas que cumplen con los requisitos de ley?',
                    '¿Poseen los manifiestos de recolección de las empresas que reciben y/o disponen del reciclaje?',
                    '¿Existe programa de aprovechamiento de residuos organicos?',
                    '¿Los residuos peligrosos y especiales son entregados a las empresas autorizadas por ley?',
                    '¿Poseen los manifiestos de recolección de las empresas que reciben y/o disponen de los residuos peligrosos Y especiales?',
                )
            ),
            array(
                'componente' => 'Componente de seguimiento',
                'preguntas' => array(
                    '¿Existe un seguimiento continuo del PMIRS a cargo del comité de Gestión Ambiental u otro personal asignado?',
                    '¿Existe seguimiento a las cantidades y caracteristicas de los residuos generados a traves de la actualizacion de los indicadores de gestión?',
                    '¿Se refuerzan las actividades de afianzamiento del PMIRS a traves de estrategias  de divulgación periódica?',
                )
            ),
        );
        foreach ($pmirs as $seccion) {
            $componente = new ComponentePMIRS();
            $componente->setNombre($seccion['componente']);
            $manager->persist($componente);
            foreach ($seccion['preguntas'] as $pregunta) {
                $newPregunta = new PreguntaPMIRS();
                $newPregunta->setComponente($componente);
                $newPregunta->setPregunta($pregunta);
                $manager->persist($newPregunta);
            }
        }
        $manager->flush();
    }

}
