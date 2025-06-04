<?php


namespace App\Tests\test\Unit\Distribucion\Countries\Domain;


use Distribution\Country\Domain\Country;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class CountryTest extends TestCase
{
    /** @test */
    public function should_be_correct(): void
    {
        $country = new Country(1, 'España');
        $this->assertEquals(1, $country->getId());
        $this->assertEquals('España', $country->getName());
    }
}