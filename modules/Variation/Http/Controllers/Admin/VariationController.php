<?php

namespace Modules\Variation\Http\Controllers\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Modules\Admin\Traits\HasCrudActions;
use Modules\Variation\Entities\Variation;
use Illuminate\Contracts\Foundation\Application;
use Modules\Variation\Transformers\VariationResource;
use Modules\Variation\Http\Requests\SaveVariationRequest;

class VariationController
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected string $model = Variation::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected string $label = 'variation::variations.variation';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected string $viewPath = 'variation::admin.variations';

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected string|array $validation = SaveVariationRequest::class;


    public function show($id): VariationResource
    {
        $entity = $this->getEntity($id);

        return new VariationResource($entity);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Application|Factory|View
     */
    public function edit($id): View|Factory|Application
    {
        $entity = $this->getEntity($id);
        $variationResource = new VariationResource($entity);

        return view("{$this->viewPath}.edit",
            [
                'variation' => $entity,
                'variation_resource' => $variationResource->response()->content(),
            ]
        );
    }
}
