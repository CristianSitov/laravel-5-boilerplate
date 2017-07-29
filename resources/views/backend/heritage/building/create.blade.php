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
    {{ Form::model($resource, ['route' => ['admin.heritage.buildings.store', $resource->getid()], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'POST']) }}

        <div class="box box-success">
            <div class="box-header with-border">
                <h4 class="panel-title">{{ trans('labels.backend.heritage.resources.structure') }}</h4>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="col-lg-10 col-lg-offset-2"><h3>{{ trans('labels.backend.heritage.resources.building') }}</h3></div>
                <div class="form-group">
                    {{ Form::label('type', trans('validation.attributes.backend.heritage.buildings.type'), ['class' => 'col-lg-2 control-label label_name']) }}
                    <div class="col-lg-8">
                        <div class="input-group">
                            {{ Form::select('type', ['main' => 'Main Building', 'out' => 'Outbuilding'], '', ['class' => 'col-lg-4 form-control']) }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('dates[]', trans('validation.attributes.backend.heritage.resources.building_interval'), ['class' => 'col-lg-2 control-label label_name']) }}
                    <div class="col-lg-4">
                        <div class="input-group input-daterange">
                            <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_from') }}</span>
                            {{ Form::text('date_from', '', ['class' => 'form-control input_date_from datepicker', 'data-inputmask' => '"alias": "yyyy/mm/dd"', 'data-mask']) }}
                            <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_to') }}</span>
                            {{ Form::text('date_to', '', ['class' => 'form-control input_date_to datepicker', 'data-inputmask' => '"alias": "yyyy/mm/dd"', 'data-mask']) }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('heritage_resource_type', trans('validation.attributes.backend.heritage.resources.heritage_resource_type'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-8">
                        {{ Form::selectOpt($heritage_resource_types, 'heritage_resource_type[]', 'set_ro', 'name_ro', 'id', null, ['required' => 'required', 'class' => 'col-lg-2 control-label basic-select2', 'multiple' => 'multiple']) }}
                    </div>
                    <div class="col-lg-2"></div>
                </div>
                <div class="form-group">
                    {{ Form::label('architectural_style', trans('validation.attributes.backend.heritage.resources.architectural_styles'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-8">
                        {{ Form::select('architectural_style[]', $architectural_styles, null, ['required' => 'required', 'class' => 'col-lg-2 control-label basic-select2', 'multiple' => 'multiple']) }}
                    </div>
                    <div class="col-lg-2"></div>
                </div>
                <div class="form-group">
                    {{ Form::label('material', trans('validation.attributes.backend.heritage.resources.materials'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-8">
                        {{ Form::select('material[]', $materials, null, ['required' => 'required', 'class' => 'col-lg-2 control-label basic-select2', 'multiple' => 'multiple']) }}
                    </div>
                    <div class="col-lg-2"></div>
                </div>
                <div class="form-group">
                    {{ Form::label('plot_plan', trans('validation.attributes.backend.heritage.resources.plot_plan'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-8">
                        {{ Form::select('plot_plan', $plot_plan, null, ['required' => 'required', 'class' => 'col-lg-2 control-label basic-select2']) }}
                    </div>
                    <div class="col-lg-2"></div>
                </div>
                <div id="types">

                    <div id="types1" class="clonedInput">
                        <div class="form-group">
                            {{ Form::label('modification_type[]', trans('validation.attributes.backend.heritage.resources.modification_type'), ['class' => 'col-lg-2 control-label']) }}

                            <div class="col-lg-4">
                                {{ Form::select('modification_type[]', $modification_types, null, ['required' => 'required', 'class' => 'col-lg-2 control-label']) }}
                            </div>
                            <div class="col-lg-4">
                                <div class="input-group input-daterange">
                                    <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_from') }}</span>
                                    {{ Form::text('modification_type_date_from[]', '', ['class' => 'form-control input_date_from']) }}
                                    <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_to') }}</span>
                                    {{ Form::text('modification_type_date_to[]', '', ['class' => 'form-control input_date_to']) }}
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <button type="button" class="btn btn-primary btn-sm clone">{{ trans('validation.attributes.backend.heritage.resources.add_name_button') }}</button>
                                <button type="button" class="btn btn-danger btn-sm remove">{{ trans('validation.attributes.backend.heritage.resources.delete_name_button') }}</button>
                            </div>
                            <div class="col-lg-8 col-lg-offset-2">
                                {{ Form::textarea('modification_type_description[]', null, ['class' => 'form-control description', 'placeholder' => trans('validation.attributes.backend.heritage.resources.description'), 'required' => 'required']) }}
                            </div>
                        </div>
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
                    {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-success btn-xs']) }}
                </div><!--pull-right-->

                <div class="clearfix"></div>
            </div><!-- /.box-body -->
        </div><!--box-->

    {{ Form::close() }}
@endsection

@section('after-scripts')
    <!-- Bootstrap Datepicker -->
    {{ Html::script('js/backend/plugin/datepicker/bootstrap-datepicker.min.js') }}

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
