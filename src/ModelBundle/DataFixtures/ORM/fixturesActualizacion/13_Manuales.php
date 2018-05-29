<?php

namespace ModelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ModelBundle\Entity\ManualUsuario;
use ModelBundle\Entity\PreguntaPMIRS;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FixturesManuales extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    public function getOrder() {
        return 13;
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
        $manuales = array(
            array(
                'interaccion' => 'Crear Recolección',
                'respuesta' => 'Para este proceso en el área de trabajo bajo la pestaña "Empresa" en el menu de la izquierda, y dando click a la opcón "Datos de recolección" podremos ingresar a una lista para poder añadir una nueva recolección. Una vez dentro del formulario nos pedira datos basicos de la programación y enseguida podremos definir: tipos de residuos, fechas de programacion y ejecución, residuos asociados, peso y precio de cada residuo y su empresa recolectora; Este proceso se llevara a cabo en un formulario con secciones estilo acordeon. '
            ),
            array(
                'interaccion' => 'Listar empresas',
                'respuesta' => 'Nos ubicamos en el menú lateral izquierdo, damos clic en "Clientes", allí encontraremos un botón (Agregar nuevo) donde podemos añadir un nuevo cliente si así lo deseamos.'
            ),
            array(
                'interaccion' => 'Registrar empresa (cliente)',
                'respuesta' => 'Nos ubicamos en el menú lateral izquierdo, damos clic en "Clientes", allí encontraremos un botón (Agregar nuevo) donde debemos ingresar los datos básicos de contacto de la empresa, datos de facturación: la fecha de inicio de facturación es la fecha de corte en cada ciclo de facturación, la forma de pago es una lista donde se puede seleccionar los diferentes formas de pago registradas en el sistema, si está exento de pago o no, puede escribir un valor a pagar y marcar la opción de generar factura para crear una factura con ese valor ingresado. Esta factura se puede descargar en formato PDF y posteriormente enviarla por correo. Más abajo podemos marcar la casilla de generación de centro de centro, que permite registrar un centro de costo al mismo tiempo que creamos un cliente.'
            ),
            array(
                'interaccion' => 'Listar centros de costos',
                'respuesta' => 'Nos ubicamos en el menú lateral izquierdo, damos clic en "Centros de costo", allí encontraremos un botón (Agregar nuevo) donde podemos añadir un nuevo cliente si así lo deseamos. Es importante que antes de registrar un centro de costo, debamos registrar un cliente.'
            ),
            array(
                'interaccion' => 'Soportes',
                'respuesta' => 'Los soportes son archivos que se asignan a un cliente, entre ellos están las autorizaciones del gestor, certificado de aprobación del PMIRS entre otros.'
            ),
            array(
                'interaccion' => 'Lista de usuarios',
                'respuesta' => 'En usuarios, podemos ver todos los usuarios que tienen acceso a la plataforma Kontrolgrun. Estos usuarios se dividen en 3 roles principales: Clientes, Gestores Ambientales y Superadministrador.'
            ),
            array(
                'interaccion' => 'Lista de capacitaciones',
                'respuesta' => 'El módulo de capacitaciones, permite generar un registro de los diferentes tipos de capacitación tales como: Virtual, Presencial o General. Cada vez que registre una capacitación, debemos asignarle un cliente, centro de costo y un gestor ambiental. Luego de esto ingresamos una fecha, número de asistentes, cargar el archivo de certificado de capacitación y la evidencia fotográfica.'
            ),
            array(
                'interaccion' => 'Registrar el cumplimiento del PMIRS',
                'respuesta' => 'En PMIRS, damos clic en seguimiento PMIRS. Acá encontraremos un formulario con todos los componentes para verificar el cumplimiento marcando si cumple o no para cada pregunta. Al final del formulario, podemos añadir información sobre la persona que atendió, elaboró, conclusiones y un archivo de soporte de esta evaluación.'
            ),
            array(
                'interaccion' => 'Generación de informes',
                'respuesta' => 'Existen 6 tipos de reportes principales. Los reportes son: Operativo, Económico, Capacitaciones, Checklist, Tipos de residuos y su disposición. Existe un reporte principal llamadao reporte detallado de indicadores el cual agrupa diferentes opciones para generar información importante en la toma de decisiones. '
            ),
            array(
                'interaccion' => 'Generar reporte operativo',
                'respuesta' => 'En la parte izquierda, damos clic en reporte operativo allí seleccionamos el período de inicio hasta un período final desde el cual queremos generar los indicadores en los reportes, la selección de cliente es opcional. Una vez generado el reporte, podemos descargarlo a Excel y formato PDF. '
            ),
            array(
                'interaccion' => 'Generar reporte económico',
                'respuesta' => 'En la parte izquierda, damos clic en reporte económico allí seleccionamos el período de inicio hasta un período final desde el cual queremos generar los indicadores en los reportes, la selección de cliente y selección de residuo es opcional ya que el reporte sin estos datos nos muestra un totalizado en costos de cada categoría de residuo. Una vez generado el reporte, podemos descargarlo a Excel y formato PDF.'
            ),
            array(
                'interaccion' => 'Generar reporte de capacitaciones',
                'respuesta' => 'Este reporte permite generar un listado de las personas que asistieron a capacitaciones en un período de tiempo específico.'
            ),
            array(
                'interaccion' => 'Generar reporte PMIRS',
                'respuesta' => 'Este reporte permite generar un cuadro comparativo para identificar los clientes que no cumplen el PMIRS. Los datos para generar este informe son: fecha de inicio y fin, cliente y su centro de costo. Una vez generado el reporte, podemos descargarlo a Excel y formato PDF.'
            ),
            array(
                'interaccion' => 'Generar reporte PMIRS',
                'respuesta' => 'Este reporte permite generar un cuadro comparativo para identificar los clientes que no cumplen el PMIRS. Los datos para generar este informe son: fecha de inicio y fin, cliente y su centro de costo. Una vez generado el reporte, podemos descargarlo a Excel y formato PDF.'
            ),
            array(
                'interaccion' => 'Generar reporte de tipos de residuos y disposiciones',
                'respuesta' => 'Este reporte permite identificar la disposición final de un tipo de residuo, como dato obligatorio debemos seleccionar el tipo de resido los datos como fecha de inicio y fecha fin. Una vez generado el reporte, podemos descargarlo a Excel y formato PDF.'
            ),
            array(
                'interaccion' => 'Generar reporte de cantidad recolectada por cateogría',
                'respuesta' => 'Para generar este reporte debemos dar clic en reporte detallado de indicadores y a continuación seleccionamos la pestaña "Cantidad recolectada de residuos por categoría", debemos seleccionar el tipo de residuo como dato obligatorio, las fechas de inicio, fecha fin, selección de cliente son datos opcionales. Una vez generado el reporte, podemos descargarlo a Excel y formato PDF.'
            ),
            array(
                'interaccion' => 'Generar reporte mensual de cantidad recolectada',
                'respuesta' => 'Para generar este reporte debemos dar clic en reporte detallado de indicadores y a continuación seleccionamos la pestaña "Reporte mensual e cantidad recolectada", Los datos opciones para generar el reporte son las fechas de inicio, fecha fin, tipo de residuos y cliente. Una vez generado el reporte, podemos descargarlo a Excel y formato PDF.'
            ),
            array(
                'interaccion' => 'Generar reporte de residuos recolectados por gestor ambiental',
                'respuesta' => 'Para generar un reporte es necesario seleccionar el gestor ambiental, los datos de fecha inicio, fecha fin y cliente son opcionales. Una vez generado el reporte, podemos descargarlo a Excel y formato PDF.'
            ),
            array(
                'interaccion' => 'Generar reporte de cantidad total recolectada por categoría',
                'respuesta' => '. Una vez generado el reporte, podemos descargarlo a Excel y formato PDF.'
            ),
            array(
                'interaccion' => 'Registrar tipos de cliente',
                'respuesta' => 'Para añadir más tipos de cliente al sistema, debemos ir a Configuración -> Tipos de cliente y damos clic en agregar nuevo, allí debemos ingresar el nombre del nuevo tipo de cliente.'
            ),
            array(
                'interaccion' => 'Registrar nuevos estratos',
                'respuesta' => 'Para añadir más estratos al sistema, debemos ir a Configuración -> Estratos y damos clic en agregar nuevo, allí debemos ingresar el nombre del nuevo tipo de cliente.'
            ),
            array(
                'interaccion' => 'Registrar nuevos tipos de residuos',
                'respuesta' => 'Para añadir más tipos de residuos al sistema, debemos ir a Configuración -> Tipos de residuos y damos clic en agregar nuevo, allí debemos ingresar el color, código, nombre, disposición, validación de certificación de disposición, si usa contenedor y/o vehículo.'
            ),
            array(
                'interaccion' => 'Registrar nuevo contenedor',
                'respuesta' => 'Para añadir más contenedores al sistema, debemos ir a Configuración -> Contenedores y damos clic en agregar nuevo, allí debemos ingresar el nombre y el volumen en metros cúbicos.'
            ),
            array(
                'interaccion' => 'Registrar nuevo vehículo',
                'respuesta' => 'Para añadir más vehículos al sistema, debemos ir a Configuración -> Vehículos y damos clic en agregar nuevo, allí debemos ingresar el nombre y el volumen en metros cúbicos.'
            ),
            array(
                'interaccion' => 'Registrar nuevo tipo de disposición',
                'respuesta' => 'Para añadir más tipos de disposiciones al sistema, debemos ir a Configuración -> Tipos de disposiciones y damos clic en agregar nuevo, allí debemos ingresar el nombre y la disposición final.'
            ),
            array(
                'interaccion' => 'Registrar nueva empresa recolectora',
                'respuesta' => 'Para añadir más empresas recolectoras al sistema, debemos ir a Configuración -> Empresas recolectoras y damos clic en agregar nuevo, allí debemos ingresar el nombre de la empresa.'
            ),
            array(
                'interaccion' => 'Registrar nueva forma de pago',
                'respuesta' => 'Para añadir más formas de pago al sistema, debemos ir a Configuración -> Formas de pago y damos clic en agregar nuevo, allí debemos ingresar el nombre de la forma de pago y el período de pago en meses.'
            ),
            array(
                'interaccion' => 'Registrar nuevo tipo de capacitación',
                'respuesta' => 'Para añadir más tipos de capacitación al sistema, debemos ir a Configuración -> Tipos de capacitación y damos clic en agregar nuevo, allí debemos ingresar el nombre de la forma de pago y el período de pago en meses.'
            ),
            array(
                'interaccion' => 'Registrar nuevo tipo de soporte',
                'respuesta' => 'Para añadir más tipo de soporte al sistema, debemos ir a Configuración -> Tipo de soporte y damos clic en agregar nuevo, allí debemos ingresar el nombre del nuevo tipo de pago.'
            ),
            array(
                'interaccion' => 'Registrar nueva zona',
                'respuesta' => 'Para añadir más zonas al sistema, debemos ir a Configuración -> Zonas y damos clic en agregar nuevo, allí debemos seleccionar el municipio y el nombre de la zona.'
            ),
            array(
                'interaccion' => 'Consultar facturas',
                'respuesta' => 'Para visualizar o descargar las facturas, debemos ir a Facturación, acá podemos descargar la factura en formato PDF o visualizar sin necesidad de descargarla pero tenemos la opción de descargar también desde acá.'
            ),
        );

        $choices = array();
        foreach ($this->container->getParameter('security.role_hierarchy.roles') as $key => $rol) {
            if ($key != "ROLE_SONATA_ADMIN") {
                $choices["$rol[0]"] = $rol[0];
            }
        }
        $em = $this->container->get('doctrine')->getManager();
        foreach ($manuales as $manual) {
            $newManual = $em->getRepository('ModelBundle:ManualUsuario')->findOneByInteraccion($manual['interaccion']);
            if (!$newManual) {
                $newManual = new ManualUsuario();
            }
            $newManual->setInteraccion($manual['interaccion']);
            $newManual->setRespuesta($manual['respuesta']);
            $newManual->setRoles($choices);
            $manager->persist($newManual);
        }
        $manager->flush();
    }

}
