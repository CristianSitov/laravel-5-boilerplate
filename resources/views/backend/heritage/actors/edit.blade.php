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
        {{ trans('labels.backend.heritage.actors.edit') }}
    </h4>
@endsection

@section('content')
    {{ Form::model($resource, ['route' => ['admin.heritage.resource.actors.update', $resource->getId(), $actor->getId()], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PUT']) }}

    <div class="box box-success">
        <div class="box-header with-border">
            <h4 class="panel-title">{{ trans('labels.backend.heritage.actors.edit') }}</h4>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div class="form-group">
                {{ Form::label('name', trans('validation.attributes.backend.heritage.actors.name'), ['class' => 'col-lg-2 col-xs-12 control-label']) }}

                <div class="col-lg-2 col-xs-12">
                    {{ Form::text('appelation', $actor->getAppelation(), ['class' => 'form-control']) }}
                </div>
                <div class="col-lg-4 col-xs-12">
                    {{ Form::text('first_name', $actor->getFirstName(), ['class' => 'form-control']) }}
                </div>
                <div class="col-lg-4 col-xs-12">
                    {{ Form::text('last_name', $actor->getLastName(), ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('nick_name', trans('validation.attributes.backend.heritage.actors.nick_name'), ['class' => 'col-lg-2 col-xs-12 control-label']) }}
                <div class="col-lg-6">
                    {{ Form::text('nick_name', $actor->getNickName(), ['class' => 'form-control']) }}
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
                    {{ Form::text('keywords', $actor->getKeywords(), ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('description', trans('validation.attributes.backend.heritage.actors.description'), ['class' => 'col-lg-2 col-xs-12 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::textarea('description', $actor->getDescription(), ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="form-group">
                <hr />
            </div>
            <div class="form-group">
                {{ Form::label('date_birth', trans('validation.attributes.backend.heritage.actors.date_birth'), ['class' => 'col-lg-2 col-xs-12 control-label']) }}
                <div class="col-lg-4">
                    {{ Form::text('date_birth', $actor->getDateBirth(), ['class' => 'form-control']) }}
                </div>
                {{ Form::label('date_death', trans('validation.attributes.backend.heritage.actors.date_death'), ['class' => 'col-lg-2 col-xs-12 control-label']) }}
                <div class="col-lg-4">
                    {{ Form::text('date_death', $actor->getDateDeath(), ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('place_birth', trans('validation.attributes.backend.heritage.actors.place_birth'), ['class' => 'col-lg-2 col-xs-12 control-label']) }}
                <div class="col-lg-4">
                    {{ Form::text('place_birth', $actor->getPlaceBirth(), ['class' => 'form-control']) }}
                </div>
                {{ Form::label('place_death', trans('validation.attributes.backend.heritage.actors.place_death'), ['class' => 'col-lg-2 col-xs-12 control-label']) }}
                <div class="col-lg-4">
                    {{ Form::text('place_death', $actor->getPlaceDeath(), ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="form-group">
                <hr />
            </div>
            <div class="form-group relations">
@foreach($actor->getIsRelatedTo() as $relation)
                <div class="row clonedInput">
                    {{ Form::label('relationship', trans('validation.attributes.backend.heritage.actors.relationship'), ['class' => 'col-lg-2 col-xs-12 control-label']) }}
                    <div class="col-lg-3">
                        {{ Form::selectActorRelationshipTypes('relationship['.$relation->getId().']', $relation->getRelation(), ['class' => 'input-sm col-lg-10']) }}
                    </div>
                    <div class="col-lg-5">
                        <div class="input-group">
                            <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_from') }}</span>
                            {{ Form::text('date_from['.$relation->getId().']', $relation->getSince(), ['class' => 'form-control']) }}
                            <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_to') }}</span>
                            {{ Form::text('date_to['.$relation->getId().']', $relation->getUntil(), ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <button type="button" class="btn btn-danger btn-sm remove">{{ trans('validation.attributes.backend.heritage.resources.delete_type_button') }}</button>
                    </div>
                    <div class="col-lg-12">&nbsp;</div>
                </div>
@endforeach
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-offset-11">
                        <button type="button" class="btn btn-primary btn-sm clone"><span class="fa fa-plus-circle"></span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="box box-success">
        <div class="box-body">
            <div class="pull-left">
                {{ link_to_route('admin.heritage.resource.actors.index', trans('buttons.general.cancel'), [$resource->getId()], ['class' => 'btn btn-danger btn-sm']) }}
            </div>
            <div class="pull-right">
                {{ Form::submit(trans('buttons.general.crud.edit'), ['class' => 'btn btn-success btn-sm']) }}
            </div>
            <div class="clearfix"></div>
        </div>
    </div>


    {{ Form::close() }}
@endsection

@section('after-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            var clone = function () {
                var source = $('.relations');
                var clonable = $('.relations .clonedInput:last');

                clonable.clone(true).each(function(idx, elem) {
                    $(elem).find('input, select')
                        .attr({
                            'name': function(_, id) {
                                return id.replace(/\[.*?\]/g, '[]');
                            },
                            'value': ''
                        });
                }).appendTo(source)
            };

            var remove = function () {
                if ($(this).parents(".clonedInput").parent().find('.clonedInput').length > 1) {
                    $(this).parents(".clonedInput").remove();
                }
            };

            $("button.clone").on("click", clone);
            $("button.remove").on("click", remove);
        });
    </script>
@endsection
