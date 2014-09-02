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

            new Doctrine\Bundle\MongoDBBundle\DoctrineMongoDBBundle(),
            new Snc\RedisBundle\SncRedisBundle(),

            new Stfalcon\Bundle\TinymceBundle\StfalconTinymceBundle(),
            new Nelmio\SolariumBundle\NelmioSolariumBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),

            new Braincrafted\Bundle\BootstrapBundle\BraincraftedBootstrapBundle(),

            new PHPOrchestra\BaseBundle\PHPOrchestraBaseBundle(),
            new PHPOrchestra\CMSBundle\PHPOrchestraCMSBundle(),
            new PHPOrchestra\ModelBundle\PHPOrchestraModelBundle(),
            new PHPOrchestra\IndexationBundle\PHPOrchestraIndexationBundle(),
            new PHPOrchestra\TranslationBundle\PHPOrchestraTranslationBundle(),
            new PHPOrchestra\ApiBundle\PHPOrchestraApiBundle(),
            new PHPOrchestra\DisplayBundle\PHPOrchestraDisplayBundle(),
            new PHPOrchestra\BackofficeBundle\PHPOrchestraBackofficeBundle(),

            // Need parameters set by some of our bundles
            new Lexik\Bundle\TranslationBundle\LexikTranslationBundle(),
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
