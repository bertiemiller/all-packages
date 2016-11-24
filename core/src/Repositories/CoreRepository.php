<?php

namespace Topicmine\Core\Repositories;

use DB;
use Request as RequestFacade;
use App\Exceptions\GeneralException;
use Topicmine\Core\Repositories\Traits\ApiHelper;
use Topicmine\Core\Repositories\Traits\FormFieldBuilder;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Container\Container as Application;
use Topicmine\Core\Repositories\Traits\RepoHelper;
use Prettus\Repository\Events\RepositoryEntityCreated;


abstract class CoreRepository extends BaseRepository implements CoreRepositoryInterface {

    use FormFieldBuilder;
    use RepoHelper;
    use ApiHelper;

    protected $fieldSearchable = [
        'name'=>'like',
    ];

//    we are not using the presenter class
    protected $skipPresenter = true;

    protected $app;

    protected $model;

    // This is the default model before relationships are set
    public $modelBase;


    public function __construct(Application $app)
    {
        parent::__construct($app);

        // Only want to activate the core if the controller has been called
        if (!core()->coreIsActive())
        {
            // Set core with Api headers
            $this->setCoreIfApiRequest();

            core()->setController();
            core()->setModelName($this->model());

            // Think this has been deprectated so commenting out for now
//            core()->setModel($this->model);
        }

        // Make a base model which cannot be
        // overriden by owner relationships
        $this->makeModelBase();
    }

    public function transformer()
    {
        return \Topicmine\Core\Transformers\BaseTransformer::class;
    }

    public function setCoreIfApiRequest()
    {
        if( null !== RequestFacade::header('Site-Controller-Path') &&
            null !== RequestFacade::header('Site-Route-Name')
        ) {
            core()->setControllerFromApiHeader(RequestFacade::header('Site-Controller-Path'));
            core()->setRouteNameFromApiHeader(RequestFacade::header('Site-Route-Name'));
        }
    }

    public function makeModelBase()
    {
        $this->modelBase = $this->app->make($this->model());
    }

    // Think this has been deprecated so testing without
//    public function getModelBaseName()
//    {
//        return $this->modelBase;
//    }

    // Think this has been deprecated so testing without
//    public function getModel()
//    {
//        return $this->model;
//    }

    public function paginate($limit = null, $columns = ['*'], $method = "paginate")
    {
        $limit = $limit ? $limit : config('repository.pagination.limit', 15);
        return parent::paginate($limit);
    }

    public function store(array $inputs)
    {
        return $this->create($inputs);
    }

    public function storeMultiple($inputs, $additionalAttributes = [])
    {
        $inputs = $this->addAdditionalAttributes($inputs, $additionalAttributes);

        $ids = [];
        foreach ($inputs as $rowId => $data)
        {
            if(empty($data)) continue;

            $model = $this->model->create($data);
//            return ['ddd' => $model];

            if(is_array($model) && in_array('errors', $model)) {
                return $model;
            }

            $model->save();
            $ids[] = $model->id;

            event(new RepositoryEntityCreated($this, $model));
        }
        $this->resetModel();

        return $ids;
    }

    public function allExcept($ids)
    {
        if (!is_array($ids) && is_int($ids))
        {
            $ids = [$ids];
        }

        $collection = $this->model->where('id', '!=', $ids)->get();

        return $collection;
    }

    public function getItemAndInputs($id)
    {
//        dd($this->testDB);
//        dd(DB::connection()->getDatabaseName());

        $data['item'] = $this->find($id);
        $data['inputs'] = $this->getEditInputs($data['item']->toArray());

//        dd($data);
        return $data;
    }


}
