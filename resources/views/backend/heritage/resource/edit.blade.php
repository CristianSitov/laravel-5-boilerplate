@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.heritage.resources.management') . ' | ' . trans('labels.backend.heritage.resources.edit'))

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

                <div class="form-group">
                    {{ Form::label('building_name', trans('validation.attributes.backend.heritage.resources.name'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-5">
                        {{ Form::text('building_name', $resource->getCurrentName() != null ? $resource->getCurrentName()->getName() : '', ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.heritage.resources.name')]) }}
                    </div><!--col-lg-10-->
                    <div class="col-lg-2">
                        {{ Form::text('date_from', '', ['class' => 'form-control', 'data-inputmask' => '"alias": "date"', 'data-mask', 'placeholder' => 'dd/mm/yyyy']) }}
                    </div>
                    <div class="col-lg-2">
                        {{ Form::text('date_to', date("d/m/Y"), ['class' => 'form-control', 'data-inputmask' => '"alias": "date"', 'data-mask', 'placeholder' => 'dd/mm/yyyy']) }}
                    </div>
                    <div class="col-lg-1">+
                    </div>
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('type', trans('validation.attributes.backend.heritage.resources.type'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-2">
                        {{ Form::select('type', $resource_type_classifications, $resource->getResourceTypeClassification()->getId(), ['required' => 'required', 'class' => 'col-lg-2 control-label js-example-basic-single']) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('description', trans('validation.attributes.backend.heritage.resources.description'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::textarea('description', $resource->getDescription()->getNote(), ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.heritage.resources.description'), 'required' => 'required']) }}
                    </div><!--col-lg-10-->
                </div>

            </div><!-- /.box-body -->
        </div><!--box-->

        <div class="box box-success">
            <div class="box-header with-border">
                <h4 class="panel-title">{{ trans('labels.backend.heritage.resources.location') }}</h4>

                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->
            <div class="box-body">

                <div class="form-group">
                    {{ Form::label('district', trans('validation.attributes.backend.heritage.resources.address'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-3">
                        {{ Form::select('district', $administrative_subdivision, $resource->getPlace()->getAdministrativeSubdivision() ? $resource->getPlace()->getAdministrativeSubdivision()->getId() : '', ['required' => 'required', 'class' => 'col-lg-2 control-label js-example-basic-single']) }}
                    </div><!--col-lg-10-->
                    <div class="col-lg-5">
                        {{ Form::select('street', $street_names, $resource->getPlace()->getPlaceAddress() ? $resource->getPlace()->getPlaceAddress()->getStreetName()->getId() : '', ['required' => 'required', 'class' => 'col-lg-2 control-label street-name']) }}
                    </div>
                    <div class="col-lg-2">
                        {{ Form::text('number', $resource->getPlace()->getPlaceAddress()->getNumber(), ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.heritage.resources.number')]) }}
                    </div>
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
    @endif

    {{ Form::close() }}
@endsection

@section('after-scripts')
    <!-- Bootstrap WYSIHTML5 -->
    {{ Html::script('js/backend/plugin/duplicate/duplicate-fields.min.js') }}

    <script type="text/javascript">
    $(document).ready(function() {
        $(".js-example-basic-single").select2({
            width: '100%'
        });
        $(".heritage-resource-type").select2({
            width: '100%'
        });
        $(".street-name").select2({
            width: '100%'
        });
        $(":input").inputmask();
        $('#additional-field-model').duplicateElement({
            "class_remove": ".remove-this-field",
            "class_create": ".create-new-field"
        });
    });
</script>
@endsection
