<?php

/*
 * Names
 */

if (!function_exists('app_name'))
{
    function app_name()
    {
        return config('app.name');
    }
}

if (!function_exists('route_name'))
{
    function route_name()
    {
        return Request::route()->getName();
    }
}

/*
 * Packages
 */

if (!function_exists('core'))
{
    function core()
    {
        return app('core');
    }
}

if (!function_exists('repo'))
{
    function repo()
    {
        return app('repo');
    }
}

if (!function_exists('ajax_flash'))
{

    function ajax_flash($message = null, $type = 'info')
    {
        $msg = app('ajax_flash');
        $msg->setMessage($message, $type);
        $msg->notifier();

        return $msg;
    }
}

if (!function_exists('content'))
{
    function content()
    {
        return app('content');
    }
}

/*
 * Accounts and users
 */
if (!function_exists('account'))
{
    function account()
    {
        return app('account');
    }
}

if (!function_exists('auth_user'))
{

    function auth_user()
    {
        return auth()->user();
    }
}

if (!function_exists('account_user'))
{
    function account_user()
    {
        return account()->user();
    }
}

// same as account_user()
if (!function_exists('account_admin'))
{
    function account_admin()
    {
        return account_user();
    }
}


/*
 * Usere access
 */
if (!function_exists('is_super_user'))
{
    function is_super_user()
    {
        // if user is admin with role 1
        if (auth_user()->isSuperUser() ||
            // allowing for logged in session override
            (session()->has('is_super_user') && session('is_super_user') == 1)
        )
        {
            return true;
        }

        return false;
    }
}

if (!function_exists('is_admin_user'))
{
    function is_admin_user()
    {
        // if user is admin with role 2
        if (auth_user()->isAdmin() ||
            (session()->has('is_admin_user') && session('is_admin_user') == 1)
        )
        {
            return true;
        }

        return false;
    }
}

/*
 * Sitemap
 */

if (!function_exists('getSitemap'))
{
    function getSitemap($section = false, $subSection = false)
    {
        $mainMenu = config('core.menu.admin.sitemap');
        $sidebar = collect(config('core.menu.admin.sidebar'));

        if($subSection !== false) {
            return $sidebar->where('sub_section', $subSection)->where('section', $section)->toArray();
        }

        if ($section != false)
        {
            return $sidebar->where('section', $section)->toArray();
        }

        foreach ($mainMenu as $position => $item)
        {
            $mainMenu[$position]['name'] = $item['name'];
            $mainMenu[$position]['url'] = $item['url'];
            $mainMenu[$position]['menu_items'] = $sidebar->where('section', $item['section'])->toArray();
        }

        return $mainMenu;
    }
}

if (!function_exists('sitemap_list'))
{
    function sitemap_list($element)
    {
        if (empty($element) || !array($element)) return false;

        echo "\n<ul>";
        foreach ($element as $value)
        {
            if (isset($value['menu_items']) && is_array($value['menu_items']))
            {
//                echo "\n<ul>";
                echo "\n<li><a href=\"" . preg_replace('/^(?!\/).*/', '/' . $value['url'], $value['url']) . "\">{$value['name']}</a></li>";
                echo "\n<ul>";
                sitemap_list($value['menu_items']);
                echo "\n</ul>";

            } else
            {
                echo "\n<li>";
                echo "<a href=\"" . preg_replace('/^(?!\/).*/', '/' . $value['url'], $value['url']) . "\">{$value['name']}</a>";
                echo "</li>";
            }
        }
        echo "\n</ul>";
    }
}

/*
 * Config values
 */
if (!function_exists('getConfigValues'))
{
    function getConfigValues($configsDir)
    {
        $configs = [];

        if (is_dir($configsDir))
        {

            $configsFiles = scandir($configsDir);

            if ($configsFiles)
            {
                foreach ($configsFiles as $configsFile)
                {
                    if (!file_exists($configsDir . '/' . $configsFile) || in_array($configsFile, array('.', '..'))) continue;

                    $new = include($configsDir . '/' . $configsFile);

                    $configs = array_merge($configs, $new);
                }
            }
        }

        // Do not sort single value configs
        if (!empty($configs) && !is_array($configs[0]))
        {
            return $configs;
        }

        return $configs;
    }
}

if (!function_exists('getSortedConfigValues'))
{
    function getSortedConfigValues($configsDir)
    {
        if(! is_dir($configsDir)) {
            return false;
        }

        $configs = getConfigValues($configsDir);

        $configsSorted = [];
        $positions = [0];
        foreach ($configs as $k => $config)
        {
            if (!isset($config['position']))
            {
                $position = (max($positions) + 1);
                array_push($configsSorted, [$position => $config]);
                $positions[] = $position;
            } else
            {
                $configsSorted[$config['position']] = $config;
                $positions[] = $config['position'];
            }
        }

        ksort($configsSorted);

        return $configsSorted;
    }
}

/*
 * Route helper
 */
if (!function_exists('includeFilesInDir'))
{
    function includeFilesInDir($dir)
    {
        if (is_dir($dir))
        {
            $files = File::allFiles($dir);
            if ($files)
            {
                foreach ($files as $file)
                {
                    require_once($file);
                }
            }
        }
    }
}


/*
 * Routes
 */

function createRoutes($routes)
{
    foreach ($routes as $route)
    {
        $route['baseName'] = $route['namespace'] . '.' . str_replace('-', '_', $route['routeBase']);

        // index
        Route::get($route['routeBase'], $route['controller'] . '@index')
            ->name($route['baseName'] . '.index');

        // create
        Route::get($route['routeBase'] . '/create', $route['controller'] . '@create')
            ->name($route['baseName'] . '.create');

        // store
        Route::post($route['routeBase'], $route['controller'] . '@store')
            ->name($route['baseName'] . '.store');

        // show (disabled)
        Route::get($route['routeBase'] . '/{id}', $route['controller'] . '@show')
            ->name($route['baseName'] . '.show');

        // delete item
        Route::delete($route['routeBase'] . '/{id}', $route['controller'] . '@destroy')
            ->name($route['baseName'] . '.destroy');

        // edit
        Route::get($route['routeBase'] . '/{id}/edit', $route['controller'] . '@edit')
            ->name($route['baseName'] . '.edit');

        // selected ids
        Route::post($route['routeBase'] . '/update-selected', $route['controller'] . '@updateSelected')
            ->name($route['baseName'] . '.updateSelected');

        // update item single form at top
        Route::patch($route['routeBase'] . '/{id}', $route['controller'] . '@update')
            ->name($route['baseName'] . '.update');
    }
}

if (!function_exists('get_controller_from_path'))
{
    function get_controller_from_path($path)
    {
        $routeName = null;
        $newRequest = app('request')->create($path);
        $routeName = app('router')->getRoutes()
            ->match($newRequest)
            ->getAction();

        return $routeName['controller'];
    }
}

/*
 * Views
 */

if (!function_exists('section_exists'))
{
    function section_exists($section)
    {
        return array_key_exists($section, app('view')->getSections());
    }
}

/*
 * Headings and names
 */
if (!function_exists('model_name'))
{
    function model_name($model)
    {
        return str_singular(strtolower(str_replace('_', ' ', snake_case(class_basename($model)))));
    }
}

if (!function_exists('model_heading'))
{
    function model_heading($model)
    {
        return ucwords(model_name($model));
    }
}

if (!function_exists('model_plural_heading'))
{
    function model_plural_heading($model)
    {
        return str_plural(model_heading($model));
    }
}

if (!function_exists('spaces_before_capitals'))
{
    function spaces_before_capitals($string)
    {
        return preg_replace('/[A-Z]/', ' $0', class_basename($string));
    }
}
