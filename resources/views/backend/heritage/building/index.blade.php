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

            <div class="box-tools pull-right">
                @include('backend.heritage.includes.building-header-buttons', ['resource' => $resource])
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            @if(count($resource->getProductions()) > 0)
                @foreach($resource->getProductions() as $k => $production)
                <div class="row">
                    <div class="col-lg-2 col-lg-offset-2"><h4>Building #{{ $k }}
                            <small><a title="{{ trans('menus.backend.heritage.buildings.edit') }}" class="btn btn-xs btn-warning" href="{{ route('admin.heritage.buildings.edit', [$resource->getId(), $production->getId()]) }}"><i class="fa fa-edit"></i></a></small></h4></div>
                </div>
                <div class="row">
                    <div class="col-lg-2">Building Type</div>
                    <div class="col-lg-10">{{ $production->getBuilding()->getType() }}</div>
                </div>
                <div class="row">
                    <div class="col-lg-2">Heritage Resource Types</div>
                    <div class="col-lg-10">
                        @foreach ($production->getBuilding()->getHeritageResourceTypes() as $type)
                            {{ $type->getNameRo() }},
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2">Architectural Styles</div>
                    <div class="col-lg-10">
                        @foreach ($production->getBuilding()->getArchitecturalStyles() as $style)
                            {{ $style->getNameRo() }},
                        @endforeach
                    </div>
                </div>
                @endforeach
            @else
                <h4>{{ trans('labels.backend.heritage.resources.no_buildings') }}. {{ link_to_route('admin.heritage.buildings.create', trans('menus.backend.heritage.buildings.create'), $resource->getId()) }}?</h4>
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
