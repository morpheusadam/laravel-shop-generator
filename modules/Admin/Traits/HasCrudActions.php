<?php

namespace Modules\Admin\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Ui\AdminTable;
use Modules\Support\Eloquent\Model;
use Modules\Support\Search\Searchable;
use Modules\Admin\Ui\Facades\TabManager;
use Illuminate\Database\Eloquent\Model as EloquentModel;

trait HasCrudActions
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->has('query')) {
            return $this->getModel()
                ->search($request->get('query'))
                ->query()
                ->limit($request->get('limit', 10))
                ->get();
        }

        return view("{$this->viewPath}.index");
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $this->disableSearchSyncing();

        $entity = $this->getModel()->create(
            $this->getRequest('store')->except(array_keys(request()->query()))
        );

        $this->searchable($entity);

        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo($entity);
        }

        if (request()->wantsJson()) {
            return response()->json(
                [
                    'success' => true,
                    'message' => trans('admin::messages.resource_created', ['resource' => $this->getLabel()]),
                ], 200
            );
        }

        return redirect()->route("{$this->getRoutePrefix()}.index")
            ->withSuccess(trans('admin::messages.resource_created', ['resource' => $this->getLabel()]));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = array_merge([
            'tabs' => TabManager::get($this->getModel()->getTable()),
            $this->getResourceName() => $this->getModel(),
        ], $this->getFormData('create'));

        return view("{$this->viewPath}.create", $data);
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $entity = $this->getEntity($id);

        if (request()->wantsJson()) {
            return $entity;
        }

        return view("{$this->viewPath}.show")->with($this->getResourceName(), $entity);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $data = array_merge([
            'tabs' => TabManager::get($this->getModel()->getTable()),
            $this->getResourceName() => $this->getEntity($id),
        ], $this->getFormData('edit', $id));


        return view("{$this->viewPath}.edit", $data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update($id)
    {
        $entity = $this->getEntity($id);

        $this->disableSearchSyncing();

        $entity->update(
            $this->getRequest('update')->except(array_keys(request()->query()))
        );

        $entity->withoutEvents(function () use ($entity) {
            $entity->touch();
        });

        $this->searchable($entity);

        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo($entity)
                ->withSuccess(trans('admin::messages.resource_updated', ['resource' => $this->getLabel()]));
        }

        if (request()->wantsJson()) {
            return response()->json(
                [
                    'success' => true,
                    'message' => trans('admin::messages.resource_updated', ['resource' => $this->getLabel()]),
                ], 200
            );
        }

        return redirect()->route("{$this->getRoutePrefix()}.index")
            ->withSuccess(trans('admin::messages.resource_updated', ['resource' => $this->getLabel()]));
    }


    /**
     * Destroy resources by given ids.
     *
     * @param string $ids
     *
     * @return void
     */
    public function destroy(string $ids): void
    {
        $this->getModel()
            ->withoutGlobalScope('active')
            ->whereIn('id', explode(',', $ids))
            ->delete();
    }


    /**
     * Prepare the table response for the resource.
     *
     * @param Request $request
     *
     * @return AdminTable
     */
    public function table(Request $request): AdminTable
    {
        return $this->getModel()->table($request);
    }


    /**
     * Get a new instance of the model.
     *
     * @return Model
     */
    protected function getModel()
    {
        return new $this->model;
    }


    /**
     * Disable search syncing for the entity.
     *
     * @return void
     */
    protected function disableSearchSyncing(): void
    {
        if ($this->isSearchable()) {
            $this->getModel()->disableSearchSyncing();
        }
    }


    /**
     * Determine if the entity is searchable.
     *
     * @return bool
     */
    protected function isSearchable(): bool
    {
        return in_array(Searchable::class, class_uses_recursive($this->getModel()));
    }


    /**
     * Get name of the resource.
     *
     * @return string
     */
    protected function getResourceName(): string
    {
        return match (true) {
            isset($this->resourceName) => $this->resourceName,
            default => lcfirst(class_basename($this->model))
        };
    }


    /**
     * Get form data for the given action.
     *
     * @param string $action
     * @param mixed ...$args
     *
     * @return array
     */
    protected function getFormData(string $action, ...$args): array
    {
        return match (true) {
            method_exists($this, 'formData') => $this->formData(...$args),
            ($action === 'create' && method_exists($this, 'createFormData')) => $this->createFormData(),
            ($action === 'edit' && method_exists($this, 'editFormData')) => $this->editFormData(...$args),
            default => []
        };
    }


    /**
     * Get request object
     *
     * @param string $action
     *
     * @return Request
     */
    protected function getRequest(string $action): Request
    {
        return match (true) {
            !isset($this->validation) => request(),
            isset($this->validation[$action]) => resolve($this->validation[$action]),
            default => resolve($this->validation),
        };
    }


    /**
     * Make the given model instance searchable.
     *
     * @param $entity
     *
     * @return void
     */
    protected function searchable($entity): void
    {
        if ($this->isSearchable()) {
            $entity->searchable();
        }
    }


    /**
     * Get label of the resource.
     *
     * @return void
     */
    protected function getLabel(): string
    {
        return trans($this->label);
    }


    /**
     * Get route prefix of the resource.
     *
     * @return string
     */
    protected function getRoutePrefix(): string
    {
        return match (true) {
            isset($this->routePrefix) => $this->routePrefix,
            default => "admin.{$this->getModel()->getTable()}"
        };
    }


    /**
     * Get an entity by the given id.
     *
     * @param int $id
     *
     * @return EloquentModel
     */
    protected function getEntity(int|string $id): EloquentModel
    {
        return $this->getModel()
            ->with($this->relations())
            ->withoutGlobalScope('active')
            ->findOrFail($id);
    }


    /**
     * Get the relations that should be eager loaded.
     *
     * @return array
     */
    private function relations(): array
    {
        return collect($this->with ?? [])->mapWithKeys(
            function ($relation) {
                return [$relation => function ($query) {
                    return $query->withoutGlobalScope('active');
                }];
            }
        )->all();
    }
}
