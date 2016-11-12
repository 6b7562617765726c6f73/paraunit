<?php

namespace Tests\Unit\Configuration;

use Paraunit\Configuration\TempFilenameFactory;
use Paraunit\File\TempDirectory;

/**
 * Class TempFilenameFactoryTest
 * @package Tests\Unit\Configuration
 */
class TempFilenameFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testGetFilenameForLog()
    {
        $processUniqueId = 'asdasdasdasd';
        $tempDir = new TempDirectory();
        $tempFileNameFactory = new TempFilenameFactory($tempDir);

        $tempFileNameFactory = $tempFileNameFactory->getFilenameForLog($processUniqueId);

        $expected = $tempDir->getTempDirForThisExecution() . '/logs/' . $processUniqueId . '.json.log';
        $this->assertEquals($expected, $tempFileNameFactory);
    }

    public function testGetFilenameForCoverage()
    {
        $processUniqueId = 'asdasdasdasd';
        $tempDir = new TempDirectory();
        $tempFileNameFactory = new TempFilenameFactory($tempDir);

        $tempFileNameFactory = $tempFileNameFactory->getFilenameForCoverage($processUniqueId);

        $expected = $tempDir->getTempDirForThisExecution() . '/coverage/' . $processUniqueId . '.php';
        $this->assertEquals($expected, $tempFileNameFactory);
    }
}
