@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.heritage.resources.management') . ' | ' . trans('labels.backend.heritage.resources.edit'))

@section('after-styles')
    {{ Html::style("css/backend/plugin/jquery-ui.min.css") }}
    {{ Html::style("css/backend/plugin/selectize/selectize.bootstrap3.css") }}
    {{ Html::style("css/backend/plugin/selectize/selectize.default.css") }}
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
        {{ link_to_route('admin.heritage.buildings.index', trans('labels.backend.heritage.resources.buildings_list'), $resource->getId()) }}
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
                <div class="col-lg-9 col-lg-offset-2"><h2>{{ trans('labels.backend.heritage.resources.building') }}</h2><br /><br /></div>
                <div class="form-group">
                    {{ Form::label('type', trans('validation.attributes.backend.heritage.buildings.type'), ['class' => 'col-lg-2 col-xs-12 control-label label_name']) }}

                    <div class="col-lg-3 col-xs-12">
                        {{ Form::selectBuildingType('type', $production->getBuilding()->getType(), ['class' => 'input-lg col-lg-4 form-control']) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('order', trans('validation.attributes.backend.heritage.buildings.order'), ['class' => 'col-lg-2 col-xs-12 control-label label_name']) }}

                    <div class="col-lg-3 col-xs-12">
                        <div class="input-group">
                            {{ Form::text('order', $production->getBuilding()->getCardinality(), ['class' => 'input-lg col-lg-4 form-control']) }}
                        </div>
                    </div>
                    <div class="col-lg-5 col-xs-12">
                        {{ Form::label('date_from', trans('validation.attributes.backend.heritage.resources.building_interval'), ['class' => 'col-lg-4 col-xs-12 control-label label_name']) }}

                        <div class="input-group input-daterange">
                            <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_from') }}</span>
                            {{ Form::text('date_from', $data['date_from'] ? $data['date_from']->format('Y') : '', ['class' => 'input-lg form-control input_date_from', 'data-inputmask' => '"alias": "yyyy"', 'data-mask']) }}
                            <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_to') }}</span>
                            {{ Form::text('date_to', $data['date_to'] ? $data['date_to']->format('Y') : '', ['class' => 'input-lg form-control input_date_to', 'data-inputmask' => '"alias": "yyyy"', 'data-mask']) }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('', trans('validation.attributes.backend.heritage.resources.levels'), ['class' => 'col-lg-2 col-xs-12 control-label']) }}

                    <div class="col-lg-6 col-xs-12">
                        {{ Form::selectNumberOfFloors('levels[]', $production->getBuilding()->getLevels(), ['multiple', 'class' => 'input-lg col-lg-4 form-control basic-select2']) }}
                    </div>
                </div>
                <div id="heritage_resource_type" class="form-group has_description">
                    {{ Form::label('heritage_resource_type', trans('validation.attributes.backend.heritage.resources.heritage_resource_type'), ['class' => 'col-lg-2 col-xs-12 control-label']) }}

                    <div class="col-lg-8 col-xs-12">
                        {{ Form::select('heritage_resource_type[]', $heritage_resource_types, $current_types, ['class' => 'input-lg col-lg-10 form-control basic-select2', 'multiple' => 'multiple'], $heritage_resource_types_attr) }}
                    </div>
                    <div class="col-lg-12">&nbsp;</div>
                    <div class="col-lg-offset-2 col-lg-6 col-xs-12 heritage_resource_type_notes">
                        {{ Form::textarea('heritage_resource_type_notes', $current_types_notes, ['class' => 'input-lg form-control description heritage_resource_type_notes']) }}
                    </div>
                </div>
                <div id="architectural_style" class="form-group has_description">
                    {{ Form::label('architectural_style', trans('validation.attributes.backend.heritage.resources.architectural_styles'), ['class' => 'col-lg-2 col-xs-12 control-label']) }}

                    <div class="col-lg-8 col-xs-12">
                        {{ Form::select('architectural_style[]', $architectural_styles, $current_styles, ['class' => 'input-lg col-lg-10 form-control basic-select2', 'multiple' => 'multiple'], $architectural_styles_attr) }}
                    </div>
                    <div class="col-lg-12">&nbsp;</div>
                    <div class="col-lg-offset-2 col-lg-6 col-xs-12 architectural_style_notes">
                        {{ Form::textarea('architectural_style_notes', $current_styles_notes, ['class' => 'input-lg form-control description architectural_style_notes']) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('material', trans('validation.attributes.backend.heritage.resources.materials'), ['class' => 'col-lg-2 col-xs-12 control-label']) }}

                    <div class="col-lg-8 col-xs-12">
                        {{ Form::select('material[]', $materials, $current_materials, ['class' => 'input-lg col-lg-10 form-control basic-select2', 'multiple' => 'multiple']) }}
                    </div>
                    <div class="col-lg-2"></div>
                </div>
                <div class="form-group">
                    {{ Form::label('plot_plan', trans('validation.attributes.backend.heritage.resources.plot_plan'), ['class' => 'col-lg-2 col-xs-12 control-label']) }}

                    <div class="col-lg-7 col-xs-12">
                        {{ Form::selectPlotPlan('plot_plan', $production->getBuilding()->getPlan(), ['class' => 'input-lg col-lg-10 control-label']) }}
                    </div>
                    <div class="col-lg-2"></div>
                </div>

                <div class="form-group types">
@if(count($production->getBuilding()->getModifications()) > 0)
    @foreach($production->getBuilding()->getModifications() as $m => $modification)
                    <div id="types{{ $m+1 }}" class="clonedInput">
                        {{ Form::label('modification_type['.$modification->getId().']', trans('validation.attributes.backend.heritage.resources.modification_type'), ['class' => 'col-lg-2 control-label']) }}

                        <div class="col-lg-10 col-xs-10 duplicable">
                            <div class="col-lg-4">
                                {{ Form::select('modification_type['.$modification->getId().']', $modification_types, $modification->getModificationEvent()->getModificationType()->getId(), ['class' => 'input-lg col-lg-2 form-control']) }}
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group input-daterange">
                                    <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_from') }}</span>
                                    {{ Form::text('modification_type_date_from['.$modification->getId().']', $modification->getModificationEvent()->getDateFrom() ? $modification->getModificationEvent()->getDateFrom()->format('Y') : '', ['class' => 'input-lg form-control input_date_from']) }}
                                    <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_to') }}</span>
                                    {{ Form::text('modification_type_date_to['.$modification->getId().']', $modification->getModificationEvent()->getDateTo() ? $modification->getModificationEvent()->getDateTo()->format('Y') : '', ['class' => 'input-lg form-control input_date_to']) }}
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <button type="button" class="btn btn-primary btn-sm clone">{{ trans('validation.attributes.backend.heritage.resources.add_name_button') }}</button>
                                <button type="button" class="btn btn-danger btn-sm remove">{{ trans('validation.attributes.backend.heritage.resources.delete_name_button') }}</button>
                            </div>
                            <div class="col-lg-7">
                                <br />
                                {{ Form::textarea('modification_type_description['.$modification->getId().']', $modification->getModificationEvent()->getModificationDescription()->getNote(), ['class' => 'input-lg form-control description', 'placeholder' => trans('validation.attributes.backend.heritage.resources.description')]) }}
                            </div>
                        </div>
                    </div>
    @endforeach
@else
                    <div id="types1" class="clonedInput">
                        {{ Form::label('new_modification_type[]', trans('validation.attributes.backend.heritage.resources.modification_type'), ['class' => 'col-lg-2 control-label']) }}

                        <div class="col-lg-10 col-xs-10 duplicable">
                            <div class="col-lg-4">
                                {{ Form::select('new_modification_type[]', $modification_types, null, ['class' => 'input-lg col-lg-2 form-control']) }}
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group input-daterange">
                                    <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_from') }}</span>
                                    {{ Form::text('new_modification_type_date_from[]', '', ['class' => 'input-lg form-control input_date_from']) }}
                                    <span class="input-group-addon">{{ trans('validation.attributes.backend.heritage.resources.date_to') }}</span>
                                    {{ Form::text('new_modification_type_date_to[]', '', ['class' => 'input-lg form-control input_date_to']) }}
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <button type="button" class="btn btn-primary btn-sm clone">{{ trans('validation.attributes.backend.heritage.resources.add_modification') }}</button>
                                <button type="button" class="btn btn-danger btn-sm remove">{{ trans('validation.attributes.backend.heritage.resources.delete_modification') }}</button>
                            </div>
                            <div class="col-lg-7">
                                <br />
                                {{ Form::textarea('new_modification_type_description[]', null, ['class' => 'input-lg form-control description', 'placeholder' => trans('validation.attributes.backend.heritage.resources.modification_description')]) }}
                            </div>
                        </div>
                    </div>
@endif
                </div>
                <div class="form-group">
                    {{ Form::label('condition', trans('labels.backend.heritage.building.condition'), ['class' => 'col-lg-2 control-label']) }}
                    <div class="col-lg-3">
                        {{ Form::selectConditionType('condition', $production->getBuilding()->getCondition() ?: null, ['class' => 'input-lg form-control']) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('condition_notes', trans('labels.backend.heritage.building.condition_note'), ['class' => 'col-lg-2 control-label']) }}
                    <div class="col-lg-7">
                        {{ Form::textarea('condition_notes', $production->getBuilding()->getConditionNotes() ?: '', ['class' => 'input-lg form-control description']) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('notes', trans('validation.attributes.backend.heritage.resources.notes'), ['class' => 'col-lg-2 control-label']) }}
                    <div class="col-lg-7">
                        {{ Form::textarea('notes', $production->getBuilding()->getNotes(), ['class' => 'input-lg form-control description', 'placeholder' => trans('validation.attributes.backend.heritage.resources.notes')]) }}
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
    {{ Html::script('js/backend/plugin/jquery-ui.min.js') }}
    <!-- Chosen -->
    {{ Html::script('js/backend/plugin/selectize/selectize.js') }}
    <!-- Bootstrap Datepicker -->
    {{ Html::script('js/backend/plugin/datepicker/bootstrap-datepicker.min.js') }}

    <script type="text/javascript">
    $(document).ready(function() {
        var describe = JSON.parse('{!! json_encode(array_merge($heritage_resource_types_attr, $architectural_styles_attr)) !!}');
        var desc = {};

        $(".basic-select2").selectize({
            plugins: ['remove_button', 'drag_drop'],
            onInitialize: function () {
                var s = this;
                this.revertSettings.$children.each(function () {
                    $.extend(s.options[this.value], $(this).data());
                });
            },
            onItemAdd: function(evt, $item) {
                var id = $item.parents('.has_description').attr('id');
                var notes = '.'+id+'_notes';

                if ($item.data('value') in describe) {
                    if ($(notes).is(':hidden')) {
                        desc[$item.data('value')] = notes;
                        $(notes).show();
                    }
                }
            },
            onItemRemove: function(value) {
                if (value in desc) {
                    if ($(desc[value]).is(':visible')) {
                        $('div'+desc[value]).hide();
                        delete desc[value];
                    }
                }
            }
        });

        // hide initially
        $('.has_description').each(function (index, value) {
            var description = '.' + $(value).attr('id') + '_notes';
            if ($(value).find(':selected').val() in describe) {
                $(value).find(description).show();
            } else {
                $(value).find(description).hide();
            }
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
            $('#type').parent().parent().nextAll().hide();
        }
        $('#type').change(function () {
            if ('out' == $('#type option:selected').val()) {
                $(this).parent().parent().nextAll().hide();
            } else if ('main' == $('#type option:selected').val()) {
                $(this).parent().parent().nextAll().show();
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
