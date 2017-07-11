@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.heritage.resources.management') . ' | ' . trans('labels.backend.heritage.resources.edit'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.heritage.resources.management') }}
        <small>{{ trans('labels.backend.heritage.resources.edit') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::model($resource, ['route' => ['admin.heritage.resource.update', $resource->getid()], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) }}

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.heritage.resources.edit') }}</h3>

                <div class="box-tools pull-right">
                    @include('backend.heritage.includes.header-buttons')
                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="form-group">
                    {{ Form::label('name', trans('validation.attributes.backend.heritage.resources.name'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-5">
                        {{ Form::text('name', $resource->getName() != null ? $resource->getName()->getName() : '', ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.heritage.resources.name')]) }}
                    </div><!--col-lg-10-->
                    <div class="col-lg-2">
                        {{ Form::text('date_from', $resource->getName() != null ? $resource->getName()->getName() : '', ['class' => 'form-control', 'data-inputmask' => '"alias": "date"', 'data-mask', 'placeholder' => 'dd/mm/yyyy']) }}
                    </div>
                    <div class="col-lg-2">
                        {{ Form::text('date_to', $resource->getName() != null ? $resource->getName()->getName() : '', ['class' => 'form-control', 'data-inputmask' => '"alias": "date"', 'data-mask', 'placeholder' => 'dd/mm/yyyy']) }}
                    </div>
                    <div class="col-lg-1">+
                    </div>
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('type', trans('validation.attributes.backend.heritage.resources.type'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::select('type', $resource_type_classifications, $resource->getResourceTypeClassification()->getId(), ['required' => 'required', 'class' => 'js-example-basic-single']) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('description', trans('validation.attributes.backend.heritage.resources.description'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::textarea('description', $resource->getDescription()->getNote(), ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.heritage.resources.description'), 'required' => 'required']) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->
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
