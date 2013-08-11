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

use Symfony\Component\Config\Definition\Processor;
use LitGroup\Bundle\GearmanBundle\DependencyInjection\Configuration;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /** @var Processor */
    private $processor;
    /** @var Configuration */
    private $configuration;


    protected function setUp()
    {
        $this->processor     = new Processor;
        $this->configuration = new Configuration;
    }

    protected function tearDown()
    {
        $this->processor     = null;
        $this->configuration = null;
    }

    /**
     * @test
     */
    public function testMissingConfiguration()
    {
        $expected = [
            'servers' => [
                '127.0.0.1:4730'
            ]
        ];

        $this->assertEquals($expected, $this->processConfiguration([]));
    }

    /**
     * @test
     */
    public function testEmptyListOfServers()
    {
        $expected = [
            'servers' => [
                '127.0.0.1:4730'
            ]
        ];

        $configs = [
            [
                'servers' => []
            ]
        ];

        $this->assertEquals($expected, $this->processConfiguration($configs));
    }

    public function getMergingListOfServersTests()
    {
        return [

            // Test #1
            [
                // Expected:
                [ 'servers' => [ '10.0.0.1:4730', '10.0.0.2:4731', '10.0.0.3' ] ],
                // Configs:
                [
                    [ 'servers' => [ '192.168:4730' ] ],
                    [ 'servers' => [ '10.0.0.1:4730', '10.0.0.2:4731', '10.0.0.3' ] ]
                ]
            ],

            // Test #2
            [
                // Expected:
                [ 'servers' => [ '127.0.0.1:4730' ] ],
                // Configs:
                [
                    [ 'servers' => [ '192.168:4730' ] ],
                    [ 'servers' => [] ]
                ]
            ],

            // Test #3
            [
                // Expected:
                [ 'servers' => [ '10.0.0.1:4730', '10.0.0.2:4730', '10.0.0.3' ] ],
                // Configs:
                [
                    [ 'servers' => [ '192.168:4730' ] ],
                    [ 'servers' => [ '10.0.0.1:4730', '10.0.0.2:4730', '10.0.0.3' ] ],
                    [ ]
                ]
            ],
        ];

    }

    /**
     * @test
     * @dataProvider getMergingListOfServersTests()
     */
    public function testMergingListOfServers($config, $configs)
    {
        $this->assertEquals($config, $this->processConfiguration($configs));
    }

    /**
     * @param array $configs
     * @return array
     */
    private function processConfiguration(array $configs)
    {
        return $this->processor->processConfiguration($this->configuration, $configs);
    }
}