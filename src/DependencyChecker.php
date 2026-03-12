<?php

namespace FontOptimizer;

use Composer\Script\Event;
use Symfony\Component\Process\Process;

class DependencyChecker
{
    public static function check(Event $event): void
    {
        $io      = $event->getIO();
        $process = new Process(['python3', '-m', 'fontTools.subset', '--help']);
        $process->run();
        $result  = $process->isSuccessful() ? true : null;

        if ($result !== true) {
            $io->writeError('');
            $io->writeError('<warning>⚠  font-optimizer requires Python3 + fontTools to work.</warning>');
            $io->writeError('<warning>   Run: sudo apt install -y python3 python3-fonttools python3-brotli</warning>');
            $io->writeError('');
        } else {
            $io->write('<info>✓  font-optimizer: Python3 + fontTools detected.</info>');
        }
    }
}