@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.heritage.resources.management') . ' | ' . trans('labels.backend.heritage.resources.edit'))

@section('after-styles')
    {{ Html::style("css/backend/plugin/jquery-ui.min.css") }}
    {{ Html::style("css/backend/plugin/selectize/selectize.bootstrap3.css") }}
    {{ Html::style("css/backend/plugin/selectize/selectize.default.css") }}
    {{ Html::style("css/backend/plugin/datepicker/bootstrap-datepicker.min.css") }}
@endsection

@section('page-header')
    <h4>{{ link_to_route('admin.heritage.resource.index', trans('labels.backend.heritage.resources.list')) }}
        <i class="fa fa-angle-right" aria-hidden="true"></i>
        @if(access()->hasRoles(['Desk', 1]))
            {{ link_to_route('admin.heritage.resource.edit', $address, $resource->getId()) }}
        @else
            {{ $address }}
        @endif
        <i class="fa fa-angle-right" aria-hidden="true"></i>
        {{ trans('labels.backend.heritage.actors.create') }}
    </h4>
@endsection

@section('content')
    {{ Form::model($resource, ['route' => ['admin.heritage.buildings.store', $resource->getId()], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'POST']) }}

    <div class="box box-success">
        <div class="box-header with-border">
            <h4 class="panel-title">{{ trans('labels.backend.heritage.actors.create') }}</h4>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
            </div>
        </div>
        <div class="box-body">

        </div>
    </div>

    <div class="box box-success">
        <div class="box-body">
            <div class="pull-left">
                {{ link_to_route('admin.access.user.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-sm']) }}
            </div>
            <div class="pull-right">
                {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-success btn-sm']) }}
            </div>
            <div class="clearfix"></div>
        </div>
    </div>


    {{ Form::close() }}
@endsection

@section('after-scripts')
@endsection
