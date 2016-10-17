<?php

namespace Paraunit\Coverage;

use Paraunit\Configuration\PHPUnitConfigFile;
use SebastianBergmann\CodeCoverage\Filter;

/**
 * Class CoverageFilter
 * @package Paraunit\Coverage
 */
class CoverageFilterBuilder
{
    /** @var  Filter */
    private $codeCoverageFilter;

    /**
     * CoverageFilterBuilder constructor.
     */
    public function __construct()
    {
        $this->codeCoverageFilter = new Filter();
    }

    public function createFromConfiguration(PHPUnitConfigFile $configFile)
    {
        $filterConfiguration = \PHPUnit_Util_Configuration::getInstance($configFile->getFileFullPath());

        foreach ($filterConfiguration['whitelist']['include']['directory'] as $dir) {
            $this->codeCoverageFilter->addDirectoryToWhitelist(
                $dir['path'],
                $dir['suffix'],
                $dir['prefix']
            );
        }

        foreach ($filterConfiguration['whitelist']['include']['file'] as $file) {
            $this->codeCoverageFilter->addFileToWhitelist($file);
        }

        foreach ($filterConfiguration['whitelist']['exclude']['directory'] as $dir) {
            $this->codeCoverageFilter->removeDirectoryFromWhitelist(
                $dir['path'],
                $dir['suffix'],
                $dir['prefix']
            );
        }

        foreach ($filterConfiguration['whitelist']['exclude']['file'] as $file) {
            $this->codeCoverageFilter->removeFileFromWhitelist($file);
        }

        return $this->codeCoverageFilter;
    }
}
