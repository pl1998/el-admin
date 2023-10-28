<?php

declare(strict_types=1);

/*
 * This file is part of the latent/el-admin.
 *
 * (c) latent<pltrueover@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Latent\ElAdmin\Support;

use Exception;
use Symfony\Component\Process\Process;

class ShellCommand
{
    /**
     * Build commands.
     *
     * @throws Exception
     */
    public static function execute($cmd): string
    {
        $process = Process::fromShellCommandline($cmd);
        $processOutput = '';

        $captureOutput = function ($type, $line) use (&$processOutput) {
            $processOutput .= $line;
        };

        $process->setTimeout(null)
            ->run($captureOutput);

        if ($process->getExitCode()) {
            $exception = new Exception($cmd.'-'.$processOutput);
            report($exception);
            throw new $exception();
        }

        return $processOutput;
    }
}
