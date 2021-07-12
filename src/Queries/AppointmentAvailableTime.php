<?php

namespace GorillaDash\LaravelWebsite\Queries;

class AppointmentAvailableTime extends QueryAbstract
{
    /**
     * @var string Query name.
     */
    protected $queryName = 'appointmentAvailableTime';

    protected function fields(): void
    {
        $this->query->fields('appointmentAvailableTime');
        $this->query->appointmentAvailableTime->fields(
            'type',
            'date',
            'times'
        );
    }

    protected function applyRequestParams(): void
    {
        if ($slug = $this->getParam('slug')) {
            $this->query->appointmentAvailableTime->attribute('slug', $slug);
        }

        if ($date = $this->getParam('date')) {
            $this->query->appointmentAvailableTime->attribute('date', $date);
        }

        if ($type = $this->getParam('type')) {
            $this->query->appointmentAvailableTime->attribute('type', $type);
        }

    }
}
