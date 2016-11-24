<?php

namespace Topicmine\Core\Models;

use Illuminate\Database\Eloquent\Model;
use JavaScript;

class Core extends Model {

//    public $model;
    public $routeBase;
    public $routeName = false;
    public $routeParts;
    public $countRouteBaseParts;
    public $rootId;
//    public $baseModel;
    public $modelBaseName;
    public $modelName;
    public $coreActive = false;
    public $modelSet = false;
    public $controllerMethod = false;
    public $controller = false;
    public $repoPath;
    
    public function __construct($app)
    {
        $this->app = $app;
    }

    /*
     * Activating core
     */

    public function coreActivate()
    {
        if (!$this->coreIsActive())
        {
            if (null == app('request')->route())
            {
                return false;
            }

            $this->setController();
            $this->putRoutesToJavascript();
            $this->coreActive = true;
        }

        return false;
    }

    public function setController()
    {
        if (null == app('request')->route()){
            return false;
        }

        $action = app('request')->route()->getAction();

        // Non api calls
        if(false === $this->routeName && false === $this->controller) {
            $this->routeName = route_name();
            list($this->controller, $this->controllerMethod) = explode('@', $action['controller']);
        }
        // Just set controller method for APi calls
        else {
            list($anotherController, $this->controllerMethod) = explode('@', $action['controller']);
        }

        $this->controller = str_replace('\\\\','\\', '\\' . $this->controller);
    }

    public function controller()
    {
        return $this->controller;
    }

    public function controllerMethod()
    {
        return $this->controllerMethod;
    }

    public function putRoutesToJavascript()
    {
        JavaScript::put([
            'routeBase'            => $this->routeBase(),
            'routeIndex'           => $this->routeIndexName(),
            'model_heading'        => model_heading($this->modelBaseName),
            'model_plural_heading' => model_plural_heading($this->modelBaseName),
        ]);
    }

    public function coreIsActive()
    {
        return !!$this->coreActive;
    }

    public function modelIsSet()
    {
        return !!$this->modelSet;
    }

    /*
     * Setting Route Base
     */

    public function routeBase()
    {
        // On first call of routeBase() it is set
        if (null == $this->routeBase)
        {
            $this->setRouteBase();
        }

        return $this->routeBase;
    }

    public function setRouteBase()
    {
        $this->routeParts = explode('.', $this->routeName);

        // try for five part routes
        preg_match('/(\w*\.\w*\.\w*\.\w*?)\.[a-zA-Z\.0-9-_]+/', $this->routeName, $matches);
        if (isset($matches[1]))
        {
            $this->countRouteBaseParts = 5;
            $this->routeBase = $matches[1];
            $this->routeId = $this->routeParts[$this->countRouteBaseParts - 4] . '.' . $this->routeParts[$this->countRouteBaseParts - 3];

            return true;
        }

        // try for four part routes
        preg_match('/(\w*\.\w*\.\w*?)\.[a-zA-Z\.0-9-_]+/', $this->routeName, $matches);
        if (isset($matches[1]))
        {
            $this->countRouteBaseParts = 4;
            $this->routeBase = $matches[1];
            $this->routeId = $this->routeParts[$this->countRouteBaseParts - 3];

            return true;
        }

        // try for three part routes
        preg_match('/(\w*\.\w*?)\.[a-zA-Z\.0-9-_]+/', $this->routeName, $matches);
        if (isset($matches[1]))
        {
            $this->countRouteBaseParts = 3;
            $this->routeBase = $matches[1];
            $this->routeId = $this->routeParts[$this->countRouteBaseParts - 2];

            return true;
        }

        // try for two part routes
        preg_match('/(\w)\.[a-zA-Z\.0-9-_]+/', $this->routeName, $matches);
        if (isset($matches[1]))
        {
            $this->countRouteBaseParts = 2;
            $this->routeBase = $matches[1];
            $this->routeId = $this->routeParts[$this->countRouteBaseParts - 1];

            return true;
        }

        // Note admin will not have one part routes
        dd('Route not known - Core.php');
    }

    /*
     * Setting Repo
     */

    public function setRepoPath($repo)
    {
        $this->repoPath = str_replace('Repository','',(new \ReflectionClass($repo))->getName());
    }

    public function getRepoPath()
    {
        return $this->repoPath;
    }

    /*
     * Setting Model
     */

    public function setModelName($modelName)
    {
        if (!$this->coreIsActive())
        {
            // Setting base model before any relationships are set. This is
            // the model name without any overiding relationship
            // Used for finding model atttributes
            // e.g. fillable, table
            $this->setModelBaseName($modelName);
            $this->modelSet = true;

//            return $this->modelName = $modelName;
            $this->modelName = $modelName;
        }
    }

    public function setModelBaseName($model)
    {
        $this->modelBaseName = class_basename($model);
    }

    public function modelBaseName()
    {
        return $this->modelBaseName;
    }

    public function modelName()
    {
        return $this->modelName;
    }

//    public function setModel($model)
//    {
//        // Setting base model before any relationships are set. This is
//        // the model name without any overiding relationship
//        // Used for finding model atttributes
//        // e.g. fillable, table
//        $this->baseModel = $model;
//
////        return $this->model = $model;
//        $this->model = $model;
//    }

//    public function model()
//    {
//        return $this->model;
//    }

//    public function baseModel()
//    {
//        return $this->baseModel;
//    }

    /*
     * Api Setting
     */

    public function setControllerFromApiHeader($controller)
    {
        $this->controller = $controller;
    }

    public function setRouteNameFromApiHeader($routeName)
    {
        $this->routeName = $routeName;
    }

    /*
     * Routes
     */

    public function routeIndexName()
    {
        return $this->routeBase() . '.index';
    }

    public function routeIndex()
    {
        return route($this->routeIndexName());
    }

    public function routeCreateName()
    {
        return $this->routeBase() . '.create';
    }

    public function routeCreate()
    {
        return route($this->routeCreateName());
    }

    public function routeStoreName()
    {
        return $this->routeBase() . '.store';
    }

    public function routeStore()
    {
        return route($this->routeStoreName());
    }

    public function routeEditName()
    {
        return $this->routeBase() . '.edit';
    }

    public function routeEdit()
    {
        return route($this->routeEditName());
    }

    public function routeUpdateName()
    {
        return $this->routeBase() . '.update';
    }

    public function routeUpdate()
    {
        return route($this->routeUpdateName());
    }

    public function routeDestroyName()
    {
        return $this->routeBase() . '.destroy';
    }

    public function routeDestroy()
    {
        return route($this->routeDestroyName());
    }

    // This duplicates destroy but prevents naming bugs
    public function routeDeleteName()
    {
        return $this->routeDestroyName();
    }

    public function routeDelete()
    {
        return $this->routeDestroy();
    }

    /*
     * Html
     */

    protected function routeAction()
    {
        $routeArray = explode('.', route_name());

        $actions = [
            'index' => null,
            'create' => 'Create ',
            'edit' => 'Edit ',
        ];

        if(in_array(end($routeArray), $actions)) {
            return $actions[end($routeArray)];
        }

        return null;
    }

    public function title($title)
    {
        if($title !== false) return $title. ' - ' . app_name();

        $title = model_plural_heading($this->modelBaseName);

        return $this->routeAction() . $title . ' - ' . app_name();
    }

    public function metaDescription($metaDescription)
    {
        if($metaDescription !== false) return $metaDescription. ' - ' . app_name();

        $metaDescription = model_plural_heading($this->modelBaseName);

        return $this->routeAction() . $metaDescription . ' - ' . app_name();
    }

    public function h1($h1)
    {
        if($h1 !== false) return $h1;

        $h1 = model_plural_heading($this->modelBaseName);

        return $this->routeAction() . $h1;
    }
}