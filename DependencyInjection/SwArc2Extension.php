<?php

namespace Sw\Arc2Bundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This class will load the configuration. 
 *
 * @author Thibaut
 */
class SwArc2Extension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $this->bindParameter($container, 'sw_arc2', $config); 
        
        $container->setParameter('sw_arc2.sparql.class', 'Sw\Arc2Bundle\SparqlEndpoint\SparqlEndpoint');

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
    
    /**
     * Set the given parameter (and children) to the given container
     *
     * @param ContainerBuilder $container
     * @param string $name
     * @param mixed $value
     */
    private function bindParameter(ContainerBuilder $container, $name, $value)
    {
        if (is_array($value))
        {
            foreach ($value as $index => $val)
            {
                $this->bindParameter($container, $name. '.' .$index, $val);
            }
        }
        else
        {
            $container->setParameter($name, $value);
        }
    }
}
