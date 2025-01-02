<!--
Path: app/interfaces/IURLRepository.php

-->

<?php

/**
 * Interface IURLRepository
 * Define las operaciones que cualquier repositorio de URLs debe implementar.
 */
interface IURLRepository {
    /**
     * Guarda una URL en el repositorio.
     *
     * @param string $url La URL a guardar.
     * @return bool True si se guardó correctamente, False en caso contrario.
     */
    public function saveURL(string $url): bool;

    /**
     * Recupera todas las URLs almacenadas.
     *
     * @return array Un arreglo de URLs.
     */
    public function getAllURLs(): array;
}
