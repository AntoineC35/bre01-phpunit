<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class GuardTest extends TestCase {

    public function testGiveAccessPrivatePostToAnonymous() {
        //private post + User = User Retour = ERORR CANT BE ANONYMOUS
        $user = new User('Antoine', 'Cormier', "antoine@gmail.com", "P@ssw0rd");
        $post = new Post("title", "content", "slug");
        $post->setPrivate("true");
        $guard = new Guard();
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("l'utilisateur ne peut pas être anonyme");
        $guard->giveAccess($post, $user);
    }


    public function testGiveAccessPrivatePostToUser() {
        //private post + User = User Retour = user=Admin
        $user = new User('Antoine', 'Cormier', "antoine@gmail.com", "P@ssw0rd");
        $post = new Post("title", "content", "slug");
        $post->setPrivate("true");
        $user->addRole("USER");
        $guard = new Guard();
        $guard->giveAccess($post, $user);
        $this->assertEquals(["ADMIN"], $user->getRoles());
    }

    public function testGiveAccessPrivatePostToAdmin() {
        //private post + User = User Retour = user=Admin
        $user = new User('Antoine', 'Cormier', "antoine@gmail.com", "P@ssw0rd");
        $post = new Post("title", "content", "slug");
        $post->setPrivate("true");
        $user->addRole("ADMIN");
        $guard = new Guard();
        $guard->giveAccess($post, $user);
        $this->assertEquals(["ADMIN"], $user->getRoles());
    }

    public function testGiveAccessPublicPostToAnonymous() {
        //public test + User = Anonymous
        $user = new User('Antoine', 'Cormier', "antoine@gmail.com", "P@ssw0rd");
        $post = new Post("title", "content", "slug");
        $guard = new Guard();
        $guard->giveAccess($post, $user);
        $this->assertEquals(["USER"], $user->getRoles());
    }

    public function testGiveAccessPublicPostToAdmin() {
        //public test + User = Admin
        $user = new User('Antoine', 'Cormier', "antoine@gmail.com", "P@ssw0rd");
        $user->addRole("ADMIN");
        $post = new Post("title", "content", "slug");
        $guard = new Guard();
        $guard->giveAccess($post, $user);
        $this->assertEquals(["ADMIN"], $user->getRoles());
    }

    public function testGiveAccessPublicPostToUser() {
        //public test + User = User
        $user = new User('Antoine', 'Cormier', "antoine@gmail.com", "P@ssw0rd");
        $user->addRole("USER");
        $post = new Post("title", "content", "slug");
        $guard = new Guard();
        $guard->giveAccess($post, $user);
        $this->assertEquals(["USER"], $user->getRoles());
    }

    public function testRemoveAccessPrivatePostToAnonymous() {
        // private post + user = Anonymous
        $user = new User('Antoine', 'Cormier', "antoine@gmail.com", "P@ssw0rd");
        $post = new Post("title", "content", "slug");
        $post->setPrivate("true");
        $guard = new Guard();
        $guard->removeAccess($post, $user);
        $this->assertEquals(["ANONYMOUS"], $user->getRoles());
    }

    public function testRemoveAccessPrivatePostToUser() {
        // private post + user = USER
        $user = new User('Antoine', 'Cormier', "antoine@gmail.com", "P@ssw0rd");
        $user->addRole("USER");
        $post = new Post("title", "content", "slug");
        $post->setPrivate("true");
        $guard = new Guard();
        $guard->removeAccess($post, $user);
        $this->assertEquals(["ANONYMOUS"], $user->getRoles());
    }

    public function testRemoveAccessPrivatePostToAdmin() {
        // private post + user = ADMIN
        $user = new User('Antoine', 'Cormier', "antoine@gmail.com", "P@ssw0rd");
        $user->addRole("ADMIN");
        $post = new Post("title", "content", "slug");
        $post->setPrivate("true");
        $guard = new Guard();
        $guard->removeAccess($post, $user);
        $this->assertEquals(["USER"], $user->getRoles());
    }

    public function testRemoveAccessPublicPostToAnonymous() {
        // public post + user = ANONYMOUS
        $user = new User('Antoine', 'Cormier', "antoine@gmail.com", "P@ssw0rd");
        $post = new Post("title", "content", "slug");
        $guard = new Guard();
        $guard->removeAccess($post, $user);
        $this->assertEquals(["ANONYMOUS"], $user->getRoles());
    }

    public function testRemoveAccessPublicPostToUser() {
        // public post + user = USER
        $user = new User('Antoine', 'Cormier', "antoine@gmail.com", "P@ssw0rd");
        $user->addRole("USER");
        $post = new Post("title", "content", "slug");
        $guard = new Guard();
        $guard->removeAccess($post, $user);
        $this->assertEquals(["ANONYMOUS"], $user->getRoles());
    }

    public function testRemoveAccessPublicPostToAdmin() {
        // public post + user = ADMIN
        $user = new User('Antoine', 'Cormier', "antoine@gmail.com", "P@ssw0rd");
        $user->addRole("ADMIN");
        $post = new Post("title", "content", "slug");
        $guard = new Guard();
        $guard->removeAccess($post, $user);
        $this->assertEquals(["USER"], $user->getRoles());
    }

}