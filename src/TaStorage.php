<?php

namespace ArcaSdk;

/**
 * Persistencia del Ticket de Acceso (TA) que devuelve WSAA — cacheado
 * ~12hs para no re-autenticar contra AFIP en cada llamada. Ver
 * `FileTaStorage` (comportamiento default, igual al de siempre) — un
 * consumidor puede pasar su propia implementación (ej. contra una tabla
 * de DB) vía `Arca::__construct($options)` con `'ta_storage' => $instance`.
 *
 * Esta interfaz vive en el SDK sin depender de ningún framework — una
 * implementación contra DB (Eloquent, etc.) vive del lado de quien
 * consuma este paquete, no acá.
 */
interface TaStorage
{
    /** Devuelve el XML crudo del TA vigente, o null si no hay ninguno cacheado. */
    public function get(string $cuit, string $service, bool $production): ?string;

    public function put(string $cuit, string $service, bool $production, string $xml): void;
}
