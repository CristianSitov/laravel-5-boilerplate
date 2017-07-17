<?php

namespace App\Models\Heritage\Traits\Attribute;

/**
* Class UserAttribute.
*/
trait ResourceAttribute
{
    /**
     * @return string
     */
    public function getShowButtonAttribute()
    {
        return '<a href="'.route('admin.heritage.resource.show', $this->getId()).'" class="btn btn-xs btn-info"><i class="fa fa-search" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.general.crud.view').'"></i></a> ';
    }

    /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        return '<a href="'.route('admin.heritage.resource.edit', $this->getId()).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.general.crud.edit').'"></i></a> ';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        if ($this->getId() != access()->id() && $this->getId() != 1) {
            if ($this->deleted_at) {
                return '<a href="'.route('admin.heritage.resource.restore', $this->getId()).'"
                 data-method="put"
                 data-trans-button-cancel="'.trans('buttons.general.cancel').'"
                 data-trans-button-restore="'.trans('buttons.general.crud.restore').'"
                 data-trans-title="'.trans('strings.backend.general.are_you_sure').'"
                 class="btn btn-xs btn-warning"><i class="fa fa-reply" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.general.crud.restore').'"></i></a> ';
            } else {
                return '<a href="'.route('admin.heritage.resource.destroy', $this->getId()).'"
                 data-method="delete"
                 data-trans-button-cancel="'.trans('buttons.general.cancel').'"
                 data-trans-button-confirm="'.trans('buttons.general.crud.delete').'"
                 data-trans-title="'.trans('strings.backend.general.are_you_sure').'"
                 class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.general.crud.delete').'"></i></a> ';
            }
        }

        return '';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return
            $this->getShowButtonAttribute().
            $this->getEditButtonAttribute().
            $this->getDeleteButtonAttribute();
    }
}
