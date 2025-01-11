<?php

namespace UbuntuManager;

class SystemManager
{
    /**
     * Haal algemene systeeminformatie op.
     *
     * @return array
     */
    public static function getSystemInfo()
    {
        return [
            'uptime' => self::getUptime(),
            'diskUsage' => self::getDiskUsage(),
            'memoryUsage' => self::getMemoryUsage(),
        ];
    }

    /**
     * Haal uptime van het systeem op.
     *
     * @return string
     */
    private static function getUptime()
    {
        return trim(shell_exec('uptime -p')); // Bijvoorbeeld: "up 2 hours, 5 minutes"
    }

    /**
     * Haal informatie over schijfgebruik op.
     *
     * @return string
     */
    private static function getDiskUsage()
    {
        return trim(shell_exec('df -h /')); // Geeft informatie over rootpartitie (bijv. "/")
    }

    /**
     * Haal geheugenstatistieken op.
     *
     * @return string
     */
    private static function getMemoryUsage()
    {
        return trim(shell_exec('free -h')); // Geeft RAM- en swapgebruik in leesbaar formaat
    }
}