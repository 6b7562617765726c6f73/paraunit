<?php
declare(strict_types=1);

namespace Tests\Unit\Coverage;

use Paraunit\Coverage\CoverageFetcher;
use Paraunit\Coverage\CoverageMerger;
use Paraunit\Lifecycle\ProcessEvent;
use Paraunit\Proxy\Coverage\CodeCoverage;
use Tests\BaseUnitTestCase;
use Tests\Stub\StubbedParaunitProcess;

/**
 * Class CoverageMergerTest
 * @package Tests\Unit\Coverage
 */
class CoverageMergerTest extends BaseUnitTestCase
{
    public function testMergeFirstCoverageData()
    {
        $process = new StubbedParaunitProcess();

        $newCoverageData = $this->prophesize(CodeCoverage::class);

        $fetcher = $this->prophesize(CoverageFetcher::class);
        $fetcher->fetch($process)
            ->shouldBeCalledTimes(1)
            ->willReturn($newCoverageData->reveal());

        $merger = new CoverageMerger($fetcher->reveal());

        $merger->onProcessParsingCompleted(new ProcessEvent($process));

        $this->assertSame($newCoverageData->reveal(), $merger->getCoverageData());
    }

    public function testMergeNextCoverageData()
    {
        $process1 = new StubbedParaunitProcess('test1');
        $process2 = new StubbedParaunitProcess('test2');

        $coverageData1 = $this->prophesize(CodeCoverage::class);
        $coverageData2 = $this->prophesize(CodeCoverage::class);

        $fetcher = $this->prophesize(CoverageFetcher::class);
        $fetcher->fetch($process1)
            ->shouldBeCalledTimes(1)
            ->willReturn($coverageData1->reveal());
        $fetcher->fetch($process2)
            ->shouldBeCalledTimes(1)
            ->willReturn($coverageData2->reveal());
        $coverageData1->merge($coverageData2->reveal())
            ->shouldBeCalledTimes(1)
            ->willReturn();

        $merger = new CoverageMerger($fetcher->reveal());

        $merger->onProcessParsingCompleted(new ProcessEvent($process1));

        $this->assertSame($coverageData1->reveal(), $merger->getCoverageData());

        $merger->onProcessParsingCompleted(new ProcessEvent($process2));

        $this->assertSame($coverageData1->reveal(), $merger->getCoverageData());
    }
}
