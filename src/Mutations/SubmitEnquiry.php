<?php

namespace GorillaDash\LaravelWebsite\Mutations;

use Illuminate\Support\Arr;
use Wheredidgogogo\Nameparser\Nameparser;

class SubmitEnquiry extends MutationAbstract
{
    /**
     * @var string Query name.
     */
    protected $queryName = '';

    /**
     * Defines fields
     *
     * @return void
     */
    protected function fields(): void
    {
    }

    /**
     * Apply request params.
     */
    protected function applyRequestParams(): void
    {
        $parser = new Nameparser();
        if ($name = $this->getParam('name')) {
            $formatName = $parser->parse_name($name);
            $firstName = Arr::get($formatName, 'fname');
            $lastName = Arr::get($formatName, 'lname');
        } else {
            $firstName = $this->getParam('first_name');
            $lastName = $this->getParam('last_name');
        }

        $fields = [
            [
                'name' => 'Message',
                'value' => urldecode($this->getParam('message')),
            ],
        ];

        foreach ((array)$this->getParam('fields') as $key => $item) {
            $fields[] = [
                'name' => $key,
                'value' => urldecode($item),
            ];
        }

        $this->query->field('submitEnquiry')
            ->attributes([
                'name' => $this->getParam('enquiry_name'),
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $this->getParam('email'),
                'ip' => $this->getParam('ip'),
                'mobile' => $this->getParam('mobile'),
                'business_name' => $this->getParam('business_name'),
                'fields' => $fields,
                'tribes' => [
                    $this->getParam('tribe'),
                ],
                'gorilla_user_key' => $this->getParam('gorilla_user_key'),
            ]);
    }
}
