<?php

namespace App\Interfaces;

/**
 * Interface DebugInterface
 * Define un contrato para clases de depuración.
 */
interface DebugInterface
{
    /**
     * Método para registrar mensajes de depuración.
     *
     * @param string $message El mensaje de depuración a registrar.
     */
    public function debug(string $message): void;
}
