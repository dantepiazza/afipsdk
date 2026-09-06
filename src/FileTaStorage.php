<?php

namespace ArcaSdk;

/**
 * Implementación default de `TaStorage` — el comportamiento de siempre
 * (archivo `TA-{cuit}-{service}[-production].xml` en `ta_folder`), ahora
 * detrás de la interfaz. Si nadie pasa `'ta_storage'` en las opciones de
 * `Arca`, esto es lo que se usa — cero cambio de comportamiento.
 */
class FileTaStorage implements TaStorage
{
    public function __construct(private string $folder)
    {
    }

    public function get(string $cuit, string $service, bool $production): ?string
    {
        $path = $this->path($cuit, $service, $production);

        return file_exists($path) ? file_get_contents($path) : null;
    }

    public function put(string $cuit, string $service, bool $production, string $xml): void
    {
        if (file_put_contents($this->path($cuit, $service, $production), $xml) === false) {
            throw new \Exception('Error writing "TA-'.$cuit.'-'.$service.'.xml"', 5);
        }
    }

    private function path(string $cuit, string $service, bool $production): string
    {
        return $this->folder.'TA-'.$cuit.'-'.$service.($production ? '-production' : '').'.xml';
    }
}
