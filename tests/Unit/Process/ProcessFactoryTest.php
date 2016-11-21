<?php

namespace Tests\Unit\Process;

use Paraunit\Process\ProcessFactory;

/**
 * Class ProcessFactoryTest
 * @package Tests\Unit\Process
 */
class ProcessFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateProcess()
    {
        $PHPUnitConfig = $this->prophesize('Paraunit\Configuration\PHPUnitConfig');
        $cliCommand = $this->prophesize('Paraunit\Process\CliCommandInterface');
        $cliCommand->getExecutable()->willReturn('executable');
        $cliCommand
            ->getOptions($PHPUnitConfig->reveal(), md5('TestTest.php'))
            ->willReturn('--configuration');

        $factory = new ProcessFactory($cliCommand->reveal());
        $factory->setPHPUnitConfig($PHPUnitConfig->reveal());

        $process = $factory->createProcess('TestTest.php');

        $this->assertInstanceOf('Paraunit\Process\AbstractParaunitProcess', $process);
        $expectedCmdLine = 'executable --configuration TestTest.php';
        $this->assertEquals($expectedCmdLine, $process->getCommandLine());
    }
}
