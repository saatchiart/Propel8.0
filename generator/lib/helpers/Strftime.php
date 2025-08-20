<?php

declare(strict_types=1);

namespace Propel\Helpers;

/**
 * strftime has been deprecated in PHP 8.1. This helper restores it for now but
 * requires an import. This is to avoid converting all usages to the newer
 * DateTime placeholder format.
 */
function strftime(string $strftimeFormat, int $timestamp): string
{
    $datetime = (new \DateTime())->setTimestamp($timestamp);

    $strftimeFormatToDateTimeFormat = [
        '%a' => 'D', // Sun
        '%A' => 'l', // Sunday
        '%d' => 'd', // 01..31
        '%e' => 'j', // 1..31
        '%j' => 'z', // 0..365
        '%m' => 'm', // 01..12
        '%b' => 'M', // Jan
        '%B' => 'F', // January
        '%y' => 'y', // 23
        '%Y' => 'Y', // 2023
        '%H' => 'H', // 00..23
        '%I' => 'h', // 01..12
        '%M' => 'i', // 00..59
        '%S' => 's', // 00..59
        '%p' => 'A', // AM/PM
        '%P' => 'a', // am/pm
        '%Z' => 'T', // Timezone
        '%z' => 'O', // +0200
        '%%' => '%', // Literal %
        '%x' => 'm/d/y', // Date representation (US-style)
        '%X' => 'H:i:s', // Time representation for current locale (e.g., 14:30:00)
    ];

    $datetimeFormat = \strtr($strftimeFormat, $strftimeFormatToDateTimeFormat);

    return $datetime->format($datetimeFormat);
}
