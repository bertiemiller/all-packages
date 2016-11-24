<?php

namespace Topicmine\Subscription\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mail;
use Auth;

class ConfirmUserController extends Controller
{
    public function showForm()
    {
        $request = request();
        $email = null;
        if($request->session()->has('subscribingUserEmail')) {
            $email = $request->session()->get('subscribingUserEmail');
        }
        return view('auth.register-confirm')
            ->withEmail($email);
    }

    public function resendEmail(Request $request)
    {
        $email = $request->all()['email'];
        $user = User::where('email', $email)->first();
        $this->sendEmail($user);

        flash('A new confirmation e-mail has been sent to the address on file.');
        return redirect()->route('auth.register.confirm');
    }

    public function resendEmailToUser($id)
    {
        $user = User::findOrFail($id);
        $this->sendEmail($user);

        flash('A new confirmation e-mail has been sent to the address on file.');
        return redirect()->route('auth.register.confirm');
    }

    public function confirmToken($token)
    {
        $user = $this->findByToken($token);

        if ($user->confirmed == 1) {
            flash('Your account is already confirmed.', 'error');
            return redirect('/login?already');
        }

        if ($user->confirmation_code == $token) {
            $user->confirmed = 1;
            $user->save();

            flash('Your account has been successfully confirmed!', 'success');

            if(Auth::check()) {
                return redirect('admin/dashboard');
            }

            return redirect('/login?confirmed');
        }

        flash('Your confirmation code does not match.', 'error');
        return redirect()->back();
    }

    public function findByToken($token) {
        $user = User::where('confirmation_code', $token)->first();
        if (! $user instanceof User)
            throw new GeneralException('That confirmation code does not exist.');
        return $user;
    }

    public function sendEmail($user)
    {
        if (! $user instanceof User) {
            $user = $this->model->find($user);
        }

        return Mail::send('emails.confirm', ['token' => $user->confirmation_code], function ($message) use ($user) {
            $message->to($user->email, $user->name)
                ->subject(app_name() . ': ' . 'Confirm your account!');
        });
    }
}
