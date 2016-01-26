<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * Class AppKernel
 */
class AppKernel extends Kernel
{
    /**
     * @return array|\Symfony\Component\HttpKernel\Bundle\BundleInterface[]
     */
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

            new JMS\SerializerBundle\JMSSerializerBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new FOS\HttpCacheBundle\FOSHttpCacheBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),

            new Braincrafted\Bundle\BootstrapBundle\BraincraftedBootstrapBundle(),

            new OpenOrchestra\BaseBundle\OpenOrchestraBaseBundle(),
            new OpenOrchestra\BaseApiMongoModelBundle\OpenOrchestraBaseApiMongoModelBundle(),
            new OpenOrchestra\BaseApiBundle\OpenOrchestraBaseApiBundle(),
            new OpenOrchestra\UserBundle\OpenOrchestraUserBundle(),
            new OpenOrchestra\ModelBundle\OpenOrchestraModelBundle(),
            new OpenOrchestra\MongoBundle\OpenOrchestraMongoBundle(),
            new OpenOrchestra\MediaBundle\OpenOrchestraMediaBundle(),
            new OpenOrchestra\MediaModelBundle\OpenOrchestraMediaModelBundle(),
            new OpenOrchestra\WorkflowFunctionModelBundle\OpenOrchestraWorkflowFunctionModelBundle(),
            new OpenOrchestra\WorkflowFunctionBundle\OpenOrchestraWorkflowFunctionBundle(),

            new OpenOrchestra\ApiBundle\OpenOrchestraApiBundle(),
            new OpenOrchestra\DisplayBundle\OpenOrchestraDisplayBundle(),
            new OpenOrchestra\BBcodeBundle\OpenOrchestraBBcodeBundle(),
            new OpenOrchestra\BackofficeBundle\OpenOrchestraBackofficeBundle(),
            new OpenOrchestra\GroupBundle\OpenOrchestraGroupBundle(),
            new OpenOrchestra\LogBundle\OpenOrchestraLogBundle(),
            new OpenOrchestra\UserAdminBundle\OpenOrchestraUserAdminBundle(),
            new OpenOrchestra\MediaAdminBundle\OpenOrchestraMediaAdminBundle(),
            new OpenOrchestra\MediaFileBundle\OpenOrchestraMediaFileBundle(),
            new OpenOrchestra\WorkflowFunctionAdminBundle\OpenOrchestraWorkflowFunctionAdminBundle(),

            // Need parameters set by some of our bundles
            new Stfalcon\Bundle\TinymceBundle\StfalconTinymceBundle(),
            new Knp\Bundle\GaufretteBundle\KnpGaufretteBundle(),
            new Solution\MongoAggregationBundle\SolutionMongoAggregationBundle(),
            new OpenOrchestra\ModelLogBundle\OpenOrchestraModelLogBundle(),
            new OpenOrchestra\ElasticaBundle\OpenOrchestraElasticaBundle(),
            new OpenOrchestra\ElasticaAdminBundle\OpenOrchestraElasticaAdminBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    /**
     * @param LoaderInterface $loader
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
