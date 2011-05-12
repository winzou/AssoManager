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
            new Symfony\Bundle\DoctrineBundle\DoctrineBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
            
            new FOS\UserBundle\FOSUserBundle(),
            
            /** @todo Make this bundle working !
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            */
            
            new winzou\BookBundle\winzouBookBundle(),
            
            new Asso\AMBundle\AssoAMBundle(),
            new Asso\SiteBundle\AssoSiteBundle(),
            new Asso\BookBundle\AssoBookBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            
            /** @todo Activate this debugging bundle
            $bundles[] = new JMS\DebuggingBundle\JMSDebuggingBundle($this);
            */
            
            /** @todo Check if this bundle is really useless
            $bundles[] = new Symfony\Bundle\WebConfiguratorBundle\SymfonyWebConfiguratorBundle();
            */
            
            /** @todo Make this bundle working !
            $bundles[] = new Elao\WebProfilerExtraBundle\WebProfilerExtraBundle();
            */
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
    
    /** @todo Uncomment on DebuggingBundle reactivation
    protected function getContainerBaseClass()
    {
        if ($this->isDebug()) {
            return '\JMS\DebuggingBundle\DependencyInjection\TraceableContainer';
        }
    
        return parent::getContainerBaseClass();
    }
    */
}
