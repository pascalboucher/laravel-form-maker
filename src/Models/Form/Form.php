<?php

namespace Belvedere\FormMaker\Models\Form;

use Belvedere\FormMaker\Models\Model;
use Belvedere\FormMaker\Traits\Nodes\HasNodes;
use Belvedere\FormMaker\Listeners\CascadeDelete;
use Belvedere\FormMaker\Traits\Rankings\HasRankings;
use Belvedere\FormMaker\Http\Resources\Form\FormResource;
use Belvedere\FormMaker\Contracts\Models\Form\FormContract;
use Belvedere\FormMaker\Traits\Repositories\HasNodeRepository;

class Form extends Model implements FormContract
{
    use HasNodes, HasNodeRepository, HasRankings;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'deleting' => CascadeDelete::class,
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
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('form-maker.database.forms_table', 'forms');

        $this->addAvailableAttributes([
            'accept-charset',
            'enctype',
            'name',
            'novalidate',
            'target',
        ]);

        $this->setNodeRepositoryProvider();

        $this->setRankingProvider();
    }

    /**
     * Specifies the form url action.
     *
     * @param string|null $action
     * @return \Belvedere\FormMaker\Contracts\Models\Form\FormContract
     */
    public function action(?string $action): FormContract
    {
        $this->html_attributes = ['action' => $action];

        return $this;
    }

    /**
     * Disable all inputs.
     *
     * @return void
     */
    public function disabled(): void
    {
        $this->setInputsUsability('disabled');
    }

    /**
     * Enable all inputs.
     *
     * @return void
     */
    public function enabled(): void
    {
        $this->setInputsUsability();
    }

    /**
     * Get the labelable attribute name.
     * for or form.
     *
     * @return string
     */
    public function getLabelableAttributeName(): string
    {
        return 'form';
    }

    /**
     * Specifies the form http method.
     *
     * @param string|null $method
     * @return \Belvedere\FormMaker\Contracts\Models\Form\FormContract
     */
    public function method(?string $method): FormContract
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
        return $this->nodes('inputs')->mapWithKeys(function ($input) {
            if ($input->rules) {
                return [$input->html_attributes['name'] => implode('|', $input->rules)];
            }

            return [];
        })->all();
    }

    /**
     * Set whether the inputs are disabled or not.
     *
     * @param string|null $disabled
     * @return void
     */
    protected function setInputsUsability(?string $disabled = null): void
    {
        foreach ($this->nodes('inputs') as $input) {
            $input->withHtmlAttributes(['disabled' => $disabled])->save();
        }
    }

    /**
     * Transform the form to JSON.
     *
     * @return \Belvedere\FormMaker\Http\Resources\Form\FormResource
     */
    public function toApi(): FormResource
    {
        return new FormResource($this);
    }
}
