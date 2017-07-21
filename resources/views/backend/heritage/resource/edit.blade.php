@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.heritage.resources.management') . ' | ' . trans('labels.backend.heritage.resources.edit'))

@section('after-styles')
    {{ Html::style("css/backend/plugin/wysihtml5/bootstrap3-wysihtml5.min.css") }}
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

    @if (access()->hasRoles(['Administrator', 1]))
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.heritage.resources.general') }}</h3>

                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->

            <div class="box-body">

                @foreach($resource->getNames() as $k => $name)
                <div id="entry{{ $k+1 }}" class="form-group clonedInput_1">
                    {{ Form::label('name[]', trans('validation.attributes.backend.heritage.resources.name'), ['class' => 'col-lg-2 control-label label_name']) }}

                    <div class="col-lg-5">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <label>Current? &nbsp;&nbsp;</label><input type="radio" name="current_name" class="current_name" value="0" {{ ($name->getCurrent()) ? "checked" : "" }}>
                            </span>
                            {{ Form::text('name['.$name->getId().']', $name->getName(), ['class' => 'form-control input_name', 'placeholder' => trans('validation.attributes.backend.heritage.resources.name')]) }}
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="input-group input-daterange">
                            <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_from') }}</span>
                            {{ Form::text('date_from['.$name->getId().']', $name->getDateFrom() ? $name->getDateFrom()->format('m/d/Y') : '', ['class' => 'form-control input_date_from']) }}
                            <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_to') }}</span>
                            {{ Form::text('date_to['.$name->getId().']',  $name->getDateFrom() ? $name->getDateTo()->format('m/d/Y') : '', ['class' => 'form-control input_date_to']) }}
                        </div>
                    </div>
                </div><!--form control-->
                @endforeach
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

                @foreach($resource->getProtectionTypes() as $i => $protection)
                <div id="entryType{{ $k+1 }}" class="form-group clonedType_1">
                    {{ Form::label('protection_type[]', trans('validation.attributes.backend.heritage.resources.protection_type'), ['class' => 'col-lg-2 control-label label_name']) }}

                    <div class="col-lg-5">
                        <div class="input-group">
                        <span class="input-group-addon">
                            <label>Current? &nbsp;&nbsp;</label><input type="radio" name="current_type" class="current_type" value="0" {{ ($protection->getCurrent()) ? "checked" : "" }}>
                        </span>
                            {{ Form::select('protection_type['.$protection->getId().']', $protection_types, $protection->getType(), ['class' => 'col-lg-4 form-control input_type', 'placeholder' => trans('validation.attributes.backend.heritage.resources.protection_type')]) }}
                        </div>
                    </div><!--col-lg-10-->
                    <div class="col-lg-4">
                        <div class="input-group input-daterange">
                            <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_from') }}</span>
                            {{ Form::text('protection_type_date_from['.$protection->getId().']', $protection->getDateFrom() ? $protection->getDateFrom()->format('m/d/Y') : '', ['class' => 'form-control input_type_date_from']) }}
                            <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_to') }}</span>
                            {{ Form::text('protection_type_date_to['.$protection->getId().']', $protection->getDateTo() ? $protection->getDateTo()->format('m/d/Y') : '', ['class' => 'form-control input_type_date_to']) }}
                        </div>
                    </div>
                </div><!--form control-->
                @endforeach
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

        <div class="box box-success">
            <div class="box-body">
                <div class="pull-left">
                    {{ link_to_route('admin.access.user.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-xs']) }}
                </div><!--pull-left-->

                <div class="pull-right">
                    {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-success btn-xs']) }}
                </div><!--pull-right-->

                <div class="clearfix"></div>
            </div><!-- /.box-body -->
        </div><!--box-->
    @endif

    {{ Form::close() }}
@endsection

@section('after-scripts')
    <!-- iCheck -->
    {{ Html::script('js/backend/heritage/script-edit.js') }}
    <!-- Bootstrap Datepicker -->
    {{ Html::script('js/backend/plugin/datepicker/bootstrap-datepicker.min.js') }}
    <!-- Bootstrap WYSIHTML5 -->
    {{ Html::script('js/backend/plugin/wysihtml5/bootstrap3-wysihtml5.all.min.js') }}

    <script type="text/javascript">
    $(document).ready(function() {
        $(".basic-select2").select2({
            width: '100%'
        });
//        $('.description').wysihtml5();
        $('.input-daterange').datepicker({
            autoclose: true,
            clearBtn: true,
            format: 'mm/dd/yyyy',
            weekStart: 1
        });
//        $('.input-daterange input').each(function() {
//            $(this).datepicker('clearDates');
//        });
    });
</script>
@endsection
