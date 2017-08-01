<div class="pull-right mb-10 hidden-sm hidden-xs">
    {{ link_to_route('admin.heritage.resource.index', trans('menus.backend.heritage.resources.all'), [], ['class' => 'btn btn-primary btn-xs']) }}
    {{ link_to_route('admin.heritage.resource.create', trans('menus.backend.heritage.resources.create'), [], ['class' => 'btn btn-success btn-xs']) }}
</div><!--pull right-->

<div class="pull-right mb-10 hidden-lg hidden-md">
    <div class="btn-group">
        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            {{ trans('menus.backend.heritage.resources.main') }} <span class="caret"></span>
        </button>

        <ul class="dropdown-menu" role="menu">
            <li>{{ link_to_route('admin.heritage.resource.index', trans('menus.backend.heritage.resources.all')) }}</li>
            @if (access()->hasRoles(['Administrator', 1]))
            <li>{{ link_to_route('admin.heritage.resource.create', trans('menus.backend.heritage.resources.create')) }}</li>
            @endif
        </ul>
    </div><!--btn group-->
</div><!--pull right-->

<div class="clearfix"></div>