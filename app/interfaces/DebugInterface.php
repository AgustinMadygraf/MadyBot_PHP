<?php

namespace App\Interfaces;

interface DebugInterface
{
    public function debug(string $message): void;
}