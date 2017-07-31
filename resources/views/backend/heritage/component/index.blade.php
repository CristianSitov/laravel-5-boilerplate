@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.heritage.resources.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.heritage.resources.components_list') }}<small>{{ trans('labels.backend.heritage.resources.preview') }}</small></h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.heritage.resources.components_list') }}</h3>

            <div class="box-tools pull-right">
                {{--@include('backend.heritage.includes.building-header-buttons', ['resource' => $resource])--}}
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
    @if(count($building->getComponents()) > 0)
        @foreach($building->getComponents() as $k => $component)
            <div class="row">
                <div class="col-lg-11">
                    <h3>{{ trans('strings.backend.component.' . $component->getType()) }} #{{ $component->getOrder() }}
                        <small><a title="{{ trans('menus.backend.heritage.components.edit') }}" class="btn btn-xs btn-warning" href="{{ route('admin.heritage.components.edit', [$resource->getId(), $building->getId(), $component->getId()]) }}"><i class="fa fa-edit"></i></a></small></h3>
                </div>
                <div class="col-lg-1">
                    <small><a title="{{ trans('menus.backend.heritage.components.create') }}" class="btn btn-xs btn-success" href="{{ route('admin.heritage.components.create', [$resource->getId(), $building->getId()]) }}"><i class="fa fa-plus"></i></a></small>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">

                </div>
            </div>
        @endforeach
    @else
            <h4>{{ trans('labels.backend.heritage.resources.no_components') }}. {{ link_to_route('admin.heritage.components.create', trans('menus.backend.heritage.components.create'), [$resource->getId(), $building->getId()]) }}?</h4>
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
