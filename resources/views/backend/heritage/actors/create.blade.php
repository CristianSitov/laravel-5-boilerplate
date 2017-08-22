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
            <div class="form-group">
                {{ Form::label('name', trans('validation.attributes.backend.heritage.actors.name'), ['class' => 'col-lg-2 col-xs-12 control-label']) }}

                <div class="col-lg-2 col-xs-12">
                    {{ Form::text('appelation', '', ['class' => 'form-control']) }}
                </div>
                <div class="col-lg-4 col-xs-12">
                    {{ Form::text('first_name', '', ['class' => 'form-control']) }}
                </div>
                <div class="col-lg-4 col-xs-12">
                    {{ Form::text('last_name', '', ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('nick_name', trans('validation.attributes.backend.heritage.actors.nick_name'), ['class' => 'col-lg-2 col-xs-12 control-label']) }}
                <div class="col-lg-6">
                    {{ Form::text('nick_name', '', ['class' => 'form-control']) }}
                </div>

                {{ Form::label('is_legal', trans('validation.attributes.backend.heritage.actors.legal'), ['class' => 'col-lg-2 col-xs-12 control-label']) }}
                <div class="col-lg-2">
                    {{ Form::radio('is_legal', 'true', ['class' => 'form-control']) }}&nbsp;&nbsp;<span>Yes</span><br />
                    {{ Form::radio('is_legal', 'false', ['class' => 'form-control']) }}&nbsp;&nbsp;<span>No</span>
                </div>
            </div>
            <div class="form-group">
                <hr />
            </div>
            <div class="form-group">
                {{ Form::label('keywords', trans('validation.attributes.backend.heritage.actors.keywords'), ['class' => 'col-lg-2 col-xs-12 control-label']) }}
                
                <div class="col-lg-10">
                    {{ Form::text('keywords', '', ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('description', trans('validation.attributes.backend.heritage.actors.description'), ['class' => 'col-lg-2 col-xs-12 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::textarea('description', '', ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="form-group">
                <hr />
            </div>
            <div class="form-group">
                {{ Form::label('date_birth', trans('validation.attributes.backend.heritage.actors.date_birth'), ['class' => 'col-lg-2 col-xs-12 control-label']) }}
                <div class="col-lg-4">
                    {{ Form::text('date_birth', '', ['class' => 'form-control']) }}
                </div>
                {{ Form::label('date_death', trans('validation.attributes.backend.heritage.actors.date_death'), ['class' => 'col-lg-2 col-xs-12 control-label']) }}
                <div class="col-lg-4">
                    {{ Form::text('date_death', '', ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('place_birth', trans('validation.attributes.backend.heritage.actors.place_birth'), ['class' => 'col-lg-2 col-xs-12 control-label']) }}
                <div class="col-lg-4">
                    {{ Form::text('place_birth', '', ['class' => 'form-control']) }}
                </div>
                {{ Form::label('place_death', trans('validation.attributes.backend.heritage.actors.place_death'), ['class' => 'col-lg-2 col-xs-12 control-label']) }}
                <div class="col-lg-4">
                    {{ Form::text('place_death', '', ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="form-group">
                <hr />
            </div>
            <div class="form-group">
                {{ Form::label('relationship', trans('validation.attributes.backend.heritage.actors.relationship'), ['class' => 'col-lg-2 col-xs-12 control-label']) }}
                <div class="col-lg-4">
                    {{ Form::selectActorRelationshipTypes('relationship', null, ['class' => 'input-sm col-lg-8']) }}
                </div>
            </div>
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
