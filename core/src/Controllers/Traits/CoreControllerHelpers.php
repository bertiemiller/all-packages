<?php

namespace Topicmine\Core\Controllers\Traits;

trait CoreControllerHelpers {

    /*
     * Laravel doesn't load authorised users in the controller construct so
     * the following make the necessary setting in the middleware
     */

    public function upgradeModelConnection()
    {
        $this->middleware(function ($request, $next) {
            $this->repo->upgradeModelConnection(account());
            return $next($request);
        });
    }

    public function setAccount()
    {
        $this->middleware(function ($request, $next) {
            $this->account = account();
            view()->share('account', account());
            return $next($request);
        });
    }

    public function setAuthUser()
    {
        $this->middleware(function ($request, $next) {
            $this->authUser = auth_user();
            view()->share('user', auth_user());
            return $next($request);
        });
    }

    public function setAccountUser()
    {
        $this->middleware(function ($request, $next) {
            $this->accountUser = account_user();
            view()->share('account_user', account_user());
            return $next($request);
        });
    }

    /*
     * I believe I have deprecated this so commenting out for now
     */
//    public function setRepoRelationshipIfExists($repo)
//    {
//        $repoBaseClassName =
//            str_replace(['RepositoryInterface', 'Repository'], '', get_class($repo));
//        view()->share('repo', $repoBaseClassName);
//
//        $relation = $repo->relation();
//        if($relation !== false) {
//            $relation['parentRepo'] = $repoBaseClassName;
//            view()->share('relation', $relation);
//        }
//    }
}
