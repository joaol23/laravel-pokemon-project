<?php

namespace App\Utils\Debug;

class DebugBacktracePrety
{
    private static array $filesExclude = ["DebugBacktracePrety", "CustomLogger"];

    public static function backtrace()
    {
        $debugBacktracet = self::getDebugBacktrace();
        return self::treatBackTrace($debugBacktracet);
    }

    private static function getDebugBacktrace()
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 10);

        $lastPaths = [];

        foreach ($backtrace as $trace) {
            $fileTrace = isset($trace['file']) ? str_replace(".php", "", basename($trace['file'])) : null;

            if (
                !in_array($fileTrace, self::$filesExclude)
                && isset($trace['file'])
                && isset($trace['line'])
            ) {
                $infoChamada = [
                    'arquivo' => $trace['file'],
                    'linha' => $trace['line'],
                ];

                if (isset($trace['class'])) {
                    $infoChamada['classe'] = $trace['class'];
                }

                if (isset($trace['function'])) {
                    $infoChamada['funcao'] = $trace['function'];
                }

                if (isset($trace['args'])) {
                    $infoChamada['parametros'] = $trace['args'];
                }

                $lastPaths[] = $infoChamada;
            }
        }
        return $lastPaths;
    }

    private static function treatBackTrace(array $backTrace): string
    {
        $text = '';
        foreach ($backTrace as $index => $trace) {
            $text .= "Chamada #{" . ($index + 1) . "}: Arquivo: {$trace['arquivo']}, Linha: {$trace['linha']}\n";
            if (isset($trace['classe'])) {
                $text .= "  Classe: {$trace['classe']}\n";
            }
            if (isset($trace['funcao'])) {
                $text .= "  Função: {$trace['funcao']}\n";
            }
            if (isset($trace['parametros'])) {
                $text .= "  Parâmetros: " . json_encode($trace['parametros']) . "\n";
            }
            $text .= "\n";
        }
        return $text;
    }
}
