<?php

namespace OpenOrchestra\BackofficeBundle\Tests\Functional\DependencyInjection;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractKernelTestCase;

/**
 * Class ContextManagerClassTest
 *
 * @group integrationTest
 */
class ContextManagerClassTest extends AbstractKernelTestCase
{
    /**
     * @param string $classExpected
     * @param string $env
     * @param bool   $debug
     *
     * @dataProvider provideClassAndOptions
     */
    public function testDifferentEnv($classExpected, $env, $debug)
    {
        $kernel = static::createKernel(array('environment' => $env ,'debug' => $debug));
        $kernel->boot();
        $this->assertInstanceOf(
            $classExpected,
            $kernel->getContainer()->get('open_orchestra_backoffice.context_manager')
        );
    }

    /**
     * @return array
     */
    public function provideClassAndOptions()
    {
        return array(
            array('OpenOrchestra\Backoffice\Context\TestContextManager', 'test', true),
        );
    }
}
