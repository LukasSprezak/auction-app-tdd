<?php
declare(strict_types=1);

namespace App\Utils;

class IdGenerator
{
    protected string $idGenerator;

    public function getIdGenerator(): string
    {
        return $this->idGenerator = self::idGenerator();
    }

    public static function IdGenerator(): string
    {
        return strtr(substr(base64_encode(md5(uniqid('', true),true)),0,8),'+/', '-_');
    }
}