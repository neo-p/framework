<?php declare(strict_types=1);

namespace NeoP\Stdlib;

use Composer\Autoload\ClassLoader;
use RuntimeException;
use function file_exists;
use function file_get_contents;
use function is_array;
use function is_object;
use function json_decode;
use function spl_autoload_functions;

class Composer
{

    /**
     * @var ClassLoader
     */
    private static $autoLoader;

    public static function getClassLoader(): ClassLoader
    {
        if (self::$autoLoader) {
            return self::$autoLoader;
        }

        $autoloadFunctions = spl_autoload_functions();

        foreach ($autoloadFunctions as $autoloader) {
            if (is_array($autoloader) && isset($autoloader[0])) {
                $composerLoader = $autoloader[0];

                if (is_object($composerLoader) && $composerLoader instanceof ClassLoader) {
                    self::$autoLoader = $composerLoader;
                    return self::$autoLoader;
                }
            }
        }

        throw new RuntimeException('Composer ClassLoader not found!');
    }

    public static function parseLockFile(string $file, callable $filter = null): array
    {
        if (!file_exists($file)) {
            return [];
        }

        if (!$json = file_get_contents($file)) {
            return [];
        }

        $data = json_decode($json, true);
        if (!$data || !isset($data['packages'])) {
            return [];
        }

        $packages = [];
        foreach ($data['packages'] as $pkg) {
            if ($filter && false === $filter($pkg['name'], $pkg['type'])) {
                continue;
            }

            $packages[] = $pkg;
        }

        return $packages;
    }
}