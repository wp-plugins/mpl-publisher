<?php
namespace PHPePub\Core;

/**
 * Simple log line aggregator.
 *
 * @author    A. Grandt <php@grandt.com>
 * @copyright 2012-2014 A. Grandt
 * @license   GNU LGPL, Attribution required for commercial implementations, requested for everything else.
 * @version   1.00
 */
class Logger {
    const VERSION = 1.00;

    private $log = "";
    private $tStart;
    private $tLast;
    private $name = null;
    private $isLogging = false;
    private $isDebugging = false;

    /**
     * Class constructor.
     *
     * @param string $name
     * @param bool $isLogging
     */
    function __construct($name = null, $isLogging = false) {
        if ($name === null) {
            $this->name = "";
        } else {
            $this->name = $name . " : ";
        }
        $this->isLogging = $isLogging;
        $this->start();
    }

    function start() {
        /* Prepare Logging. Just in case it's used. later */
        if ($this->isLogging) {
            $this->tStart = gettimeofday();
            $this->tLast = $this->tStart;
            $this->log = "<h1>Log: " . $this->name . "</h1>\n<pre>Started: " . gmdate("D, d M Y H:i:s T", $this->tStart['sec']) . "\n &#916; Start ;  &#916; Last  ;";
            $this->logLine("Start");
        }
    }

    function logLine($line) {
        if ($this->isLogging) {
            $tTemp = gettimeofday();
            $tS = $this->tStart['sec'] + (((int)($this->tStart['usec'] / 100)) / 10000);
            $tL = $this->tLast['sec'] + (((int)($this->tLast['usec'] / 100)) / 10000);
            $tT = $tTemp['sec'] + (((int)($tTemp['usec'] / 100)) / 10000);

            $logline = sprintf("\n+%08.04f; +%08.04f; ", ($tT - $tS), ($tT - $tL)) . $this->name . $line;
            $this->log .= $logline;
            $this->tLast = $tTemp;

            if ($this->isDebugging) {
                echo "<pre>" . $logline . "\n</pre>\n";
            }
        }
    }

    /**
     * Class destructor
     *
     * @return void
     * @TODO make sure elements in the destructor match the current class elements
     */
    function __destruct() {
        unset($this->log);
    }

    function dumpInstalledModules() {
        if ($this->isLogging) {
            $isCurlInstalled = extension_loaded('curl') && function_exists('curl_version');
            $isGdInstalled = extension_loaded('gd') && function_exists('gd_info');
            $isExifInstalled = extension_loaded('exif') && function_exists('exif_imagetype');
            $isFileGetContentsInstalled = function_exists('file_get_contents');
            $isFileGetContentsExtInstalled = $isFileGetContentsInstalled && ini_get('allow_url_fopen');

            $this->logLine("isCurlInstalled...............: " . ($isCurlInstalled ? "Yes" : "No"));
            $this->logLine("isGdInstalled.................: " . ($isGdInstalled ? "Yes" : "No"));
            $this->logLine("isExifInstalled...............: " . ($isExifInstalled ? "Yes" : "No"));
            $this->logLine("isFileGetContentsInstalled....: " . ($isFileGetContentsInstalled ? "Yes" : "No"));
            $this->logLine("isFileGetContentsExtInstalled.: " . ($isFileGetContentsExtInstalled ? "Yes" : "No"));
        }
    }

    function getLog() {
        return $this->log;
    }
}
