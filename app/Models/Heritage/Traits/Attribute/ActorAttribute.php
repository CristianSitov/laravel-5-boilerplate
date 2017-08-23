<?php

namespace App\Models\Heritage\Traits\Attribute;

/**
* Class UserAttribute.
*/
trait ActorAttribute
{
    /**
     * @return string
     */
    public function getShowButtonAttribute($resource)
    {
//        return '<a href="'.route('admin.heritage.resource.show', $this->getId()).'" class="btn btn-sm btn-info"><i class="fa fa-search" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.general.crud.view').'"></i></a> ';
    }

    /**
     * @return string
     */
    public function getEditButtonAttribute($resource)
    {
        if (access()->hasPermission('desk')) {
            return '<a href="' . route('admin.heritage.resource.actors.edit', [$resource->getId(), $this->getId()]) . '" class="btn btn-sm btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('buttons.general.crud.edit') . '"></i></a> ';
        }

        return '';
    }

    /**
     * @return string
     */
    public function getUnlinkButtonAttribute($resource)
    {
        if (access()->hasPermission('desk')) {
            return '<a href="'.route('admin.heritage.resource.actors.detach', [$resource->getId(), $this->getId()]).'"
                data-method="delete"
                data-trans-button-cancel="'.trans('buttons.general.cancel').'"
                data-trans-button-confirm="'.trans('buttons.general.crud.unlink').'"
                data-trans-title="'.trans('strings.backend.general.are_you_sure').'"
                class="btn btn-sm btn-danger"><i class="fa fa-chain-broken" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.general.crud.unlink').'"></i></a> ';
        }

        return '';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute($resource)
    {
        return
            $this->getShowButtonAttribute($resource).
            $this->getEditButtonAttribute($resource).
            $this->getUnlinkButtonAttribute($resource);
    }
}
