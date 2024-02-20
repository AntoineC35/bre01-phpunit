<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testCannotBeCreatedFromEmptyFirstName()
    {
        $this->expectException(InvalidArgumentException::class);
        new User('', 'lastName', 'antoine@mail.com', "P@ssw0rd");
    }

    public function testCannotBeCreatedFromEmptyLastName()
    {
        $this->expectException(InvalidArgumentException::class);
        new User('firstName', '', 'antoine@mail.com', "P@ssw0rd");
    }

    public function testCannotBeCreatedFromInvalidEmail()
    {
        $this->expectException(InvalidArgumentException::class);
        new User('firstName', 'lastName', 'antoinemail.com', "P@ssw0rd");
    }

    public function testCannotBeCreatedFromInvalidPassword()
    {
        $this->expectException(InvalidArgumentException::class);
        new User('firstName', 'lastName', 'antoine@mail.com', "password");
    }

    public function testCanBeCreatedWithValidArguments()
    {
        $firstName = 'Antoine';
        $lastName = 'Cormier';
        $email = 'antoine@gmail.com';
        $password = "P@ssw0rd";

        $user = new User($firstName, $lastName, $email, $password);

        $this->assertSame($firstName, $user->getFirstName());
        $this->assertSame($lastName, $user->getLastName());
        $this->assertSame($email, $user->getEmail());
        $this->assertSame($password, $user->getPassword());
        
    }
    
    public function testAddRole()
    {
        $firstName = 'Antoine';
        $lastName = 'Cormier';
        $email = 'antoine@gmail.com';
        $password = "P@ssw0rd";

        $user = new User($firstName, $lastName, $email, $password);
        $this->assertEquals(["ANONYMOUS"], $user->getRoles());

        $user->addRole("USER");
        $this->assertEquals(["USER"], $user->getRoles());

        $user->addRole("ADMIN");
        $this->assertEquals(["USER", "ADMIN"], $user->getRoles());

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("SOME_ROLE is not a valid role");
        $user->addRole("SOME_ROLE");

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("USER is already set");
        $user->addRole("USER");
    }

    public function testRemoveRole()
    {
        $firstName = 'Antoine';
        $lastName = 'Cormier';
        $email = 'antoine@gmail.com';
        $password = "P@ssw0rd";

        $user = new User($firstName, $lastName, $email, $password);
        $user->setRoles(["USER", "ADMIN"]);
        $this->assertEquals(["USER", "ADMIN"], $user->getRoles());
        $user->removeRole("USER");
        $this->assertEquals(["ADMIN"], $user->getRoles());
        $user->removeRole("ADMIN");
        $this->assertEquals([], $user->getRoles());
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("SOME_ROLE is not in Roles");
        $user->removeRole("SOME_ROLE");
        $this->assertEquals([], $user->getRoles());
    }
}