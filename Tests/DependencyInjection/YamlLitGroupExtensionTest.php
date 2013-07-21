<?php


namespace LitGroup\Bundle\GearmanBundle\Tests\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class YamlLitGroupExtensionTest extends AbstractLitGroupGearmanExtensionTest
{
    protected function loadFromFile(ContainerBuilder $container, $file)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/Fixtures/config/yaml'));
        $loader->load($file.'.yml');
    }

}