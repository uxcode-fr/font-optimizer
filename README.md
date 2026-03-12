# Font Optimizer

**Automate your web typography workflow with this Composer dev-tool.**

Converts TTF fonts to optimized WOFF2 subsets using Python FontTools.
Works with **Laravel**, **Symfony**, and **vanilla PHP** projects.

---

## Prerequisites

Requires **Python 3** and **FontTools** with **Brotli** support on your system.

```bash
# Ubuntu / Debian
sudo apt update && sudo apt install -y python3 python3-fonttools python3-brotli

# macOS
brew install python3 && pip3 install fonttools brotli
```

---

## Installation

```bash
composer require --dev uxcode-fr/font-optimizer
```

The binary is available at `vendor/bin/font-optimizer`.

---

## Configuration

Configuration is loaded from **`config/font-optimizer.php`** if present, otherwise from the `extra` section of `composer.json`.

### Option A — `config/font-optimizer.php` (Laravel, Symfony, vanilla PHP)

**Laravel** — publish the default config:

```bash
php artisan vendor:publish --tag=font-optimizer-config
```

**Other projects** — create the file manually at the root of your project:

```php
<?php

return [
    'source'      => 'resources/fonts',              // directory containing .ttf source files
    'destination' => 'public/fonts',                 // directory where output files will be saved
    'unicodes'    => 'U+0020-007F,U+00A0-00FF,U+0152-0153', // Unicode ranges to subset
    'features'    => 'kern,liga',                    // OpenType features to preserve
    'flavor'      => 'woff2',                        // output format: woff2 or woff
    'name_ids'    => '*',                            // name table IDs to keep (* = all)
    'hinting'     => true,                           // keep hinting instructions
];
```

### Option B — `composer.json` `extra` section (all projects)

```json
{
    "extra": {
        "font-optimizer": {
            "source":      "resources/fonts",
            "destination": "public/fonts",
            "unicodes":    "U+0020-007F,U+00A0-00FF,U+0152-0153",
            "features":    "kern,liga",
            "flavor":      "woff2",
            "name_ids":    "*",
            "hinting":     true
        }
    }
}
```

### Configuration options

| Key           | Description                                      | Allowed values                                                         | Default                      |
|---------------|--------------------------------------------------|------------------------------------------------------------------------|------------------------------|
| `source`      | Directory containing your source `.ttf` files    | Any path relative to the project root                                  | `resources/fonts`            |
| `destination` | Directory where output files will be saved       | Any path relative to the project root                                  | `public/fonts`               |
| `unicodes`    | Unicode ranges to include in the subset          | Hex codepoints or ranges (`U+0020-007F`), comma-separated, or `*`      | Basic Latin + Latin-1 + `Œœ` |
| `features`    | OpenType layout features to preserve             | See [OpenType feature tags](#opentype-feature-tags), comma-separated, or `*` | `kern,liga`             |
| `flavor`      | Output font format                               | `woff2`, `woff`                                                        | `woff2`                      |
| `name_ids`    | Name table record IDs to keep                    | Comma-separated IDs (0–19), or `*`                                     | `*`                          |
| `hinting`     | Keep hinting instructions                        | `true`, `false`                                                        | `true`                       |

### OpenType feature tags

| Tag    | Description                                         |
|--------|-----------------------------------------------------|
| `kern` | Kerning adjustments between glyph pairs             |
| `liga` | Standard ligatures (fi, fl, ff…)                    |
| `clig` | Contextual ligatures                                |
| `calt` | Contextual alternates                               |
| `ccmp` | Glyph composition / decomposition                   |
| `locl` | Localized forms (language-specific glyph variants)  |
| `mark` | Mark positioning (diacritic placement)              |
| `mkmk` | Mark-to-mark positioning                            |
| `case` | Case-sensitive forms (punctuation for all-caps)     |
| `frac` | Diagonal fractions (1/2, 3/4)                       |
| `sups` | Superscript                                         |
| `subs` | Subscript                                           |
| `smcp` | Small capitals                                      |
| `onum` | Oldstyle figures                                    |
| `tnum` | Tabular figures                                     |
| `zero` | Slashed zero                                        |
| `ss01`–`ss20` | Stylistic sets                               |

### Unicode range examples

| Range                | Characters                              |
|----------------------|-----------------------------------------|
| `U+0020-007F`        | Basic Latin (ASCII printable)           |
| `U+00A0-00FF`        | Latin-1 Supplement (accented, ©, €…)   |
| `U+0100-017F`        | Latin Extended-A (Œœ, Šš, Žž…)        |
| `U+0400-04FF`        | Cyrillic                                |
| `U+0370-03FF`        | Greek and Coptic                        |
| `U+2000-206F`        | General Punctuation (—, …, ", "…)      |
| `U+20A0-20CF`        | Currency Symbols (€, £, ¥…)            |

---

## Usage

```bash
vendor/bin/font-optimizer
```

Output example:

```
🗜️ Optimizing Inter-Regular.ttf (312 KB)...
  ✓ inter-regular.woff2 (28 KB, -91%)
🗜️ Optimizing Inter-Bold.ttf (318 KB)...
  ✓ inter-bold.woff2 (30 KB, -91%)
```

### Composer shortcut (optional)

Add to your `composer.json`:

```json
{
    "scripts": {
        "fonts": "vendor/bin/font-optimizer"
    }
}
```

Then run:

```bash
composer fonts
```

---

## Why use this?

- **Performance** — reduces font file size by up to **70–90%** via WOFF2 and Unicode subsetting.
- **Automation** — no more manual CLI commands or online converters.
- **Consistency** — every developer on your team uses the same optimization settings.

---

## Contributing

Feel free to fork this repo and submit pull requests.
For major changes, please open an issue first.

**License**: [MIT](https://choosealicense.com/licenses/mit/)