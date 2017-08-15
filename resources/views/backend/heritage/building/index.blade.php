@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.heritage.resources.management'))

@section('page-header')
    <h4>{{ link_to_route('admin.heritage.resource.index', trans('labels.backend.heritage.resources.list')) }}
        <i class="fa fa-angle-right" aria-hidden="true"></i>
        @if(access()->hasRoles(['Administrator', 1]))
            {{ link_to_route('admin.heritage.resource.edit', $address, $resource->getId()) }}
        @else
            {{ $address }}
        @endif
        <i class="fa fa-angle-right" aria-hidden="true"></i>
        {{ trans('labels.backend.heritage.resources.buildings_list') }}
    <h4>
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
                    <div class="col-lg-9 col-xs-9">
                        <h4>Building #{{ $production->getBuilding()->getCardinality() }}</h4>
                    </div>
                    <div class="col-lg-3 col-xs-3">
                        <div class="row">
                            <div class="col-lg-12 col-xs-12">
                                <small><a title="{{ trans('menus.backend.heritage.buildings.edit') }}" class="btn btn-xs btn-warning" href="{{ route('admin.heritage.buildings.edit', [$resource->getId(), $production->getId()]) }}"><i class="fa fa-edit"></i> {{ trans('menus.backend.heritage.buildings.edit') }}</a></small>
                                <small><a title="{{ trans('menus.backend.heritage.buildings.delete') }}" class="btn btn-xs btn-danger" href="{{ route('admin.heritage.buildings.remove', [$resource->getId(), $production->getId()]) }}"><i class="fa fa-trash"></i> {{ trans('menus.backend.heritage.buildings.delete') }}</a></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-xs-3">
                        <small><a title="{{ trans('menus.backend.heritage.components.all') }}" class="btn btn-xs btn-warning" href="{{ route('admin.heritage.components.index', [$resource->getId(), $production->getId()]) }}"><i class="fa fa-list-ul"></i> {{ trans('menus.backend.heritage.components.all') }}</a></small>
                    </div>
                    <div class="col-lg-9 col-xs-12">
                        <table class="table table-sm table-striped table-hover">
                            <tbody>
                                <tr>
                                    <td><small>{{ trans('validation.attributes.backend.heritage.buildings.type') }}</small></td>
                                    <td>{{ ucfirst($production->getBuilding()->getType()) }}</td>
                                </tr>
                                <tr>
                                    <td><small>{{ trans('validation.attributes.backend.heritage.buildings.floors') }}</small></td>
                                    <td>
@foreach($production->getBuilding()->getLevels() as $level)
                                            {{ trans('strings.backend.building.' . $level) }}@if (!$loop->last),<br />@endif
@endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td><small>{{ trans('validation.attributes.backend.heritage.buildings.resource_types') }}</small></td>
                                    <td>
                                        @if(count($production->getBuilding()->getHeritageResourceTypes()) > 1)
                                            {{ trans('validation.attributes.backend.heritage.buildings.resource_types_mixed') }}:&nbsp;
                                        @elseif (count($production->getBuilding()->getHeritageResourceTypes()) == 1)
                                            {{ trans('validation.attributes.backend.heritage.buildings.resource_types_single') }}:&nbsp;
                                        @endif
                                        @foreach ($production->getBuilding()->getHeritageResourceTypes() as $type)
                                            {{ $type->getNameRo() }}@if (!$loop->last),<br />@endif
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td><small>{{ trans('validation.attributes.backend.heritage.buildings.styles') }}</small></td>
                                    <td>
                                        @foreach ($production->getBuilding()->getArchitecturalStyles() as $style)
                                            {{ $style->getNameRo() }}@if (!$loop->last),<br />@endif
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td><small>{{ trans('validation.attributes.backend.heritage.buildings.materials') }}</small></td>
                                    <td>
                                        @foreach ($production->getBuilding()->getBuildingConsistsOfMaterials() as $materiality)
                                            {{ ucfirst($materiality->getMaterial()->getNameRo()) }}@if (!$loop->last),<br />@endif
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td><small>{{ trans('validation.attributes.backend.heritage.buildings.modifications') }}</small></td>
                                    <td>
                                        @foreach ($production->getBuilding()->getModifications() as $modification)
                                            {{ ucfirst($modification->getModificationEvent()->getModificationType()->getNameRo()) }}@if (!$loop->last),<br />@endif
                                        @endforeach
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row"></div>
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
