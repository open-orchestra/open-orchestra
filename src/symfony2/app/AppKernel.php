<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
//            new Doctrine\Bundle\MongoDBBundle\DoctrineMongoDBBundle(),
            new Mandango\MandangoBundle\MandangoBundle(),
            new Snc\RedisBundle\SncRedisBundle(),

            new Stfalcon\Bundle\TinymceBundle\StfalconTinymceBundle(),
            new FakeApp\ThemeBundle\FakeAppThemeBundle(),
            new Nelmio\SolariumBundle\NelmioSolariumBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),

            new PHPOrchestra\CMSBundle\PHPOrchestraCMSBundle(),
            new PHPOrchestra\ThemeBundle\PHPOrchestraThemeBundle(),
            new PHPOrchestra\ModelBundle\PHPOrchestraModelBundle(),
            new PHPOrchestraModel\MongoBundle\PHPOrchestraModelMongoBundle(),
            new PHPOrchestra\IndexationBundle\PHPOrchestraIndexationBundle(),
            );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
