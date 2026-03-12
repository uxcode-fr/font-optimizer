<?php

namespace FontOptimizer;

final class Config
{
    public readonly string $source;
    public readonly string $destination;
    public readonly string $unicodes;
    public readonly string $features;
    public readonly string $flavor;
    public readonly string $nameIds;
    public readonly bool   $hinting;

    private function __construct(array $data)
    {
        $this->source      = $data['source']      ?? 'resources/fonts';
        $this->destination = $data['destination'] ?? 'public/fonts';
        $this->unicodes    = $data['unicodes']     ?? 'U+0020-007F,U+00A0-00FF,U+0152-0153';
        $this->features    = $data['features']     ?? 'kern,liga';
        $flavor = $data['flavor'] ?? 'woff2';
        if (!in_array($flavor, ['woff', 'woff2'], true)) {
            throw new \InvalidArgumentException("Invalid flavor \"$flavor\". Allowed values: woff, woff2.");
        }
        $this->flavor      = $flavor;
        $this->nameIds     = $data['name_ids']     ?? '*';
        $this->hinting     = $data['hinting']      ?? true;
    }

    public static function load(string $projectRoot): self
    {
        // Priority 1: config/font-optimizer.php (Laravel, Symfony, vanilla PHP)
        $phpConfig = $projectRoot . '/config/font-optimizer.php';
        if (is_file($phpConfig)) {
            $data = require $phpConfig;
            return new self(is_array($data) ? $data : []);
        }

        // Priority 2: composer.json extra section (fallback)
        $composerConfig = $projectRoot . '/composer.json';
        if (is_file($composerConfig)) {
            $data = json_decode(file_get_contents($composerConfig), true, 512, JSON_THROW_ON_ERROR);
            return new self($data['extra']['font-optimizer'] ?? []);
        }

        return new self([]);
    }
}