<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Source directory
    |--------------------------------------------------------------------------
    | Directory containing the .ttf font files to process, relative to the
    | project root.
    */
    'source' => 'resources/fonts',

    /*
    |--------------------------------------------------------------------------
    | Destination directory
    |--------------------------------------------------------------------------
    | Directory where the optimized .woff2 files will be saved, relative to
    | the project root.
    */
    'destination' => 'public/fonts',

    /*
    |--------------------------------------------------------------------------
    | Unicode ranges
    |--------------------------------------------------------------------------
    | Comma-separated list of Unicode codepoints or ranges to include in the
    | subset. Accepts hex values with or without the "U+" prefix.
    | Use "*" to include the entire character set (no subsetting).
    |
    | Common ranges:
    |   U+0020-007F   Basic Latin (ASCII printable)
    |   U+00A0-00FF   Latin-1 Supplement (accented chars, €, ©, etc.)
    |   U+0100-017F   Latin Extended-A (ŒœŠšŽž, etc.)
    |   U+0180-024F   Latin Extended-B
    |   U+0250-02AF   IPA Extensions
    |   U+02B0-02FF   Spacing Modifier Letters
    |   U+0300-036F   Combining Diacritical Marks
    |   U+0370-03FF   Greek and Coptic
    |   U+0400-04FF   Cyrillic
    |   U+2000-206F   General Punctuation (", ", —, …, etc.)
    |   U+2070-209F   Superscripts and Subscripts
    |   U+20A0-20CF   Currency Symbols (€, £, ¥, etc.)
    |   U+2100-214F   Letterlike Symbols (™, ℃, №, etc.)
    |   U+2190-21FF   Arrows
    |   U+2200-22FF   Mathematical Operators
    |
    | Default covers Basic Latin + Latin-1 Supplement + Œœ (French).
    */
    'unicodes' => 'U+0020-007F,U+00A0-00FF,U+0152-0153',

    /*
    |--------------------------------------------------------------------------
    | OpenType layout features
    |--------------------------------------------------------------------------
    | Comma-separated list of OpenType feature tags to preserve.
    | Use "*" to keep all features, or prefix with "+" / "-" to add or remove
    | features relative to the default set.
    |
    | Common features:
    |   kern   Kerning adjustments between glyph pairs
    |   liga   Standard ligatures (fi, fl, ff, etc.)
    |   clig   Contextual ligatures
    |   calt   Contextual alternates
    |   ccmp   Glyph composition / decomposition
    |   locl   Localized forms (language-specific glyph variants)
    |   mark   Mark positioning (diacritic placement)
    |   mkmk   Mark-to-mark positioning
    |   case   Case-sensitive forms (punctuation for all-caps)
    |   cpsp   Capital spacing
    |   frac   Diagonal fractions (1/2, 3/4)
    |   numr   Numerators
    |   dnom   Denominators
    |   ordn   Ordinals (1ª, 2º)
    |   sups   Superscript
    |   subs   Subscript
    |   sinf   Scientific inferiors
    |   smcp   Small capitals
    |   c2sc   Capitals to small capitals
    |   onum   Oldstyle figures
    |   lnum   Lining figures
    |   pnum   Proportional figures
    |   tnum   Tabular figures
    |   zero   Slashed zero
    |   ss01–ss20  Stylistic sets
    |
    | Default preserves kerning and standard ligatures.
    */
    'features' => 'kern,liga',

    /*
    |--------------------------------------------------------------------------
    | Output flavor
    |--------------------------------------------------------------------------
    | Format of the generated font file.
    |
    | Allowed values:
    |   woff2  (recommended) Compressed, supported by all modern browsers
    |   woff   Legacy format, wider compatibility with older browsers
    |
    | Leave null to output a plain OpenType/TrueType file (rarely needed).
    */
    'flavor' => 'woff2',

    /*
    |--------------------------------------------------------------------------
    | Name IDs
    |--------------------------------------------------------------------------
    | Comma-separated list of OpenType name table record IDs to keep.
    | Use "*" to retain all records.
    |
    | Standard IDs:
    |   0   Copyright notice
    |   1   Font family name
    |   2   Font subfamily name (Regular, Bold, Italic…)
    |   3   Unique font identifier
    |   4   Full font name
    |   5   Version string
    |   6   PostScript name
    |   7   Trademark
    |   8   Manufacturer name
    |   9   Designer name
    |   10  Description
    |   11  URL vendor
    |   12  URL designer
    |   13  License description
    |   14  License info URL
    |   16  Typographic family name
    |   17  Typographic subfamily name
    |   18  Compatible full name (macOS)
    |   19  Sample text
    |
    | Default "*" keeps all records for maximum compatibility.
    */
    'name_ids' => '*',

    /*
    |--------------------------------------------------------------------------
    | Hinting
    |--------------------------------------------------------------------------
    | Whether to keep hinting instructions embedded in the font.
    | Hinting improves rendering on low-resolution screens (Windows ClearType).
    | Disabling it reduces file size; modern displays (HiDPI) rarely need it.
    |
    | Allowed values: true | false
    */
    'hinting' => true,

];