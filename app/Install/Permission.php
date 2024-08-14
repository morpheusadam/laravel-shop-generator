<?php

namespace FleetCart\Install;

class Permission
{
    public function provided(): bool
    {
        return collect($this->files())
            ->merge($this->directories())
            ->every(fn ($item) => $item);
    }


    public function files(): array
    {
        return [
            '.env' => is_writable(base_path('.env')),
        ];
    }


    public function directories(): array
    {
        return [
            'storage' => is_writable(storage_path()),
            'bootstrap/cache' => is_writable(app()->bootstrapPath('cache')),
        ];
    }
}
