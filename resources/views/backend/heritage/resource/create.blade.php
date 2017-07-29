@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.heritage.resources.management') . ' | ' . trans('labels.backend.heritage.resources.create'))

@section('after-styles')
    {{ Html::style("css/backend/plugin/datepicker/bootstrap-datepicker.min.css") }}
@endsection

@section('page-header')
    <h1>
        {{ trans('labels.backend.heritage.resources.management') }}
        <small>{{ trans('labels.backend.heritage.resources.create') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.heritage.resource.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) }}

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.heritage.resources.create') }}</h3>

                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="names">

                    <div id="names1" class="form-group clonedInput">
                        {{ Form::label('name[]', trans('validation.attributes.backend.heritage.resources.name'), ['class' => 'col-lg-2 control-label label_name']) }}

                        <div class="col-lg-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <label>Current?&nbsp;</label><input type="radio" name="current_name" class="current_name" value="0">
                                </span>
                                {{ Form::text('name[]', '', ['class' => 'form-control input_name', 'required', 'placeholder' => trans('validation.attributes.backend.heritage.resources.name')]) }}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group input-daterange">
                                <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_from') }}</span>
                                {{ Form::text('name_date_from[]', '', ['class' => 'form-control input_date_from datepicker']) }}
                                <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_to') }}</span>
                                {{ Form::text('name_date_to[]', date("Y"), ['class' => 'form-control input_date_to datepicker']) }}
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <button type="button" class="btn btn-primary btn-sm clone">{{ trans('validation.attributes.backend.heritage.resources.add_name_button') }}</button>
                            <button type="button" class="btn btn-danger btn-sm remove">{{ trans('validation.attributes.backend.heritage.resources.delete_name_button') }}</button>
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    {{ Form::label('type', trans('validation.attributes.backend.heritage.resources.type'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-2">
                        {{ Form::select('type', $resource_type_classifications, null, ['required' => 'required', 'class' => 'col-lg-2 control-label basic-select2']) }}
                    </div>
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('description', trans('validation.attributes.backend.heritage.resources.description'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::textarea('description', null, ['class' => 'form-control description', 'placeholder' => trans('validation.attributes.backend.heritage.resources.description'), 'required' => 'required']) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('district', trans('validation.attributes.backend.heritage.resources.address'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-3">
                        {{ Form::select('district', $administrative_subdivision, '', ['required' => 'required', 'class' => 'col-lg-2 control-label basic-select2']) }}
                    </div><!--col-lg-10-->
                    <div class="col-lg-5">
                        {{ Form::select('street', $street_names, '', ['required' => 'required', 'class' => 'col-lg-2 control-label basic-select2']) }}
                    </div>
                    <div class="col-lg-2">
                        {{ Form::text('number', '', ['required' => 'required', 'class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.heritage.resources.number')]) }}
                    </div>
                </div><!--form control-->

                <div id="types">

                    <div id="types1" class="clonedInput">
                        <div class="form-group">
                            {{ Form::label('protection_type[]', trans('validation.attributes.backend.heritage.resources.protection_type'), ['class' => 'col-lg-2 control-label label_name']) }}

                            <div class="col-lg-4">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <label>Current?&nbsp;</label><input type="radio" name="current_type" class="current_type" value="0">
                                    </span>
                                    {{ Form::select('protection_type[]', $protection_types, '', ['class' => 'col-lg-4 form-control input_protection_type']) }}
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input-group input-daterange">
                                    <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_from') }}</span>
                                    {{ Form::text('protection_type_date_from[]', '', ['class' => 'form-control input_type_date_from datepicker']) }}
                                    <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_to') }}</span>
                                    {{ Form::text('protection_type_date_to[]', date("Y"), ['class' => 'form-control input_type_date_to datepicker']) }}
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
                                    {{ Form::text('protection_type_legal[]', '', ['class' => 'col-lg-10 form-control']) }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div><!-- /.box-body -->
        </div><!--box-->

        <div class="box box-info">
            <div class="box-body">
                <div class="pull-left">
                    {{ link_to_route('admin.heritage.resource.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-xs']) }}
                </div><!--pull-left-->

                <div class="pull-right">
                    {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-success btn-xs']) }}
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

            var clone = function () {
                var source = $(this).parents(".clonedInput").parent().attr('class');

                $(this).parents(".clonedInput").clone()
                    .appendTo($(this).parents(".clonedInput").parent())
                    .attr("id", source + cloneIndex)
                    .find("*")
                    .on("click", 'button.clone', clone)
                    .on("click", 'button.remove', remove);

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
