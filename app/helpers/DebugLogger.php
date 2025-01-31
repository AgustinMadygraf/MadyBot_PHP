<?php
/* Path: app/helpers/DebugLogger.php */

namespace App\Helpers;

use App\Interfaces\DebugInterface;

/**
 * Clase DebugLogger
 * Implementa la interfaz DebugInterface para manejar la lógica de depuración.
 */
class DebugLogger implements DebugInterface
{
    private bool $isProduction;

    /**
     * Constructor
     *
     * @param bool $isProduction Indica si la aplicación está en modo producción.
     */
    public function __construct(bool $isProduction)
    {
        $this->isProduction = $isProduction;
    }

    /**
     * Registra mensajes de depuración.
     *
     * @param string $message El mensaje de depuración a registrar.
     */
    public function debug(string $message): void
    {
        if ($this->isProduction) {
            // En modo producción, los mensajes se pueden registrar en un archivo
            $this->logToFile($message);
        } else {
            // En modo desarrollo, los mensajes se muestran en pantalla
            $this->logToOutput($message);
        }
    }

    /**
     * Registra el mensaje en un archivo de log.
     *
     * @param string $message El mensaje a registrar.
     */
    private function logToFile(string $message): void
    {
        $logFile = __DIR__ . '/../../logs/debug.log';
        $formattedMessage = sprintf("[%s] %s\n", date('Y-m-d H:i:s'), $message);
        file_put_contents($logFile, $formattedMessage, FILE_APPEND);
    }

    /**
     * Muestra el mensaje en pantalla (en modo desarrollo).
     *
     * @param string $message El mensaje a mostrar.
     */
    private function logToOutput(string $message): void
    {
        $trace = debug_backtrace();
        $caller = $trace[0];
        echo "<p style='color:blue;'><strong>Debug:</strong> $message<br>";
        echo "Archivo: " . htmlspecialchars($caller['file']) . "<br>";
        echo "Línea: " . htmlspecialchars($caller['line']) . "</p>";
    }
}
