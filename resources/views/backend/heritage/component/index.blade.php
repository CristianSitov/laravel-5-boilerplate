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
        {{ link_to_route('admin.heritage.buildings.index', trans('labels.backend.heritage.resources.buildings_list'), [$resource->getId(), $production->getId()]) }}
        <i class="fa fa-angle-right" aria-hidden="true"></i>
        {{ trans('labels.backend.heritage.component.pages.list') }}
    </h4>
@endsection

@section('content')
    @if(count($production->getBuilding()->getComponents()) > 0)
        @foreach($production->getBuilding()->getComponents() as $k => $component)
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('strings.backend.component.' . $component->getType()) }} #{{ $component->getOrder() }}
                <span class="label label-info"><i class="fa fa-arrow-up"></i>  {{ trans('menus.backend.heritage.components.move_up') }}</span>
                <span class="label label-info"><i class="fa fa-arrow-down"></i>  {{ trans('menus.backend.heritage.components.move_down') }}</span></h3>

            @if('facade' == $component->getType())
            <div class="box-tools pull-right">
                @include('backend.heritage.includes.component-header-buttons', ['resource' => $resource])
            </div><!--box-tools pull-right-->
            @endif
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="row">
                <div class="col-lg-2 col-xs-3">
                {{--@if(count($component->getArchitecturalElements())) > 0)--}}
                    <small><a title="{{ trans('menus.backend.heritage.components.edit') }}" class="btn btn-xs btn-warning" href="{{ route('admin.heritage.components.edit', [$resource->getId(), $production->getId(), $component->getId()]) }}"><i class="fa fa-edit"></i> {{ trans('menus.backend.heritage.components.edit') }}</a></small>
                {{--@else--}}
                {{--@endif--}}
                </div>
                <div class="col-lg-10 col-xs-9">
                    <table class="table">
            @if(count($component->getArchitecturalElements()) > 0)
                @foreach($component->getArchitecturalElements() as $element)
                        <tr>
                            <td><small>{{ $element->getId() }}</small></td>
                            <td>{{ $element->getAspectRo() }}</td>
                            <td>{{ $element->getAreaRo() }}</td>
                            <td>{{ $element->getValueRo() }}</td>
                            <td>{{ $element->getModified() }}</td>
                            <td><small><a title="{{ trans('menus.backend.heritage.elements.remove') }}" class="btn btn-xs btn-danger" href="{{ route('admin.heritage.components.element.remove', [$resource->getId(), $production->getId(), $component->getId(), $element->getUuid()]) }}"><i class="fa fa-trash"></i> {{ trans('menus.backend.heritage.elements.remove') }}</a></small></td>
                        </tr>
                @endforeach
            @endif
                    </table>
                </div>
            </div>
        </div><!-- /.box-body -->
    </div><!--box-->
        @endforeach
    @else
        <div class="box box-info collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('history.backend.recent_history') }}</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div><!-- /.box tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <h4>{{ trans('labels.backend.heritage.resources.no_components') }}. {{ link_to_route('admin.heritage.components.create', trans('menus.backend.heritage.components.create'), [$resource->getId(), $production->getId()]) }}?</h4>
            </div><!-- /.box-body -->
        </div><!--box box-success-->
    @endif

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
