@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.heritage.resources.management') . ' | ' . trans('labels.backend.heritage.resources.create'))

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
                    @include('backend.heritage.includes.header-buttons')
                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="form-group">
                    {{ Form::label('building_name', trans('validation.attributes.backend.heritage.resources.name'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-5">
                        {{ Form::text('building_name', '', ['class' => 'form-control', 'required', 'placeholder' => trans('validation.attributes.backend.heritage.resources.name')]) }}
                    </div><!--col-lg-10-->
                    <div class="col-lg-2">
                        {{ Form::text('date_from', '', ['class' => 'form-control', 'data-inputmask' => '"alias": "date"', 'data-mask', 'placeholder' => 'dd/mm/yyyy']) }}
                    </div>
                    <div class="col-lg-2">
                        {{ Form::text('date_to', date("d/m/Y"), ['class' => 'form-control', 'required', 'data-inputmask' => '"alias": "date"', 'data-mask', 'placeholder' => 'dd/mm/yyyy']) }}
                    </div>
                    <div class="col-lg-1">+
                    </div>
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('type', trans('validation.attributes.backend.heritage.resources.type'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::select('type', $resource_type_classifications, null, ['required' => 'required', 'class' => 'col-lg-2 control-label js-example-basic-single']) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('Description', trans('validation.attributes.backend.heritage.resources.description'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.heritage.resources.description'), 'required' => 'required']) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->
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
    <script type="text/javascript">
        $(document).ready(function() {
            $(".js-example-basic-single").select2();
            $(":input").inputmask();
        });
    </script>
@endsection
