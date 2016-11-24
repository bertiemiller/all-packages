<?php

namespace Topicmine\Subscription\Controllers\Auth;

use App\Account;
//use App\Events\Auth\UserRegistered;
use Topicmine\Subscription\Controllers\Auth\Traits\TokenHelper;
use Topicmine\Core\Models\Account\Database;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Topicmine\Core\Models\User\Contact;
use Illuminate\Http\Request;
use Mail;

class RegisterSubscriptionController extends Controller
{
    use RegistersUsers, TokenHelper;

    protected $redirectTo = '/admin/dashboard';

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'account_id' => $data['account_id'],
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed'         => 0,
            'status'            => 1,
        ]);
    }

    public function showRegistrationSubscriptionForm(Contact $contacts)
    {
        $jobTitleOptions = $contacts->jobTitleOptions;

        return view('auth.register_subscription', compact('jobTitleOptions'));
    }

    public function registerSubscription(Request $request)
    {
        $requestParams = $request->all();
        $requestParams['name'] = $requestParams['first_name'] . ' ' . $requestParams['last_name'];
        $account = Account::create();

        $requestParams['account_id'] = $account->id;
        $user = $this->create($requestParams);
        $user->attachRole(2); // Administrator role

        // create database
        $db = new Database;
        $db->dropDatabaseAndUserIfExists($account->id);
        $requestParams['database_id'] = $db->createDatabase($account->id);

        $requestParams['user_id'] = $user->id;
        $account = Account::find($requestParams['account_id']);
        $account->fill($requestParams)->save();

        $addObj = new Contact;
        $addObj->fill($requestParams)->save();

        $this->guard()->login($user);
        request()->session()->put('jwt.token', $this->authenticate($request));

        $this->sendConfirmationEmail($user);

//        event(new UserRegistered($user));
        return redirect($this->redirectPath());
    }

    public function sendConfirmationEmail($user)
    {
        if (! $user instanceof User) {
            $user = User::findOrFail($user);
        }

        // add exceptions

        return Mail::send('emails.confirm', ['token' => $user->confirmation_code], function ($message) use ($user) {
            $message->to($user->email, $user->name)
                ->subject(app_name() . ': Confirm your account!');
        });
    }

}
