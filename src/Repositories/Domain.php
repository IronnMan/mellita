<?php

namespace Mellita\SaaS\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;
use Mellita\SaaS\Models\Domain as Model;

class Domain extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
