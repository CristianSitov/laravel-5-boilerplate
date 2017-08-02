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
                @include('backend.heritage.includes.component-header-buttons', ['resource' => $resource])
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
    @if(count($production->getBuilding()->getComponents()) > 0)
        @foreach($production->getBuilding()->getComponents() as $k => $component)
            <div class="row">
                <div class="col-lg-11">
                    <h3>{{ trans('strings.backend.component.' . $component->getType()) }} #{{ $component->getOrder() }}</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2 col-xs-3">
                {{--@if(count($component->getArchitecturalElements())) > 0)--}}
                    <small><a title="{{ trans('menus.backend.heritage.components.edit') }}" class="btn btn-xs btn-warning" href="{{ route('admin.heritage.components.edit', [$resource->getId(), $production->getId(), $component->getId()]) }}"><i class="fa fa-edit"></i> Edit Component</a></small>
                {{--@else--}}
                {{--@endif--}}
                </div>
                <div class="col-lg-10 col-xs-9">
                    <table class="table">
            @if(count($component->getArchitecturalElements()) > 0)
                @foreach($component->getArchitecturalElements() as $element)
                        <tr>
                            <td><small>{{ $element->getId() }}</small></td>
                            <td>{{ $element->getAreaRo() }}</td>
                            <td>{{ $element->getAspectRo() }}</td>
                            <td>{{ $element->getValueRo() }}</td>
                            <td>{{ $element->getModified() }}</td>
                            <td><small><a title="{{ trans('menus.backend.heritage.elements.remove') }}" class="btn btn-xs btn-danger" href="{{ route('admin.heritage.components.element.remove', [$resource->getId(), $production->getId(), $component->getId(), $element->getUuid()]) }}"><i class="fa fa-trash"></i> Remove Element</a></small></td>
                        </tr>
                @endforeach
            @endif
                    </table>
                </div>
            </div>
        @endforeach
    @else
            <h4>{{ trans('labels.backend.heritage.resources.no_components') }}. {{ link_to_route('admin.heritage.components.create', trans('menus.backend.heritage.components.create'), [$resource->getId(), $production->getId()]) }}?</h4>
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
