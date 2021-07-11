<?php

namespace GorillaDash\LaravelWebsite\Mutations;

use Eastwest\Json\Json;
use Illuminate\Support\Arr;

class SubmitAppointment extends MutationAbstract
{

    protected function fields(): void
    {
    }

    protected function applyRequestParams(): void
    {
        $this->query->field('submitAppointment')
            ->attributes([
                'slug' => $this->getParam('slug'),
                'type' => $this->getParam('type'),
                'first_name' => $this->getParam('first_name'),
                'last_name' => $this->getParam('last_name'),
                'email' => $this->getParam('email'),
                'phone' => $this->getParam('phone'),
                'datetime' => $this->getParam('datetime'),
                'comments' => $this->getParam('comments'),
                'data' => $this->getParam('data') ? Json::encode(Arr::wrap($this->getParam('data'))) : null,
            ]);
    }
}
