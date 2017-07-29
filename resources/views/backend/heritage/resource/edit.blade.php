@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.heritage.resources.management') . ' | ' . trans('labels.backend.heritage.resources.edit'))

@section('after-styles')
    {{ Html::style("css/backend/plugin/datepicker/bootstrap-datepicker.min.css") }}
@endsection

@section('page-header')
    <h1>
        {{ trans('labels.backend.heritage.resources.edit') }} // {{ ucwords(
                $resource->getPlace()->getPlaceAddress()->getStreetName()->getType() . ' ' .
                $resource->getPlace()->getPlaceAddress()->getStreetName()->getCurrentName() .
                ', no. ' . $resource->getPlace()->getPlaceAddress()->getNumber()) }}
    </h1>
@endsection

@section('content')
    {{ Form::model($resource, ['route' => ['admin.heritage.resource.update', $resource->getid()], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) }}

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.heritage.resources.general') }}</h3>

                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="names">
@foreach($resource->getNames() as $k => $name)
                    <div id="names{{ $k+1 }}" class="form-group clonedInput">
                        {{ Form::label('name[]', trans('validation.attributes.backend.heritage.resources.name'), ['class' => 'col-lg-2 control-label label_name']) }}

                        <div class="col-lg-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <label>Current?&nbsp;</label><input type="radio" name="current_name" class="current_name" value="{{ $k }}" {{ ($name->getCurrent()) ? "checked" : "" }}>
                                </span>
                                {{ Form::text('name['.$name->getId().']', $name->getName(), ['class' => 'form-control input_name', 'placeholder' => trans('validation.attributes.backend.heritage.resources.name')]) }}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group input-daterange">
                                <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_from') }}</span>
                                {{ Form::text('name_date_from['.$name->getId().']', $name->getDateFrom() ? $name->getDateFrom()->format('Y') : '', ['class' => 'form-control input_date_from']) }}
                                <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_to') }}</span>
                                {{ Form::text('name_date_to['.$name->getId().']',  $name->getDateFrom() ? $name->getDateTo()->format('Y') : '', ['class' => 'form-control input_date_to']) }}
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <button type="button" class="btn btn-primary btn-sm clone">{{ trans('validation.attributes.backend.heritage.resources.add_name_button') }}</button>
                            <button type="button" class="btn btn-danger btn-sm remove">{{ trans('validation.attributes.backend.heritage.resources.delete_name_button') }}</button>
                        </div>
                    </div><!--form control-->
@endforeach
                </div>

                <div class="form-group">
                    {{ Form::label('type', trans('validation.attributes.backend.heritage.resources.type'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-2">
                        {{ Form::select('type', $resource_type_classifications, $resource->getResourceTypeClassification()->getId(), ['required' => 'required', 'class' => 'col-lg-10 basic-select2 control-label']) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('description', trans('validation.attributes.backend.heritage.resources.description'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::textarea('description', $resource->getDescription()->getNote(), ['class' => 'form-control description', 'placeholder' => trans('validation.attributes.backend.heritage.resources.description'), 'required' => 'required']) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('district', trans('validation.attributes.backend.heritage.resources.address'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-3">
                        {{ Form::select('district', $administrative_subdivision, $resource->getPlace()->getAdministrativeSubdivision() ? $resource->getPlace()->getAdministrativeSubdivision()->getId() : '', ['required' => 'required', 'class' => 'col-lg-2 control-label basic-select2']) }}
                    </div><!--col-lg-10-->
                    <div class="col-lg-5">
                        {{ Form::select('street', $street_names, $resource->getPlace()->getPlaceAddress() ? $resource->getPlace()->getPlaceAddress()->getStreetName()->getId() : '', ['required' => 'required', 'class' => 'col-lg-2 control-label basic-select2']) }}
                    </div>
                    <div class="col-lg-2">
                        {{ Form::text('number', $resource->getPlace()->getPlaceAddress() ? $resource->getPlace()->getPlaceAddress()->getNumber() : '', ['required' => 'required', 'class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.heritage.resources.number')]) }}
                    </div>
                </div><!--form control-->

                <div class="types">
@foreach($resource->getProtectionTypes() as $i => $protection)
                    <div id="types{{ $i+1 }}" class="clonedInput">
                        <div class="form-group">
                            {{ Form::label('protection_type[]', trans('validation.attributes.backend.heritage.resources.protection_type'), ['class' => 'col-lg-2 control-label label_name']) }}

                            <div class="col-lg-4">
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <label>Current?&nbsp;</label><input type="radio" name="current_type" class="current_type" value="{{ $i }}" {{ ($protection->getCurrent()) ? "checked" : "" }}>
                                </span>
                                    {{ Form::select('protection_type['.$protection->getId().']', $protection_types, $protection->getType(), ['class' => 'col-lg-4 form-control input_type']) }}
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input-group input-daterange">
                                    <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_from') }}</span>
                                    {{ Form::text('protection_type_date_from['.$protection->getId().']', $protection->getDateFrom() ? $protection->getDateFrom()->format('Y') : '', ['class' => 'form-control input_type_date_from']) }}
                                    <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_to') }}</span>
                                    {{ Form::text('protection_type_date_to['.$protection->getId().']', $protection->getDateTo() ? $protection->getDateTo()->format('Y') : '', ['class' => 'form-control input_type_date_to']) }}
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <button type="button" class="btn btn-primary btn-sm clone">{{ trans('validation.attributes.backend.heritage.resources.add_type_button') }}</button>
                                <button type="button" class="btn btn-danger btn-sm remove">{{ trans('validation.attributes.backend.heritage.resources.delete_type_button') }}</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-2">
                                <div class="input-group">
                                    <span class="input-group-addon"><label>Legal: </label></span>
                                    {{ Form::text('protection_type_legal['.$protection->getId().']', $protection->getLegal() ?: '', ['class' => 'col-lg-10 form-control']) }}
                                </div>
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
                    {{ link_to_route('admin.heritage.resource.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-xs']) }}
                </div><!--pull-left-->

                <div class="pull-right">
                    {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-success btn-xs']) }}
                </div><!--pull-right-->

                <div class="clearfix"></div>
            </div><!-- /.box-body -->
        </div><!--box-->

    {{ Form::close() }}
@endsection

@section('after-scripts')
    <!-- iCheck -->
    {{ Html::script('js/backend/plugin/icheck/icheck.min.js') }}
    <!-- Bootstrap Datepicker -->
    {{ Html::script('js/backend/plugin/datepicker/bootstrap-datepicker.min.js') }}
    <!-- WYSIWYG Editor -->
    {{ Html::script('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}
    {{ Html::script('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}

    <script type="text/javascript">
        $(document).ready(function() {
            $(".basic-select2").select2({
                width: '100%'
            });
            var dateOptions = {
                autoclose: true,
                clearBtn: true,
                format: 'yyyy',
                weekStart: 1,
                startView: 2,
                minViewMode: 2,
                maxViewMode: 3,
                todayBtn: true
            };
            $('.input-daterange').datepicker(dateOptions);
            var editorOptions = {
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                filebrowserImageUploadUrl: '/admin/heritage/laravel-filemanager/upload?type=Images&_token=',
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                filebrowserUploadUrl: '/admin/heritage/laravel-filemanager/upload?type=Files&_token='
            };
            $('textarea').ckeditor(editorOptions);

            // http://jsfiddle.net/mjaric/tfFLt/
            var cloneIndex = $(".clonedInput").length;
            var regex = /(^[^\[]+)(?=\[)|(([^\[\]]+)(?=\]))/g;
            var current = /((current_)(.*))/g;

            var clone = function () {
                var source = $(this).parents(".clonedInput").parent().attr('class');
                var check = $(this).parents(".clonedInput").find("input[name^=current_]:checked").val();
                console.log(check);

                $(this).parents(".clonedInput").clone()
                    .appendTo($(this).parents(".clonedInput").parent())
                    .attr("id", source + cloneIndex)
                    .find(":input")
                    .each(function () {
                        var match = this.name.match(regex) || [];
                        if (match.length == 2) {
                            this.name = "new_" + match[0] + "[]";
                            this.value = "";
                        }
                        $(this).prop("checked", false);
                    })
                    .on("click", 'button.clone', clone)
                    .on("click", 'button.remove', remove);

                // fix input names


                $('.input-daterange').datepicker(dateOptions);
            };
            var remove = function () {
                $(this).parents(".clonedInput").remove();
            }
            $("button.clone").on("click", clone);
            $("button.remove").on("click", remove);
        });
    </script>
@endsection
