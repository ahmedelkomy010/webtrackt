<?php

/**
 * Fix routing when Laravel runs in an XAMPP subdirectory (e.g. /tract-marketing).
 */
function fixSubdirectoryRequest(): void
{
    $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');

    $basePath = '';

    if (str_ends_with($scriptName, '/public/index.php')) {
        $basePath = substr($scriptName, 0, -strlen('/public/index.php'));
    } elseif (str_ends_with($scriptName, '/index.php') && $scriptName !== '/index.php') {
        $basePath = substr($scriptName, 0, -strlen('/index.php'));
    }

    if ($basePath === '' || $basePath === '/') {
        return;
    }

    $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
    $queryString = '';

    if (($pos = strpos($requestUri, '?')) !== false) {
        $queryString = substr($requestUri, $pos);
        $requestUri = substr($requestUri, 0, $pos);
    }

    if ($requestUri === $basePath || str_starts_with($requestUri, $basePath.'/')) {
        $requestUri = substr($requestUri, strlen($basePath)) ?: '/';
        $_SERVER['REQUEST_URI'] = $requestUri.$queryString;
    }
}

fixSubdirectoryRequest();
