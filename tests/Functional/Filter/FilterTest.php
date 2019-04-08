<?php

declare(strict_types=1);

namespace Tests\Functional\Filter;

use Paraunit\Filter\Filter;
use Tests\BaseFunctionalTestCase;

class FilterTest extends BaseFunctionalTestCase
{
    protected function setup(): void
    {
        $this->setOption('configuration', $this->getStubPath() . DIRECTORY_SEPARATOR . 'phpunit_with_2_testsuites.xml');
        $this->setOption('testsuite', 'suite1,suite2');

        parent::setup();
    }

    public function testFilterTestFiles(): void
    {
        /** @var Filter $filter */
        $filter = $this->getService(Filter::class);

        $this->assertCount(2, $filter->filterTestFiles());
    }
}
