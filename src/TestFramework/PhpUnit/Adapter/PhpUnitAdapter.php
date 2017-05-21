<?php

declare(strict_types=1);

namespace Infection\TestFramework\PhpUnit\Adapter;

use Infection\Finder\AbstractExecutableFinder;
use Infection\TestFramework\AbstractTestFrameworkAdapter;

class PhpUnitAdapter extends AbstractTestFrameworkAdapter
{
    const NAME = 'phpunit';

    public function testsPass(string $output): bool
    {
        if (preg_match('/failures!/i', $output)) {
            return false;
        }

        if (preg_match('/errors!/i', $output)) {
            return false;
        }

        // OK (XX tests, YY assertions)
        $isOk = (bool) preg_match('/OK\s\(/', $output);

        // "OK, but incomplete, skipped, or risky tests!"
        $isOkWithInfo = (bool) preg_match('/OK\s?,/', $output);

        return $isOk || $isOkWithInfo;
    }
}