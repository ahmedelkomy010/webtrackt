<?php

namespace App\Support;

class RichContent
{
    public static function format(?string $content): string
    {
        if ($content === null || trim($content) === '') {
            return '';
        }

        $content = trim($content);

        if (preg_match('/<(h[1-6]|p|ul|ol|div|table|blockquote|section|article)\b/i', $content)) {
            return $content;
        }

        return self::plainTextToHtml($content);
    }

    protected static function plainTextToHtml(string $text): string
    {
        $blocks = preg_split('/\n\s*\n/', $text) ?: [];
        $html = [];

        foreach ($blocks as $block) {
            $block = trim($block);
            if ($block === '') {
                continue;
            }

            $lines = array_values(array_filter(
                array_map('trim', preg_split('/\r\n|\r|\n/', $block)),
                fn ($line) => $line !== ''
            ));

            if ($lines === []) {
                continue;
            }

            if (count($lines) > 1 && self::allListItems($lines)) {
                $html[] = self::buildList($lines);

                continue;
            }

            if (count($lines) === 1) {
                $html[] = self::looksLikeHeading($lines[0])
                    ? '<h3>'.e($lines[0]).'</h3>'
                    : '<p>'.e($lines[0]).'</p>';

                continue;
            }

            $first = array_shift($lines);

            if (self::looksLikeHeading($first)) {
                $html[] = '<h3>'.e($first).'</h3>';

                if (self::allListItems($lines)) {
                    $html[] = self::buildList($lines);
                } else {
                    foreach ($lines as $line) {
                        $html[] = '<p>'.e($line).'</p>';
                    }
                }
            } else {
                $html[] = '<p>'.nl2br(e(implode("\n", array_merge([$first], $lines)))).'</p>';
            }
        }

        return implode("\n", $html);
    }

    protected static function looksLikeHeading(string $line): bool
    {
        $line = trim($line);

        if ($line === '' || mb_strlen($line) > 80) {
            return false;
        }

        if (preg_match('/[.!،,:;]$/u', $line)) {
            return false;
        }

        return true;
    }

    protected static function allListItems(array $lines): bool
    {
        foreach ($lines as $line) {
            if (! self::isListItem($line)) {
                return false;
            }
        }

        return true;
    }

    protected static function isListItem(string $line): bool
    {
        return (bool) preg_match('/^(\-|•|\*|–|\d+[.)])\s+/u', $line);
    }

    protected static function stripBullet(string $line): string
    {
        return preg_replace('/^(\-|•|\*|–|\d+[.)])\s+/u', '', $line) ?? $line;
    }

    protected static function buildList(array $lines): string
    {
        $isOrdered = preg_match('/^\d+[.)]\s+/u', $lines[0]);
        $tag = $isOrdered ? 'ol' : 'ul';
        $items = array_map(
            fn ($line) => '<li>'.e(self::stripBullet($line)).'</li>',
            $lines
        );

        return "<{$tag}>".implode('', $items)."</{$tag}>";
    }
}
