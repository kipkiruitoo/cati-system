<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class EditSurvey extends AbstractAction
{
    public function getTitle()
    {
        return 'Script';
    }

    public function getIcon()
    {
        return 'voyager-wand';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-primary pull-right view ',
        ];
    }

    public function getDefaultRoute()
    {
        return url('/admin/survey',$this->data->{$this->data->getKeyName()} );
    }

    public function shouldActionDisplayOnDataType()
{
    return $this->dataType->slug == 'surv';
}
}