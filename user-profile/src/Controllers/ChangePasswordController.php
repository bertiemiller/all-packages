<?php

namespace Topicmine\UserProfile\Controllers;

use Topicmine\Core\Requests\User\ChangePasswordRequest;
use Illuminate\Http\Request;
use Topicmine\Core\Repositories\User\UserRepositoryInterface;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Hash;

class ChangePasswordController extends Controller
{
    public function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
    }

    public function edit()
    {
        return view('admin.panels.user-profile.passwords.change');
    }

    public function update(ChangePasswordRequest $request)
    {
        $inputs = $request->all();
        $user = $this->user->find(auth_user()->id);

        if (Hash::check($inputs['old_password'], $user->password))
        {
            $user->password = bcrypt($inputs['password']);
            $user->save();
            flash('Password successfully updated.', 'success');
            return redirect()->route('topicmine.user_profile.password.edit');
        }

        flash('Your confirmation code does not match.', 'error');
        return redirect()->route('topicmine.user_profile.password.edit');
    }

}
