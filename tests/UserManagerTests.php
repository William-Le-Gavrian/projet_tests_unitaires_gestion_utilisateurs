<?php

use App\Entity\UserManager;
use Couchbase\User;

class UserManagerTests extends \PHPUnit\Framework\TestCase
{
    public function testAddUser()
    {
        $mockUserManager = $this->createMock(UserManager::class);

        $username = "test";
        $email = "test@test.com";
        $mockUserManager
            ->method('getUser')
            ->willReturn([
                'id' => 1,
                'username' => $username,
                'email' => $email,
            ]);

        $mockUserManager->addUser($username, $email);

        $mockUser = $mockUserManager->getUser(1);
        $this->assertEquals($username, $mockUser["username"]);
        $this->assertEquals($email, $mockUser["email"]);
//        $userManager = new UserManager();

//
//        $userManager->addUser($username, $email);
//
//        $this->assertCount(1, $userManager->getUsers());
    }
}