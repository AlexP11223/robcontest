<?php

class ChangePasswordTest extends TestCase
{
    /** @test */
    public function should_change_password()
    {
        $newPassword = 'new pa$$word';

        $this
            ->actingAs(self::admin())
            ->visit('change-password');

        $this->post('change-password', [
                'password' => self::defaultAdminPassword(),
                'newPassword' => $newPassword,
                'newPassword_confirmation' => $newPassword]);

        $this
            ->assertRedirectedTo('change-password')
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success', true);

        self::assertTrue(Hash::check('new pa$$word', self::admin()->password), 'New password does not work');
        self::assertFalse(Hash::check(self::defaultAdminPassword(), self::admin()->password), 'Old password still works');
    }

    /** @test */
    public function should_not_change_password_if_incorrect_current_password()
    {
        $newPassword = 'new pa$$word';

        $this
            ->actingAs(self::admin())
            ->visit('change-password');

        $this->post('change-password', [
            'password' => 'incorrect',
            'newPassword' => $newPassword,
            'newPassword_confirmation' => $newPassword]);

        $this
            ->assertRedirectedTo('change-password')
            ->assertSessionHasErrors('password');

        self::assertTrue(Hash::check(self::defaultAdminPassword(), self::admin()->password), 'Password changed');
    }

    /** @test */
    public function should_not_change_password_if_invalid_input()
    {
        $this
            ->actingAs(self::admin())
            ->visit('change-password');

        $this->post('change-password', [
            'password' => self::defaultAdminPassword(),
            'newPassword' => '',
            'newPassword_confirmation' => '']);

        $this
            ->assertRedirectedTo('change-password')
            ->assertSessionHasErrors('newPassword');

        $this->post('change-password', [
            'password' => self::defaultAdminPassword(),
            'newPassword' => 'short',
            'newPassword_confirmation' => 'short']);

        $this
            ->assertRedirectedTo('change-password')
            ->assertSessionHasErrors('newPassword');

        self::assertTrue(Hash::check(self::defaultAdminPassword(), self::admin()->password), 'Password changed');
    }

    /** @test */
    public function should_not_change_password_if_incorrect_confirmation()
    {
        $newPassword = 'new pa$$word';

        $this
            ->actingAs(self::admin())
            ->visit('change-password');

        $this->post('change-password', [
            'password' => self::defaultAdminPassword(),
            'newPassword' => $newPassword,
            'newPassword_confirmation' => 'smth else']);

        $this
            ->assertRedirectedTo('change-password')
            ->assertSessionHasErrors('newPassword');

        self::assertTrue(Hash::check(self::defaultAdminPassword(), self::admin()->password), 'Password changed');
    }
}
