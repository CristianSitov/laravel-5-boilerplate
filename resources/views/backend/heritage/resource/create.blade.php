@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.heritage.resources.management') . ' | ' . trans('labels.backend.heritage.resources.create'))

@section('after-styles')
    {{ Html::style("css/backend/plugin/wysihtml5/bootstrap3-wysihtml5.min.css") }}
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
                    {{--@include('backend.heritage.includes.header-buttons')--}}
                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->

            <div class="box-body">
                <div id="entry1" class="form-group clonedInput_1">
                    {{ Form::label('name[]', trans('validation.attributes.backend.heritage.resources.name'), ['class' => 'col-lg-2 control-label label_name']) }}

                    <div class="col-lg-5">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <input type="radio" name="current_name" class="current_name" value="0">
                            </span>
                            {{ Form::text('name[]', '', ['class' => 'form-control input_name', 'required', 'placeholder' => trans('validation.attributes.backend.heritage.resources.name')]) }}
                        </div>
                    </div><!--col-lg-10-->
                    <div class="col-lg-2">
                        <div class="input-group">
                            <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_from') }}</span>
                            {{ Form::text('date_from[]', '', ['class' => 'form-control input_date_from datepicker', 'data-inputmask' => '"alias": "yyyy/mm/dd"', 'data-mask']) }}
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="input-group">
                            <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_to') }}</span>
                            {{ Form::text('date_to[]', date("d-m-Y"), ['class' => 'form-control input_date_to datepicker', 'data-inputmask' => '"alias": "yyyy/mm/dd"', 'data-mask']) }}
                        </div>
                    </div>
                </div><!--form control-->
                <div class="form-group">
                    <div class="col-lg-5 col-lg-offset-2">
                        <p>
                            <button type="button" id="add_name" name="btnAdd" class="btn btn-primary">{{ trans('validation.attributes.backend.heritage.resources.add_name_button') }}</button>
                            <button type="button" id="del_name" name="btnDel" class="btn btn-danger"><span class="ui-button-text">{{ trans('validation.attributes.backend.heritage.resources.delete_name_button') }}</span></button>
                        </p>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('type', trans('validation.attributes.backend.heritage.resources.type'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::select('type', $resource_type_classifications, null, ['required' => 'required', 'class' => 'col-lg-2 control-label basic-select2']) }}
                    </div><!--col-lg-10-->
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

                <div id="entryType1" class="form-group clonedType_1">
                    {{ Form::label('protection_type[]', trans('validation.attributes.backend.heritage.resources.protection_type'), ['class' => 'col-lg-2 control-label label_name']) }}

                    <div class="col-lg-5">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <input type="radio" name="current_type" class="current_type" value="0">
                            </span>
                            {{ Form::select('protection_type[]', $protection_types, '', ['class' => 'col-lg-4 form-control input_protection_type', 'placeholder' => trans('validation.attributes.backend.heritage.resources.protection_type')]) }}
                        </div>
                    </div><!--col-lg-10-->
                    <div class="col-lg-2">
                        <div class="input-group">
                            <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_from') }}</span>
                            {{ Form::text('protection_type_date_from[]', '', ['class' => 'form-control input_type_date_from datepicker', 'data-inputmask' => '"alias": "yyyy/mm/dd"', 'data-mask']) }}
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="input-group">
                            <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_to') }}</span>
                            {{ Form::text('protection_type_date_to[]', date("d-m-Y"), ['class' => 'form-control input_type_date_to datepicker', 'data-inputmask' => '"alias": "yyyy/mm/dd"', 'data-mask']) }}
                        </div>
                    </div>
                </div><!--form control-->
                <div class="form-group">
                    <div class="col-lg-5 col-lg-offset-2">
                        <p>
                            <button type="button" id="add_type" name="btnAdd" class="btn btn-primary">{{ trans('validation.attributes.backend.heritage.resources.add_type_button') }}</button>
                            <button type="button" id="del_type" name="btnDel" class="btn btn-danger"><span class="ui-button-text">{{ trans('validation.attributes.backend.heritage.resources.delete_type_button') }}</span></button>
                        </p>
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
    {{ Html::script('js/backend/heritage/script.js') }}
    <!-- iCheck -->
    {{ Html::script('js/backend/plugin/icheck/icheck.min.js') }}
    <!-- Bootstrap Datepicker -->
    {{ Html::script('js/backend/plugin/datepicker/bootstrap-datepicker.min.js') }}
    <!-- Bootstrap WYSIHTML5 -->
    {{ Html::script('js/backend/plugin/wysihtml5/bootstrap3-wysihtml5.all.min.js') }}

    <script type="text/javascript">
        $(document).ready(function() {
            $(".basic-select2").select2({
                width: '100%'
            });
            $(":input").inputmask();
            // bootstrap WYSIHTML5 - text editor
            $('.description').wysihtml5();
            $('.datepicker').datepicker({
                autoclose: true,
                format: 'yyyy/mm/dd',
                weekStart: 1
            });
        });
    </script>
@endsection
