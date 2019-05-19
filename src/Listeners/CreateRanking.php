<?php

namespace Belvedere\FormMaker\Listeners;

use Belvedere\FormMaker\Contracts\Ranking\RankerContract;
use Illuminate\Database\Eloquent\Model;

class CreateRanking
{
    /**
     * The model with assigned properties.
     *
     * @var \Illuminate\Database\Eloquent\Model $model
     */
    protected $model;

    /**
     * Create the event listener.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model = $model;

        $this->handle();
    }

    /**
     * Associate a rankings with the model.
     *
     * @return void
     */
    protected function handle(): void
    {
        $ranking = resolve(RankerContract::class);

        $ranking->ranks = [];

        $this->model->ranking()->save($ranking);
    }
}
