<?php

namespace FontOptimizer\Command;

use FontOptimizer\Config;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

#[AsCommand(name: 'optimize', description: 'Converts and subsets TTF fonts to WOFF2')]
class OptimizeCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $config  = Config::load(getcwd());
        $srcDir  = $this->safePath(getcwd(), $config->source);
        $destDir = $this->safePath(getcwd(), $config->destination);

        if (!$this->isFontToolsAvailable()) {
            $output->writeln('<error>❌ Error: Python3 or fontTools is missing.</error>');
            $output->writeln('<info>Run: sudo apt update && sudo apt install -y python3 python3-fonttools python3-brotli</info>');
            return Command::FAILURE;
        }

        $fonts = is_dir($srcDir) ? (glob("$srcDir/*.ttf") ?: []) : [];
        if (empty($fonts)) {
            $output->writeln("<comment>No .ttf font found in $srcDir</comment>");
            return Command::SUCCESS;
        }

        if (!is_dir($destDir) && !mkdir($destDir, 0755, true) && !is_dir($destDir)) {
            throw new \RuntimeException(sprintf('Failed to create directory "%s"', $destDir));
        }

        foreach ($fonts as $font) {
            $this->convertFont($font, $destDir, $config, $output);
        }

        return Command::SUCCESS;
    }

    private function safePath(string $root, string $relative): string
    {
        $resolved = realpath($root) . '/' . ltrim($relative, '/');
        $real     = realpath($resolved) ?: $resolved;

        if (!str_starts_with($real, realpath($root) . '/') && $real !== realpath($root)) {
            throw new \RuntimeException("Path \"$relative\" escapes the project root.");
        }

        return $resolved;
    }

    private function isFontToolsAvailable(): bool
    {
        $check = new Process(['python3', '-m', 'fontTools.subset', '--help']);
        $check->run();
        return $check->isSuccessful();
    }

    private function convertFont(string $font, string $destDir, Config $config, OutputInterface $output): void
    {
        $filename    = strtolower(str_replace(['_', ' '], '-', basename($font, '.ttf')));
        $outputFile  = "$destDir/$filename.{$config->flavor}";
        $originalSize = round(filesize($font) / 1024, 2);

        $output->writeln('🗜️ Optimizing <info>' . basename($font) . '</info> (' . $originalSize . ' KB)...');

        $process = new Process(array_filter([
            'python3', '-m', 'fontTools.subset', $font,
            "--unicodes={$config->unicodes}",
            "--flavor={$config->flavor}",
            "--output-file=$outputFile",
            "--layout-features={$config->features}",
            "--name-IDs={$config->nameIds}",
            $config->hinting ? null : '--no-hinting',
        ]));
        $process->run();

        if ($process->isSuccessful()) {
            $finalSize = round(filesize($outputFile) / 1024, 2);
            $saving    = round((1 - $finalSize / $originalSize) * 100);
            $output->writeln("  <fg=green>✓</> $filename.{$config->flavor} ($finalSize KB, -$saving%)");
        } else {
            $output->writeln('  <error>✗</> Error on ' . basename($font));
            $output->writeln($process->getErrorOutput());
        }
    }
}