<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Support;

use Symfony\Component\Process\Process;
use Exception;

class ShellCommand
{
    /**
     * 执行命令.
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
