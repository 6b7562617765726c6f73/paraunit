<?php

namespace Paraunit\File;

/**
 * Class TempDirectory
 * @package Paraunit\File
 */
class TempDirectory
{
    /** @var string[] */
    private static $tempDirs = array(
        '/dev/shm',
    );

    /** @var string */
    private $timestamp;

    /**
     * Paraunit constructor.
     */
    public function __construct()
    {
        $this->timestamp = uniqid(date('Ymd-His'), true);
    }

    /**
     * @return string
     */
    public function getTempDirForThisExecution()
    {
        $dir = self::getTempBaseDir() . DIRECTORY_SEPARATOR . $this->timestamp;
        self::mkdirIfNotExists($dir);
        self::mkdirIfNotExists($dir . DIRECTORY_SEPARATOR . 'logs');
        self::mkdirIfNotExists($dir . DIRECTORY_SEPARATOR . 'coverage');

        return $dir;
    }

    /**
     * @return string
     *
     * @throws \RuntimeException
     */
    public static function getTempBaseDir()
    {
        $dirs = self::$tempDirs;
        // Fallback to sys temp dir
        $dirs[] = sys_get_temp_dir();

        foreach ($dirs as $directory) {
            if (file_exists($directory)) {
                $baseDir = $directory . DIRECTORY_SEPARATOR . 'paraunit';

                try {
                    self::mkdirIfNotExists($baseDir);

                    return $baseDir;
                } catch (\RuntimeException $e) {
                    // ignore and try next dir
                }
            }
        }

        throw new \RuntimeException('Unable to create a temporary directory');
    }

    /**
     * @param string $path
     *
     * @throws \RuntimeException
     */
    private static function mkdirIfNotExists($path)
    {
        if (file_exists($path)) {
            return;
        }

        if (!mkdir($path) && !is_dir($path)) {
            throw new \RuntimeException(
                sprintf('Unable to create temporary directory \'%s\'.', $path)
            );
        }
    }
}
