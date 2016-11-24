<?php

namespace Topicmine\Subscription\Controllers;

use App\User;
use App\Account;
use App\Http\Requests;
use Illuminate\Http\Request;
use Topicmine\Core\Controllers\CoreController;
use Topicmine\Subscription\Repositories\CancellationRepositoryInterface;

class CancellationController extends CoreController
{
    public function __construct(CancellationRepositoryInterface $repo)
    {
        $this->repo = $repo;
        parent::__construct();
    }

    public function index()
    {
        $data['inputs'] = $this->repo->getCreateInputs();
        $data['btnText'] = 'Close Account';
        $data['h1'] = 'Account Cancellation';

        return view('admin.panels.admin-theme.custom_form', compact(['data']));
    }

    public function cancel(Request $request)
    {
        $inputs = $request->all();
        $inputs['user_id'] = auth_user()->id;
        $inputs['account_id'] = account()->id;

        // cancel subscriptions
        $subscriptionRepo = repo()->make('Topicmine\Admin\Repositories\Account\Subscription\Subscription');
        $subscription = $subscriptionRepo->findByField('user_id', $inputs['user_id']);
        $inputs['subscription_id'] = 0;

        if(!$subscription->isEmpty()) {
            $inputs['subscription_id'] = $subscription->first()->id;
            $subscriptionRepo->delete($id = null);
        }
        
        // upload cancellation form
        $this->repo->create($inputs);

        // delete users from account
        $userIds = account()->users()->pluck('id')->all();
        foreach($userIds as $userId) {
            User::destroy($userId);
        }

        // delete account
        Account::destroy(account()->id);

        // logout
        auth()->logout();

        flash('We\'re sorry you\'re leaving. Please come back again soon!')->important();
        return redirect()->route('home');
    }
}
