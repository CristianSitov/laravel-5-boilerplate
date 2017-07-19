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
    {{ Form::model($resource, ['route' => ['admin.heritage.buildings.update', $resource->getid(), $production->getId()], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PUT']) }}

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
                    {{ Form::label('dates[]', trans('validation.attributes.backend.heritage.resources.name'), ['class' => 'col-lg-2 control-label label_name']) }}
                    <div class="col-lg-4">
                        <div class="input-group">
                            <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_from') }}</span>
                            {{ Form::text('date_from', $data['date_from'], ['class' => 'form-control input_date_from datepicker', 'data-inputmask' => '"alias": "yyyy/mm/dd"', 'data-mask']) }}
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="input-group">
                            <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_to') }}</span>
                            {{ Form::text('date_to', $data['date_to'], ['class' => 'form-control input_date_to datepicker', 'data-inputmask' => '"alias": "yyyy/mm/dd"', 'data-mask']) }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('heritage_resource_type', trans('validation.attributes.backend.heritage.resources.heritage_resource_type'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-8">
                        {{ Form::selectOpt($heritage_resource_types, 'heritage_resource_type[]', 'set_ro', 'name_ro', 'id', $current_types, ['required' => 'required', 'class' => 'col-lg-2 control-label', 'multiple' => 'multiple']) }}
                    </div><!--col-lg-9-->
                    <div class="col-lg-2"></div>
                </div>
                <div class="form-group">
                    {{ Form::label('architectural_style', trans('validation.attributes.backend.heritage.resources.architectural_style'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-8">
                        {{ Form::select('architectural_style[]', $architectural_styles, null, ['required' => 'required', 'class' => 'col-lg-2 control-label', 'multiple' => 'multiple']) }}
                    </div><!--col-lg-9-->
                    <div class="col-lg-2"></div>
                </div>
                <div class="form-group">
                    {{ Form::label('plot_plan', trans('validation.attributes.backend.heritage.resources.plot_plan'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-8">
                        {{ Form::select('plot_plan[]', $plot_plan, null, ['required' => 'required', 'class' => 'col-lg-2 control-label']) }}
                    </div><!--col-lg-9-->
                    <div class="col-lg-2"></div>
                </div><!--form control-->
            </div><!-- /.box-body -->
        </div><!--box-->

        <div class="box box-success">
            <div class="box-body">
                <div class="pull-left">
                    {{ link_to_route('admin.heritage.buildings.index', trans('buttons.general.cancel'), [$resource->getid()], ['class' => 'btn btn-danger btn-xs']) }}
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
    <!-- Bootstrap Datepicker -->
    {{ Html::script('js/backend/plugin/datepicker/bootstrap-datepicker.min.js') }}

    <script type="text/javascript">
    $(document).ready(function() {
        $("select").select2({
            width: '100%'
        });
        $('.datepicker').datepicker({
            autoclose: true,
            format: 'yyyy/mm/dd',
            weekStart: 1
        });
    });
</script>
@endsection
