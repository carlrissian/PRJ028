<?php

namespace App\Tests\test\Unit\Distribucion\Users\Domain;



use Distribution\User\Domain\User;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function should_be_correct(): void
    {
        $users = new User(1, '12345s', 'name', 'username');
        $this->assertEquals(1, $users->getId());
        $this->assertEquals('12345s', $users->getDni());
        $this->assertEquals('name', $users->getName());
        $this->assertEquals('username', $users->getSurname());
    }
}
