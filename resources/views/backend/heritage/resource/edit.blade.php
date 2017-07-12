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
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    {{ trans('labels.backend.heritage.resources.general') }}
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                <div class="form-group">
                                    {{ Form::label('name', trans('validation.attributes.backend.heritage.resources.name'), ['class' => 'col-lg-2 control-label']) }}

                                    <div class="col-lg-5">
                                        {{ Form::text('name', $resource->getName() != null ? $resource->getName()->getName() : '', ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.heritage.resources.name')]) }}
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

                                    <div class="col-lg-10">
                                        {{ Form::select('type', $resource_type_classifications, $resource->getResourceTypeClassification()->getId(), ['required' => 'required', 'class' => 'col-lg-2 control-label js-example-basic-single']) }}
                                    </div><!--col-lg-10-->
                                </div><!--form control-->

                                <div class="form-group">
                                    {{ Form::label('description', trans('validation.attributes.backend.heritage.resources.description'), ['class' => 'col-lg-2 control-label']) }}

                                    <div class="col-lg-10">
                                        {{ Form::textarea('description', $resource->getDescription()->getNote(), ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.heritage.resources.description'), 'required' => 'required']) }}
                                    </div><!--col-lg-10-->
                                </div><!--form control-->
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    {{ trans('labels.backend.heritage.resources.location') }}
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                            <div class="panel-body">
                                <div class="form-group">
                                    {{ Form::label('name', trans('validation.attributes.backend.heritage.resources.name'), ['class' => 'col-lg-2 control-label']) }}

                                    <div class="col-lg-5">
                                        {{ Form::text('name', $resource->getName() != null ? $resource->getName()->getName() : '', ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.heritage.resources.name')]) }}
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
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingThree">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    {{ trans('labels.backend.heritage.resources.structure') }}
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                            <div class="panel-body">
                                Anim
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingThree">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    {{ trans('labels.backend.heritage.resources.components') }}
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                            <div class="panel-body">
                                Anim
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingThree">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    {{ trans('labels.backend.heritage.resources.dimensions') }}
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                            <div class="panel-body">
                                Anim
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingThree">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    {{ trans('labels.backend.heritage.resources.changes') }}
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                            <div class="panel-body">
                                Anim
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingThree">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    {{ trans('labels.backend.heritage.resources.relations') }}
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                            <div class="panel-body">
                                Anim
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingThree">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    {{ trans('labels.backend.heritage.resources.evaluations') }}
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                            <div class="panel-body">
                                Anim
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingThree">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    {{ trans('labels.backend.heritage.resources.legal') }}
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                            <div class="panel-body">
                                Anim
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
