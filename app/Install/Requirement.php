<?php

namespace FleetCart\Install;

class Requirement
{
    private const extensions = [
        'intl' => 'Intl',
        'pdo' => 'PDO',
        'json' => 'JSON',
        'ctype' => 'Ctype',
        'xml' => 'XML',
        'tokenizer' => 'Tokenizer',
        'mbstring' => 'Mbstring',
        'openssl' => 'OpenSSL',
        'gd' => 'GD',
        'exif' => 'exif',
    ];


    public function satisfied(): bool
    {
        return collect($this->php())
            ->merge($this->extensions())
            ->every(fn ($item) => $item);
    }


    public function php(): array
    {
        return [
            'PHP >= 8.1.0' => version_compare(phpversion(), '8.1.0'),
        ];
    }


    public function extensions(): array
    {
        $extensions = [];

        foreach (self::extensions as $extension => $name) {
            $extensions[$name . ' PHP Extension'] = extension_loaded($extension);
        }

        return $extensions;
    }
}
