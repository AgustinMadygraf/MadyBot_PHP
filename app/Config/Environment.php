<?php
/* path: app/Config/Environment.php */

namespace App\Config;

use Dotenv\Dotenv;

/**
 * Class Environment
 * Singleton class to manage environment variables.
 */
class Environment
{
    private static ?Environment $instance = null;

    private function detectEnvironment(): string
    {
        // Detect environment based on server variables or a specific condition
        if (isset($_SERVER['APP_ENV'])) {
            return $_SERVER['APP_ENV'];
        }

        // Default to 'production' if no environment is explicitly set
        return 'production';
    }

    private function validateRequiredVariables(array $requiredVariables): void
    {
        $missingVariables = [];

        foreach ($requiredVariables as $variable) {
            if (!isset($_ENV[$variable]) || empty($_ENV[$variable])) {
                $missingVariables[] = $variable;
            }
        }

        if (!empty($missingVariables)) {
            throw new \RuntimeException(
                'Missing required environment variables: ' . implode(', ', $missingVariables)
            );
        }
    }

    private function __construct()
    {
        $environment = $this->detectEnvironment();
        $envFile = __DIR__ . "/../../../.env.{$environment}";

        if (!file_exists($envFile)) {
            throw new \RuntimeException("Environment file for '{$environment}' not found.");
        }

        $dotenv = Dotenv::createImmutable(dirname($envFile), basename($envFile));
        $dotenv->load();

        // Validate required variables
        $this->validateRequiredVariables([
            'DB_HOST', 'DB_USER', 'DB_PASSWORD', 'DB_NAME', // Database variables
            'APP_ENV' // Application environment
        ]);
    }

    public static function getInstance(): Environment
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function get(string $key, $default = null)
    {
        return $_ENV[$key] ?? $default;
    }

    public function getWithDefault(string $key, $default)
    {
        return $this->get($key, $default);
    }

    private function __clone() {}
    private function __wakeup() {}
}