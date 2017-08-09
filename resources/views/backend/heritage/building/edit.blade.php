@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.heritage.resources.management') . ' | ' . trans('labels.backend.heritage.resources.edit'))

@section('after-styles')
    {{ Html::style("css/backend/plugin/datepicker/bootstrap-datepicker.min.css") }}
@endsection

@section('page-header')
    <h4>{{ link_to_route('admin.heritage.resource.index', trans('labels.backend.heritage.resources.list')) }}
        <i class="fa fa-angle-right" aria-hidden="true"></i>
        @if(access()->hasRoles(['Administrator', 1]))
            {{ link_to_route('admin.heritage.resource.edit', $address, $resource->getId()) }}
        @else
            {{ $address }}
        @endif
        <i class="fa fa-angle-right" aria-hidden="true"></i>
        {{ trans('labels.backend.heritage.building.edit') }}
    </h4>
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
                <div class="col-lg-9 col-lg-offset-2"><h3>{{ trans('labels.backend.heritage.resources.building') }}</h3></div>
                <div class="form-group">
                    {{ Form::label('type', trans('validation.attributes.backend.heritage.buildings.type'), ['class' => 'col-lg-2 control-label label_name']) }}

                    <div class="col-lg-3 col-xs-3">
                        {{ Form::selectBuildingType('type', $production->getBuilding()->getType(), ['class' => 'col-lg-4 form-control']) }}
                    </div>

                    {{ Form::label('order', trans('validation.attributes.backend.heritage.buildings.order'), ['class' => 'col-lg-2 control-label label_name']) }}

                    <div class="col-lg-4 col-xs-4">
                        <div class="input-group">
                            {{ Form::text('order', $production->getBuilding()->getCardinality(), ['class' => 'col-lg-4 form-control']) }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-3 col-lg-offset-2">
                        <div class="input-group">
                            <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.levels') }}</span>
                            {{ Form::selectNumberOfFloors('levels', $production->getBuilding()->getLevels(), ['class' => 'col-lg-4 form-control']) }}
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="input-group input-daterange">
                            <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.building_interval') }}</span>
                            <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_from') }}</span>
                            {{ Form::text('date_from', $data['date_from']->format('Y'), ['class' => 'form-control input_date_from', 'data-inputmask' => '"alias": "yyyy"', 'data-mask']) }}
                            <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_to') }}</span>
                            {{ Form::text('date_to', $data['date_to']->format('Y'), ['class' => 'form-control input_date_to', 'data-inputmask' => '"alias": "yyyy"', 'data-mask']) }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('heritage_resource_type', trans('validation.attributes.backend.heritage.resources.heritage_resource_type'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-7">
                        {{ Form::selectOpt($heritage_resource_types, 'heritage_resource_type[]', 'set_ro', 'name_ro', 'id', $current_types, ['required' => 'required', 'class' => 'col-lg-2 control-label basic-select2', 'multiple' => 'multiple']) }}
                    </div>
                    <div class="col-lg-2"></div>
                </div>
                <div class="form-group">
                    {{ Form::label('architectural_style', trans('validation.attributes.backend.heritage.resources.architectural_styles'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-7">
                        {{ Form::select('architectural_style[]', $architectural_styles, $current_styles, ['required' => 'required', 'class' => 'col-lg-2 control-label basic-select2', 'multiple' => 'multiple']) }}
                    </div>
                    <div class="col-lg-2"></div>
                </div>
                <div class="form-group">
                    {{ Form::label('plot_plan', trans('validation.attributes.backend.heritage.resources.plot_plan'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-7">
                        {{ Form::selectPlotPlan('plot_plan', $production->getBuilding()->getPlan(), ['required' => 'required', 'class' => 'col-lg-2 control-label basic-select2']) }}
                    </div>
                    <div class="col-lg-2"></div>
                </div><!--form control-->
                <div class="form-group">
                    {{ Form::label('material', trans('validation.attributes.backend.heritage.resources.materials'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-7">
                        {{ Form::select('material[]', $materials, $current_materials, ['required' => 'required', 'class' => 'col-lg-2 control-label basic-select2', 'multiple' => 'multiple']) }}
                    </div><!--col-lg-9-->
                    <div class="col-lg-2"></div>
                </div>

                <div class="form-group types">
@if(count($production->getBuilding()->getModifications()) > 0)
    @foreach($production->getBuilding()->getModifications() as $m => $modification)
                    <div id="types{{ $m+1 }}" class="clonedInput row">
                        {{ Form::label('modification_type['.$modification->getId().']', trans('validation.attributes.backend.heritage.resources.modification_type'), ['class' => 'col-lg-2 control-label']) }}

                        <div class="col-lg-10 col-xs-10 duplicable">
                            <div class="col-lg-4">
                                {{ Form::select('modification_type['.$modification->getId().']', $modification_types, $modification->getModificationEvent()->getModificationType()->getId(), ['required' => 'required', 'class' => 'col-lg-2 form-control']) }}
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group input-daterange">
                                    <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_from') }}</span>
                                    {{ Form::text('modification_type_date_from['.$modification->getId().']', $modification->getModificationEvent()->getDateFrom() ? $modification->getModificationEvent()->getDateFrom()->format('Y') : '', ['class' => 'form-control input_date_from']) }}
                                    <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_to') }}</span>
                                    {{ Form::text('modification_type_date_to['.$modification->getId().']', $modification->getModificationEvent()->getDateTo() ? $modification->getModificationEvent()->getDateTo()->format('Y') : '', ['class' => 'form-control input_date_to']) }}
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <button type="button" class="btn btn-primary btn-sm clone">{{ trans('validation.attributes.backend.heritage.resources.add_name_button') }}</button>
                                <button type="button" class="btn btn-danger btn-sm remove">{{ trans('validation.attributes.backend.heritage.resources.delete_name_button') }}</button>
                            </div>
                            <div class="col-lg-7">
                                <br />
                                {{ Form::textarea('modification_type_description['.$modification->getId().']', $modification->getModificationEvent()->getModificationDescription()->getNote(), ['class' => 'form-control description', 'placeholder' => trans('validation.attributes.backend.heritage.resources.description'), 'required' => 'required']) }}
                            </div>
                        </div>
                    </div>
    @endforeach
@else
                    <div id="types1" class="clonedInput">
                        {{ Form::label('new_modification_type[]', trans('validation.attributes.backend.heritage.resources.modification_type'), ['class' => 'col-lg-2 control-label']) }}

                        <div class="col-lg-10 col-xs-10 duplicable">
                            <div class="col-lg-4">
                                {{ Form::select('new_modification_type[]', $modification_types, null, ['required' => 'required', 'class' => 'col-lg-2 form-control']) }}
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group input-daterange">
                                    <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_from') }}</span>
                                    {{ Form::text('new_modification_type_date_from[]', '', ['class' => 'form-control input_date_from']) }}
                                    <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_to') }}</span>
                                    {{ Form::text('new_modification_type_date_to[]', '', ['class' => 'form-control input_date_to']) }}
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <button type="button" class="btn btn-primary btn-sm clone">{{ trans('validation.attributes.backend.heritage.resources.add_modification') }}</button>
                                <button type="button" class="btn btn-danger btn-sm remove">{{ trans('validation.attributes.backend.heritage.resources.delete_modification') }}</button>
                            </div>
                            <div class="col-lg-7">
                                <br />
                                {{ Form::textarea('new_modification_type_description[]', null, ['class' => 'form-control description', 'placeholder' => trans('validation.attributes.backend.heritage.resources.modification_description')]) }}
                            </div>
                        </div>
                    </div>
@endif
                </div>
                <div class="form-group">
                    {{ Form::label('notes', trans('validation.attributes.backend.heritage.resources.notes'), ['class' => 'col-lg-2 control-label']) }}
                    <div class="col-lg-7">
                        {{ Form::textarea('notes', $production->getBuilding()->getNotes(), ['class' => 'form-control description', 'placeholder' => trans('validation.attributes.backend.heritage.resources.notes')]) }}
                    </div>
                </div>
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

        if ('out' == $('#type option:selected').val()) {
            $('#type').parent().parent().siblings().hide();
        }
        $('#type').change(function () {
            if ('out' == $('#type option:selected').val()) {
                $(this).parent().parent().siblings().hide();
            } else if ('main' == $('#type option:selected').val()) {
                $(this).parent().parent().siblings().show();
            }
        });

        // http://jsfiddle.net/mjaric/tfFLt/
        var regex = /(^[^\[]+)(?=\[)|(([^\[\]]+)(?=\]))/g;

        var clone = function () {
            var parent = $(this).parents(".clonedInput").parent().attr('class');
            var cloneIndex = $(".clonedInput").length;
            var thisId = cloneIndex - 1;
            var clonable = $(this).parents('#' + parent + thisId);

            clonable.clone()
                .appendTo($(this).parents(".clonedInput").parent())
                .attr("id", source + Number(cloneIndex + 1))
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

            $('.input-daterange').datepicker(dateOptions);
        };
        var remove = function () {
            if ($(this).parents(".clonedInput").parent().find('.clonedInput').length > 1) {
                $(this).parents(".clonedInput").remove();
            }
        }
        $("button.clone").on("click", clone);
        $("button.remove").on("click", remove);
    });
</script>
@endsection
