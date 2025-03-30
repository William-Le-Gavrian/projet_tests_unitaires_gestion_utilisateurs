<?php

use App\Entity\UserManager;

class UserManagerTests extends \PHPUnit\Framework\TestCase
{

    public function testAddUser()
    {
        $userManager = new UserManager();
        $count = count($userManager->getUsers());

        $user = [
            "username" => "test",
            "email" => "test" . $count + 1 . "@test.com",
        ];

        $userManager->addUser($user['username'], $user['email']);

        $this->assertCount($count + 1, $userManager->getUsers());
    }

    public function testAddUserEmailException()
    {
        $userManager = new UserManager();
        $user = [
            "name" => "test",
            "email" => "testException",
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Email invalide.");
        $userManager->addUser($user['name'], $user['email']);
    }

    public function testUpdateUser()
    {
        $userManager = new UserManager();
        $count = count($userManager->getUsers());
        $user = [
            "name" => "test",
            "email" => "testUpdate" . $count + 1 . "@test.com",
        ];
        $userManager->addUser($user['name'], $user['email']);

        $userToUpdate = $userManager->getUsers()[$count];
        $userId = $userToUpdate['id'];

        $userManager->updateUser($userId, "Test Update", $user['email']);

        $this->assertEquals("Test Update", $userManager->getUser($userId)['name']);

//        $userManager->updateUser($userId, "test", $user['email']);
    }

    public function testRemoveUser()
    {
        $userManager = new UserManager();
        $user = [
            "name" => "test",
            "email" => "testRemove@test.com",
        ];
        $userManager->addUser($user['name'], $user['email']);
        $count = count($userManager->getUsers());

        $userToRemove = $userManager->getUsers()[$count - 1];
        $userId = $userToRemove['id'];
        $userManager->removeUser($userId);

        $this->assertCount($count - 1, $userManager->getUsers());
    }

    public function testGetUsers()
    {
        $userManager = new UserManager();

        $this->assertGreaterThanOrEqual(0, $userManager->getUsers());
    }

    public function testInvalidUpdateThrowsException()
    {
        $userManager = new UserManager();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Utilisateur introuvable.");
        $userManager->updateUser(-1, "Test Exception Update", "testExceptionUpdate@test.com");
    }

    public function testInvalidDeleteThrowsException()
    {
        $userManager = new UserManager();
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Utilisateur introuvable.");
        $userManager->removeUser(-1);
    }
}