<?php

namespace Itstructure\MFU\Helpers;

/**
 * Class HtmlHelper
 * @package Itstructure\FMU\Helpers
 */
class HtmlHelper
{
    const DATA_ATTRIBUTES = ['data', 'data-ng', 'ng'];

    public static function buildHtmlAttributes(array $htmlAttributes, string $charset = 'UTF-8'): string
    {
        $html = '';

        foreach ($htmlAttributes as $name => $value) {
            if (is_bool($value)) {
                if ($value) {
                    $html .= " $name";
                }
                continue;
            }

            if (is_array($value)) {
                if (in_array($name, self::DATA_ATTRIBUTES)) {
                    foreach ($value as $n => $v) {
                        if (is_string($v)) {
                            $html .= " $name-$n=\"" . self::encode($v, $charset) . '"';
                        }
                    }
                    continue;
                }

                if ($name === 'class') {
                    if (empty($value)) {
                        continue;
                    }
                    $html .= " $name=\"" . self::encode(implode(' ', $value), $charset) . '"';
                    continue;
                }

                if ($name === 'style') {
                    if (empty($value)) {
                        continue;
                    }
                    $html .= " $name=\"" . self::encode(self::cssStyleFromArray($value), $charset) . '"';
                }
                continue;
            }

            if ($value !== null) {
                $html .= " $name=\"" . self::encode($value, $charset) . '"';
            }
        }

        return $html;
    }

    public static function encode(string $content, string $charset = 'UTF-8', bool $doubleEncode = true): string
    {
        return htmlspecialchars($content, ENT_QUOTES | ENT_SUBSTITUTE, $charset, $doubleEncode);
    }

    public static function cssStyleFromArray(array $style): ?string
    {
        $output = '';
        foreach ($style as $name => $value) {
            $output .= "$name: $value; ";
        }

        return $output === '' ? null : rtrim($output);
    }
}
