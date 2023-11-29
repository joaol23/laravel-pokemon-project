<?php

namespace App\Utils\Logging;

use App\Enum\LogsFolder;
use App\Utils\Debug\DebugBacktracePrety;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Monolog\Level;

/**
 * @method static void emergency(string $message, \BackedEnum $folder = '')
 * @method static void alert(string $message, \BackedEnum $folder = '')
 * @method static void critical(string $message, \BackedEnum $folder = '')
 * @method static void error(string $message, \BackedEnum $folder = '')
 * @method static void warning(string $message, \BackedEnum $folder = '')
 * @method static void notice(string $message, \BackedEnum $folder = '')
 * @method static void info(string $message, \BackedEnum $folder = '')
 * @method static void debug(string $message, \BackedEnum $folder = '')
 */
class CustomLogger
{
    private static Logger $channel;

    public static function __callStatic(string $method, mixed $arguments)
    {
        $level = self::getLevel($method);
        $folder = self::getFolder(data_get($arguments, 1));
        $text = self::treatTextLog(data_get($arguments, 0));

        self::createChannel($folder);
        self::callLogMethod($level, $text);
    }

    private static function getLevel(string $method): Level
    {
        try {
            return Level::fromName($method);
        } catch (\Throwable $e) {
            throw new \RuntimeException("Log inválido!");
        }
    }

    private static function getFolder(mixed $folder): string
    {
        if (is_null($folder)) {
            return 'custom';
        }

        if ($folder instanceof LogsFolder) {
            return $folder->value;
        }

        return $folder;
    }

    private static function treatTextLog(
        ?string $text
    ): string {
        if (is_null($text)) {
            throw new \InvalidArgumentException("Texto log inválido!");
        }

        if (Auth::user()) {
            $text .= "\nUsuário logado => " . Auth::user()->id . ".";
        }

        $text .= "\n" . DebugBacktracePrety::backtrace();

        return $text;
    }

    private static function createChannel(
        string $folder
    ): void {
        $channel = Log::build([
            'driver' => 'daily',
            'path' => storage_path('logs/' . $folder . '/log.log'),
            'ignore_exceptions' => false,
            'days' => 7,
        ]);

        self::$channel = Log::stack([$channel]);
    }

    private static function callLogMethod(
        Level  $level,
        string $text
    ): void {
        self::$channel->log($level->name, $text);
    }
}
