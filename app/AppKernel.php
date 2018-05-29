<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel {

    public function registerBundles() {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new FOS\RestBundle\FOSRestBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle($this),
            //API
            new Nelmio\ApiDocBundle\NelmioApiDocBundle(),
            //EXCEL
            new Liuggio\ExcelBundle\LiuggioExcelBundle(),
            //MAILER
            new Hip\MandrillBundle\HipMandrillBundle(),
            new Wrep\FOSUserBundleMandrillMailer\FOSUserBundleMandrillMailerBundle(),
            //PDF
            new Knp\Bundle\SnappyBundle\KnpSnappyBundle(),
            //PAGINATOR
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            //ADMIN GENERATOR
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Sonata\AdminBundle\SonataAdminBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            //USUARIOS
            new FOS\UserBundle\FOSUserBundle(),
            new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),
            new Sonata\UserBundle\SonataUserBundle('FOSUserBundle'),
            //BUNDLES DE LA APLICACION
            new ModelBundle\ModelBundle(),
            new BackendBundle\BackendBundle(),
            new FrontendBundle\FrontendBundle(),
            new Sonata\IntlBundle\SonataIntlBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'), true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader) {
        $loader->load($this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml');
    }

}
