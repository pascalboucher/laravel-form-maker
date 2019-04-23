<?php

namespace Belvedere\FormMaker\Models\Form;

use Belvedere\FormMaker\Contracts\Ranking\RankingContract;
use Belvedere\FormMaker\Http\Resources\FormResource;
use Belvedere\FormMaker\Listeners\ValidateProperties;
use Belvedere\FormMaker\Traits\{
    HasInputs,
    Attributes\HasFormAttributes,
    Attributes\HasAutocomplete
};

class Form extends AbstractModel
{
    use HasFormAttributes, HasAutocomplete, HasInputs;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'forms';

    /**
     * The current implementation of the RankingContract
     *
     * @var mixed
     */
    protected $rankingProvider;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'saving' => ValidateProperties::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'name',
    ];

    /**
     * Form constructor.
     */
    public function __construct()
    {
        parent::__construct([]);

        $this->rankingProvider = resolve(RankingContract::class);

        dd($this->rankingProvider);
    }

    /**
     * Specifies the form url action.
     *
     * @param string $action
     * @return self
     */
    public function action(string $action): self
    {
        $this->html_attributes = ['action' => $action];

        return $this;
    }

    /**
     * Specifies the form http method.
     *
     * @param string $method
     * @return self
     */
    public function method(string $method): self
    {
        $this->html_attributes = ['method' => $method];

        return $this;
    }

    /**
     * Return the form inputs rules in a form request format.
     *
     * @return array
     * @throws \Exception
     */
    public function rules(): array
    {
        return $this->inputs()->mapWithKeys(function ($input) {
            if ($input->rules) {
                return [$input->html_attributes['name'] => implode('|', $input->rules)];
            }
            return [];
        })->all();
    }

    /**
     * Transform the form to JSON.
     *
     * @return \Belvedere\FormMaker\Http\Resources\FormResource
     */
    public function toApi(): FormResource
    {
        return new FormResource($this);
    }
}
