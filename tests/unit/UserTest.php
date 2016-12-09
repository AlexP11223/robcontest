<?php

use App\Models\User;
use App\Models\Role;

class UserTest extends TestCase
{
    /** @test */
    public function has_only_assigned_roles()
    {
        $adminRole = Role::getByName('admin');

        $users = factory(User::class, 2)->create();

        $users[0]->addRole($adminRole);

        self::assertTrue($users[0]->hasRole('admin'));
        self::assertFalse($users[0]->hasRole('god'));
        self::assertFalse($users[1]->hasRole('admin'));

        self::assertCount(1, $users[0]->roles);
        self::assertCount(0, $users[1]->roles);
    }

    /** @test */
    public function can_remove_role()
    {
        $adminRole = Role::getByName('admin');

        $user = factory(User::class)->create();

        $user->addRole($adminRole);

        self::assertTrue($user->hasRole('admin'));
        self::assertTrue($adminRole->users->contains($user));

        $user->removeRole($adminRole);

        $user = $user->fresh();
        $adminRole = $adminRole->fresh();

        self::assertFalse($user->hasRole('admin'));
        self::assertFalse($adminRole->users->contains($user));
    }

    /** @test */
    public function can_change_password()
    {
        $user = factory(User::class)->create();

        $user->changePassword('newPassword');

        self::assertTrue(Hash::check('newPassword', $user->password), 'New password does not work');
    }
}
