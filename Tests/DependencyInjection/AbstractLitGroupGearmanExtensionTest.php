<?php

/**
 * This file is part of the LitGroupGearmanBundle package.
 *
 * (c) Roman Shamritskiy <roman@litgroup.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LitGroup\Bundle\GearmanBundle\Tests\DependencyInjection;


use LitGroup\Bundle\GearmanBundle\DependencyInjection\LitGroupGearmanExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

abstract class AbstractLitGroupGearmanExtensionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function testDefaults()
    {
        $container = $this->getContainer();
        $container->registerExtension($this->getExtension());
        $this->loadFromFile($container, 'default');
        $this->compileContainer($container);

        $this->assertEquals('GearmanClient', $container->getParameter('litgroup_gearman.client.class'));
        $this->assertEquals('GearmanWorker', $container->getParameter('litgroup_gearman.worker.class'));

        // Test client defaults:
        $client = $container->getDefinition('litgroup_gearman.client');
        $this->assertEquals('GearmanClient', $client->getClass());
        $this->assertEquals(
            [
                [ 'addServers', [ ['127.0.0.1:4703'] ] ]
            ],
            $client->getMethodCalls()
        );

        $worker = $container->getDefinition('litgroup_gearman.worker');
        $this->assertEquals('GearmanWorker', $worker->getClass());
        $this->assertEquals(
            [
                [ 'addServers', [ ['127.0.0.1:4703'] ] ]
            ],
            $worker->getMethodCalls()
        );
    }

    /**
     * @test
     */
    public function testServersList()
    {
        $container = $this->getContainer();
        $container->registerExtension($this->getExtension());
        $this->loadFromFile($container, 'servers');
        $this->compileContainer($container);

        $this->assertEquals('GearmanClient', $container->getParameter('litgroup_gearman.client.class'));
        $this->assertEquals('GearmanWorker', $container->getParameter('litgroup_gearman.worker.class'));

        $client = $container->getDefinition('litgroup_gearman.client');
        $this->assertEquals('GearmanClient', $client->getClass());
        $this->assertEquals(
            [
                [
                    'addServers',
                    [
                        [
                            '10.0.0.1:4703',
                            '10.0.0.2:4703'
                        ]
                    ]
                ],
            ],
            $client->getMethodCalls()
        );

        $worker = $container->getDefinition('litgroup_gearman.worker');
        $this->assertEquals('GearmanWorker', $worker->getClass());
        $this->assertEquals(
            [
                [
                    'addServers',
                    [
                        [
                            '10.0.0.1:4703',
                            '10.0.0.2:4703'
                        ]
                    ]
                ],
            ],
            $worker->getMethodCalls()
        );
    }

    /**
     * @test
     */
    public function testServersOverride()
    {
        $container = $this->getContainer();
        $extension = $this->getExtension();

        $extension->load(
            [
                ['servers' => []],
                ['servers' => ['10.0.0.1', '10.0.0.2']],
                ['servers' => ['192.168.1.1']],
            ],
            $container
        );

        $client = $container->getDefinition('litgroup_gearman.client');
        $this->assertEquals(
            [
                [ 'addServers', [ ['192.168.1.1'] ] ]
            ],
            $client->getMethodCalls()
        );

        $worker = $container->getDefinition('litgroup_gearman.worker');
        $this->assertEquals(
            [
                [ 'addServers', [ ['192.168.1.1'] ] ]
            ],
            $worker->getMethodCalls()
        );
    }

    /**
     * @return ContainerBuilder
     */
    protected function getContainer()
    {
        return new ContainerBuilder();
    }

    /**
     * @param ContainerBuilder $container
     */
    protected function compileContainer(ContainerBuilder $container)
    {
        $container->compile();
    }

    /**
     * @return LitGroupGearmanExtension
     */
    protected function getExtension()
    {
        return new LitGroupGearmanExtension();
    }

    abstract protected function loadFromFile(ContainerBuilder $container, $file);

}