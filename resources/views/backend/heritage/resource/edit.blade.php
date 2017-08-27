@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.heritage.resources.management') . ' | ' . trans('labels.backend.heritage.resources.edit'))

@section('after-styles')
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
        {{ trans('labels.backend.heritage.resources.edit') }}
    </h4>

@endsection

@section('content')
    {{ Form::model($resource, ['route' => ['admin.heritage.resource.update', $resource->getid()], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PUT']) }}

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.heritage.resources.general') }}</h3>

                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>
            </div>

            <div class="box-body">
                <div class="form-group names">
@foreach($resource->getNames() as $k => $name)
                    <div id="names{{ $k+1 }}" class="clonedInput">
                        {{ Form::label('name[]', trans('validation.attributes.backend.heritage.resources.name'), ['class' => 'col-lg-2 col-xs-12 control-label']) }}

                        <div class="col-lg-10 col-xs-12">
                            <div class="col-lg-8 col-xs-10">
                                <div class="input-group mb-10">
                                    <span class="input-group-addon">{{ Form::label('current_name', trans('validation.attributes.backend.heritage.resources.current'), ['class' => 'current_name']) }}
                                        {{ Form::radio('current_name', $name->getCurrent(), ['class' => 'control-label current_name']) }}</span>
                                    {{ Form::text('name['.$name->getId().']', $name->getName(), ['class' => 'form-control input_name', 'placeholder' => trans('validation.attributes.backend.heritage.resources.name')]) }}
                                </div>
                                <div class="input-group mb-10">
                                    <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_from') }}</span>
                                    {{ Form::text('name_date_from['.$name->getId().']', $name->getDateFrom() ?? '', ['class' => 'form-control input_date_from']) }}
                                    <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_to') }}</span>
                                    {{ Form::text('name_date_to['.$name->getId().']',  $name->getDateTo() ?? '', ['class' => 'form-control input_date_to']) }}
                                </div>
                            </div>
                            <div class="col-lg-4 col-xs-2">
                                <button type="button" class="btn btn-primary btn-sm clone"><span class="fa fa-plus"></span>&nbsp;<span class="hidden-sm hidden-xs">{{ trans('validation.attributes.backend.heritage.resources.add_name_button') }}</span></button>
                                <button type="button" class="btn btn-danger btn-sm remove"><span class="fa fa-close"></span>&nbsp;<span class="hidden-sm hidden-xs">{{ trans('validation.attributes.backend.heritage.resources.delete_name_button') }}</span></button>
                            </div>
                        </div>
                    </div>
@endforeach
                </div>

                <div class="form-group">
                    {{ Form::label('property_type', trans('validation.attributes.backend.heritage.resources.property_type'), ['class' => 'col-lg-2 col-xs-12 control-label']) }}

                    <div class="col-lg-4 col-xs-12">
                        {{ Form::select('property_type', $property_types, $resource->getPropertyType(), ['required' => 'required', 'class' => 'col-lg-10 basic-select2 control-label']) }}
                    </div>

                    {{ Form::label('type', trans('validation.attributes.backend.heritage.resources.type'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-4 col-xs-12">
                        {{ Form::select('type', $resource_type_classifications, $resource->getResourceTypeClassification()->getId(), ['required' => 'required', 'class' => 'col-lg-10 basic-select2 control-label']) }}
                    </div>
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('description', trans('validation.attributes.backend.heritage.resources.description'), ['class' => 'col-lg-2 col-xs-12 control-label']) }}

                    <div class="col-lg-10 col-xs-12">
                        {{ Form::textarea('description', $resource->getDescription()->getNote(), ['class' => 'form-control description', 'placeholder' => trans('validation.attributes.backend.heritage.resources.description'), 'required' => 'required']) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('description_ro', trans('validation.attributes.backend.heritage.resources.description_ro'), ['class' => 'col-lg-2 col-xs-12 control-label']) }}

                    <div class="col-lg-10 col-xs-12">
                        {{ Form::textarea('description_ro', $resource->getDescription()->getNoteRo(), ['class' => 'form-control description', 'placeholder' => trans('validation.attributes.backend.heritage.resources.description_ro'), 'required' => 'required']) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('district', trans('validation.attributes.backend.heritage.resources.address'), ['class' => 'col-lg-2 col-xs-12 control-label']) }}

                    <div class="col-lg-3">
                        {{ Form::select('district', $administrative_subdivision, $resource->getPlace()->getPlaceAddress()->getStreetName() && $resource->getPlace()->getPlaceAddress()->getStreetName()->getAdministrativeSubdivision() ? $resource->getPlace()->getPlaceAddress()->getStreetName()->getAdministrativeSubdivision()->getId() : '', ['required' => 'required', 'class' => 'col-lg-2 control-label basic-select2']) }}
                    </div><!--col-lg-10-->
                    <div class="col-lg-4">
                        {{ Form::select('street', $street_names, $resource->getPlace()->getPlaceAddress()->getStreetName() ? $resource->getPlace()->getPlaceAddress()->getStreetName()->getId() : '', ['required' => 'required', 'class' => 'col-lg-2 control-label basic-select2']) }}
                    </div>
                    <div class="col-lg-1">
                        {{ Form::text('number', $resource->getPlace()->getPlaceAddress() ? $resource->getPlace()->getPlaceAddress()->getNumber() : '', ['required' => 'required', 'class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.heritage.resources.number')]) }}
                    </div>
                </div><!--form control-->

                <div class="form-group types">
@foreach($resource->getProtectionTypes() as $i => $protection)
                    <div id="types{{ $i+1 }}" class="clonedInput mb-10">
                        {{ Form::label('protection_type[]', trans('validation.attributes.backend.heritage.resources.protection_type'), ['class' => 'col-lg-2 col-xs-12 control-label']) }}

                        <div class="col-lg-9 col-xs-11 duplicable">
                            <div class="col-lg-4">
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <label>Current?&nbsp;</label><input type="radio" name="current_type" class="current_type" value="{{ $protection->getId() }}" {{ ($protection->getCurrent()) ? "checked" : "" }}>
                                </span>
                                    {{ Form::select('protection_type['.$protection->getId().']', $protection_types, $protection->getType(), ['class' => 'col-lg-4 form-control input_protection_type']) }}
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_from') }}</span>
                                    {{ Form::text('protection_type_date_from['.$protection->getId().']', $protection->getDateFrom() ?? '', ['class' => 'form-control input_type_date_from']) }}
                                    <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_to') }}</span>
                                    {{ Form::text('protection_type_date_to['.$protection->getId().']', $protection->getDateTo() ?? '', ['class' => 'form-control input_type_date_to']) }}
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <button type="button" class="btn btn-primary btn-sm clone">{{ trans('validation.attributes.backend.heritage.resources.add_type_button') }}</button>
                                <button type="button" class="btn btn-danger btn-sm remove">{{ trans('validation.attributes.backend.heritage.resources.delete_type_button') }}</button>
                            </div>
                            <div class="col-lg-11 col-xs-11">&nbsp;</div>
                            <div class="col-lg-2">
                                <div class="input-group cod-lmi">
                                    <span class="input-group-addon"><label>{{ trans('validation.attributes.backend.heritage.resources.protection_code') }}: </label></span>
                                    {{ Form::select('protection_type_legal_set['.$protection->getId().']', $protection_sets, $protection->getSet() ?: '', ['class' => 'col-lg-1 form-control']) }}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                {{ Form::text('protection_type_legal['.$protection->getId().']', $protection->getLegal() ?: '', ['class' => 'form-control']) }}
                            </div>
                            <div class="col-lg-11 col-xs-11">&nbsp;</div>
                            {{ Form::label('protection_type_name['.$protection->getId().']', trans('validation.attributes.backend.heritage.resources.protection_name'), ['class' => 'col-lg-2 control-label label_name']) }}
                            <div class="col-lg-6">
                                {{ Form::text('protection_type_name['.$protection->getId().']', $protection->getName() ?: '', ['class' => 'form-control']) }}
                            </div>
                        </div>
                    </div>
@endforeach
                </div>

            </div><!-- /.box-body -->
        </div><!--box-->

        <div class="box box-info">
            <div class="box-body">
                <div class="pull-left">
                    {{ link_to_route('admin.heritage.resource.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-sm']) }}
                </div><!--pull-left-->

                <div class="pull-right">
                    {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-success btn-sm']) }}
                </div><!--pull-right-->

                <div class="clearfix"></div>
            </div><!-- /.box-body -->
        </div><!--box-->

    {{ Form::close() }}
@endsection

@section('after-scripts')
    <!-- iCheck -->
    {{ Html::script('js/backend/plugin/icheck/icheck.min.js') }}

    <script type="text/javascript">
        $(document).ready(function() {
            $(".basic-select2").select2({
                width: '100%'
            });
            $('.input_protection_type').change(function () {
                if ($(this).find(':selected').val() == 5) {
                    $(this).parents('.duplicable').find('.cod-lmi').hide();
                } else {
                    $(this).parents('.duplicable').find('.cod-lmi').show();
                }
            });

            // http://jsfiddle.net/mjaric/tfFLt/
            var regex = /(^[^\[]+)(?=\[)|(([^\[\]]+)(?=\]))/g;

            var clone = function () {
                var parent = $(this).parents(".clonedInput").parent().attr('class');
                var cloneIndex = $(".clonedInput").length;
                var clonable = $(this).parent().parent().parent();

                clonable.clone(true)
                    .appendTo($(this).parents(".clonedInput").parent())
                    .attr("id", parent + cloneIndex)
                    .find(":input")
                    .each(function () {
                        var match = this.name.match(regex) || [];
                        if (match.length == 2) {
                            this.name = "new_" + match[0] + "[]";
                            this.value = "";
                        }
                        $(this).prop("checked", false);
                    });
            };
            var remove = function () {
                if ($(this).parents(".clonedInput").parent().find('.clonedInput').length > 1) {
                    $(this).parents(".clonedInput").remove();
                }
            }
            $("button.clone").on("click", clone);
            $("button.remove").on("click", remove);
        });
    </script>
@endsection
