<?php

namespace Topicmine\Core\Repositories\User;

use DB;
use App\User;
use Topicmine\Core\Repositories\CoreRepository;
use Topicmine\Core\Transformers\UserTransformer;

class UserRepository extends CoreRepository implements UserRepositoryInterface{

    protected $fieldSearchable = [
        'id',
        'name',
        'email',
        'status',
        'confirmed',
        'updated_at',
        'created_at',
    ];

    public function model()
    {
        return User::class;
    }

    public function transformer()
    {
        return UserTransformer::class;
    }

    public function create(array $inputs)
    {
        return $this->model->create([
            'account_id'        => $inputs['account_id'],
            'name'              => $inputs['name'],
            'email'             => $inputs['email'],
            'password'          => bcrypt($inputs['password']),
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed'         => 0,
            'status'            => 1,
        ]);

    }

    public function storeMultiple($array, $additionalAttributes = [])
    {
        $errors = [];
        $userInputs = ['name', 'email'];

        foreach($array as $entry) {
            foreach($userInputs as $k => $input) {
                if(! isset($entry[$input])) {
                    $errors[] = 'Please make sure you have a ' . $input . ' in every row.' ;
                }
            }
        }

        if(count($errors) > 0) {
            return ['errors' => $errors];
        }

        foreach($array as $item) {
            $item['account_id'] = account()->id;
            $item['password'] = bcrypt(rand(10000000,20000000));
            $this->store($item);
        }

        return true;
    }

}