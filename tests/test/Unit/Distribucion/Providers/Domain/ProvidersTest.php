<?php


namespace App\Tests\test\Unit\Distribucion\Providers\Domain;


use Distribution\Supplier\Domain\Supplier;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class ProvidersTest extends TestCase
{
    /** @test */
    public function should_be_correct(): void
    {
        $provider = new Supplier(1, '1', 'name', null, null, null, null);
        $this->assertEquals(1, $provider->getId());
        $this->assertEquals('name', $provider->getName());
    }
}