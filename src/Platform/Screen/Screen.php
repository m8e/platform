<?php

declare(strict_types=1);

namespace Orchid\Platform\Screen;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

abstract class Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name;

    /**
     * Display header description.
     *
     * @var string
     */
    public $description;

    /**
     * @var array|Request|string
     */
    public $request;

    /**
     * Permission.
     *
     * @var string
     */
    public $permission;

    /**
     * @var array
     */
    protected $arguments = [];

    /**
     * Screen constructor.
     */
    public function __construct()
    {
        $this->request = request();
    }

    /**
     * Button commands.
     *
     * @return array
     */
    abstract public function commandBar() : array;

    /**
     * Query data.
     *
     * @return array
     */
    //abstract public function query() : array;

    /**
     * Views.
     *
     * @return array
     */
    abstract public function layout() : array;

    /**
     * @return array
     */
    public function build() : array
    {
        $query = call_user_func_array([$this, 'query'], $this->arguments);
        $post = new Repository($query);

        foreach ($this->layout() as $layout) {
            if (is_object($layout)) {
                $build[] = $layout->build($post);
                continue;
            }

            $build[] = (new $layout())->build($post);
        }

        return $build ?? [];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view()
    {
        return view('platform::container.layouts.base', [
            'builds'    => $this->build(),
            'arguments' => $this->arguments,
            'screen'    => $this,
        ]);
    }
    
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postview()
    {
        return view('platform::container.layouts.postbase', [
            'builds'    => $this->build(),
            'arguments' => $this->arguments,
            'screen'    => $this,
        ]);
    }

    /**
     * @param null $method
     * @param null $parameters
     *
     * @throws \ReflectionException
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function handle($method = null, $parameters = null)
    {
        abort_if(! $this->checkAccess(), 403);

        if ($this->request->method() === 'GET' || (is_null($method) && is_null($parameters))) {
            $this->arguments = is_array($method) ? $method : [$method];

            return $this->view();
        }
        
        if ($this->request->method() === 'POST' || (is_null($method) && is_null($parameters))) {
            $this->arguments = is_array($method) ? $method : [$method];

            return $this->postview();
        }

        if (! is_null($parameters)) {
            $this->arguments = is_array($method) ? $method : [$method];

            $this->reflectionParams($parameters);

            return call_user_func_array([$this, $parameters], $this->arguments);
        }

        $this->arguments = is_array($parameters) ? $parameters : [$parameters];
        $this->reflectionParams($method);

        return call_user_func_array([$this, $method], $this->arguments);
    }

    /**
     * @param $method
     *
     * @throws \ReflectionException
     */
    public function reflectionParams($method)
    {
        $class = new \ReflectionClass($this);
        $parameters = $class->getMethod($method)->getParameters();

        foreach ($parameters as $key => $parameter) {
            if (is_null($parameter->getClass()) || $this->checkClassInArray($key)) {
                continue;
            }

            $this->arguments[$key] = app()->make($parameter->getClass()->name);
        }
    }

    /**
     * @param $class
     *
     * @return bool
     */
    private function checkClassInArray($class)
    {
        foreach ($this->arguments as $value) {
            if (is_object($value) && get_class($value) == $class) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    private function checkAccess()
    {
        if (is_null($this->permission)) {
            return true;
        }

        if (is_string($this->permission)) {
            $this->permission = [$this->permission];
        }

        if (is_array($this->permission)) {
            foreach ($this->permission as $item) {
                if (! Auth::user()->hasAccess($item)) {
                    return false;
                }
            }
        }

        return true;
    }
}
