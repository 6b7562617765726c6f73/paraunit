<?php

namespace Paraunit\Coverage;

use Paraunit\Proxy\Coverage\CloverResult;
use Paraunit\Proxy\Coverage\HtmlResult;
use Paraunit\Proxy\Coverage\XmlResult;

/**
 * Class CoverageResult
 * @package Paraunit\Coverage
 */
class CoverageResult
{
    /** @var  CoverageMerger */
    private $coverageMerger;

    /** @var  CoverageOutputPaths */
    private $coverageOutputPaths;

    /** @var  CloverResult */
    private $cloverResult;

    /** @var  XmlResult */
    private $xmlResult;

    /** @var  HtmlResult */
    private $htmlResult;

    /**
     * CoverageResult constructor.
     * @param CoverageMerger $coverageMerger
     * @param CoverageOutputPaths $coverageOutputPaths
     * @param CloverResult $cloverResult
     * @param XmlResult $xmlResult
     * @param HtmlResult $htmlResult
     */
    public function __construct(
        CoverageMerger $coverageMerger,
        CoverageOutputPaths $coverageOutputPaths,
        CloverResult $cloverResult,
        XmlResult $xmlResult,
        HtmlResult $htmlResult
    ) {
    
        $this->coverageMerger = $coverageMerger;
        $this->coverageOutputPaths = $coverageOutputPaths;
        $this->cloverResult = $cloverResult;
        $this->xmlResult = $xmlResult;
        $this->htmlResult = $htmlResult;
    }

    public function generateResults()
    {
        $coverageData = $this->coverageMerger->getCoverageData();

        $cloverFilePath = $this->coverageOutputPaths->getCloverFilePath();
        if (! $cloverFilePath->isEmpty()) {
            $this->cloverResult->process($coverageData, $cloverFilePath);
        }

        $xmlPath = $this->coverageOutputPaths->getXmlPath();
        if (! $xmlPath->isEmpty()) {
            $this->xmlResult->process($coverageData, $xmlPath);
        }

        $htmlPath = $this->coverageOutputPaths->getHtmlPath();
        if (! $htmlPath->isEmpty()) {
            $this->htmlResult->process($coverageData, $htmlPath);
        }
    }
}