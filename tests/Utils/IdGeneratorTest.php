<?php
declare(strict_types=1);
namespace App\Tests\Utils;

use App\Utils\IdGenerator;
use PHPUnit\Framework\TestCase;

class IdGeneratorTest extends TestCase
{
    public function testIdGenerator(): void
    {
        $idGenerator = new IdGenerator();
        $this->assertIsString($idGenerator->getIdGenerator());
        $this->assertNotEmpty($idGenerator->getIdGenerator());
    }
}