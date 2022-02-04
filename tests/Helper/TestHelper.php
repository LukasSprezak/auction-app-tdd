<?php

namespace App\Tests\Helper;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class TestHelper extends WebTestCase
{
    public static function getUrl(string $name, array $parameters = [], bool|int $absolute = false)
    {
        $referenceType = $absolute;
        if (is_bool($absolute)) {
            $referenceType = $absolute
                ? UrlGeneratorInterface::ABSOLUTE_URL
                : UrlGeneratorInterface::ABSOLUTE_PATH
            ;
        }

        return self::getContainer()
            ->get('router')
            ->generate($name, $parameters, $referenceType);
    }
}