@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.heritage.resources.management'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.heritage.resources.management') }}
        <small>{{ trans('labels.backend.heritage.resources.buildings_list') }}</small>
    </h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.heritage.resources.buildings_list') }}</h3>
        </div><!-- /.box-header -->

        <div class="box-body">
            @if(count($resource->getProductions()) > 0)
                ???
            @else
                <h4>{{ trans('labels.backend.heritage.resources.no_buildings') }}. {{ link_to_route('admin.heritage.building.edit', trans('menus.backend.heritage.buildings.create'), $resource->getId()) }}?</h4>
            @endif
        </div><!-- /.box-body -->
    </div><!--box-->

    @if (access()->hasRoles(['Administrator', 1]))
    <div class="box box-info collapsed-box">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('history.backend.recent_history') }}</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box tools -->
        </div><!-- /.box-header -->
        <div class="box-body">
            {!! history()->renderType('Building') !!}
        </div><!-- /.box-body -->
    </div><!--box box-success-->
    @endif
@endsection
