<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeUserPassword;
use Illuminate\Http\Request;
use Auth;
use Redirect;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showChangePasswordForm() {
        return view('auth.passwords.change');
    }

    public function changePassword(ChangeUserPassword $request) {
        $user = Auth::user();

        $user->changePassword($request->get('newPassword'));

        return Redirect::back()->with('success', true);
    }
}
