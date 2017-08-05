@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.heritage.resources.management') . ' | ' . trans('labels.backend.heritage.resources.edit'))

@section('after-styles')
    {{ Html::style("css/backend/plugin/chosen/chosen.min.css") }}
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
    {{ Form::model($resource, ['route' => ['admin.heritage.components.update', $resource->getid(), $production->getId(), $component->getId()], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PUT']) }}

        <div class="box box-success">
            <div class="box-header with-border">
                <h4 class="panel-title">{{ trans('labels.backend.heritage.resources.structure') }}</h4>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="col-lg-12">
                    <h3>{{ trans('labels.backend.heritage.resources.components') }}</h3>
                </div>
                <div class="set-title row">
                    <div class="col-lg-2">
                        <h4 class="text-primary"><u>{{ trans('strings.backend.component.' . $component_type) }}</u></h4>
                    </div><div class="col-lg-10"></div>
                </div>
    @foreach($architectural_element_map[$component_type] as $set => $options)
                <div class="set-body row">
                    <div class="col-lg-12 col-xs-12">
                        <div class="form-group">
                            {{ Form::label($component_type . '_' . $set, trans('labels.backend.heritage.component.' . $component_type . '.' . $set), ['class' => 'col-lg-2 control-label']) }}

                            <div class="col-lg-4 selects">
        @if(in_array('single', $options))
            @foreach($architectural_elements[$component_type][$set] as $key => $value)
                @php
                    $checked = [];
                    if(isset($existing_architectural_elements[$component_type][$set])) {
                        $checked = ($existing_architectural_elements[$component_type][$set][0] == $key ? ['checked'] : []);
                    }
                @endphp
                                {{ Form::radio($set, $key, null, array_merge($checked, [])) }} {{ $value }}<br />
            @endforeach
        @elseif(in_array('multiple', $options))
            @php
                $value = (array_key_exists($set, $existing_architectural_elements[$component_type])) ? $existing_architectural_elements[$component_type][$set] : [];
                $mods  = (in_array('mods', $options)) ? ' mods' : '';
            @endphp
                                {{ Form::select($set.'[]', $architectural_elements[$component_type][$set], $value, ['multiple', 'class' => 'col-lg-2 form-control basic-select2' . $mods]) }}
        @else
                                {{ Form::select($set, $architectural_elements[$component_type][$set], $value, ['class' => 'col-lg-2 form-control basic-select2']) }}
        @endif
                            </div>
                            <div class="col-lg-6 displays">
                                <table class="table table-condensed">
                                    <tbody>
        @if(in_array('mods', $options))
            @if(isset($existing_architectural_elements[$component_type][$set]))
                @foreach($existing_architectural_elements[$component_type][$set] as $uuid)
                                        <tr data-identifier="{{ $uuid }}">
                                            <td><span class="track"><i class="fa fa-check-square-o"></i>&nbsp;{{ $architectural_elements[$component_type][$set][$uuid] }}</span></td>
                                            <td>
                                                {{ Form::radio($set.'_modified['.$uuid.']', 'unmodified', isset($modified_elements[$uuid]) ? ($modified_elements[$uuid] == 'unmodified') : null, []) }} {{ trans('strings.backend.component.unmodified') }}<br />
                                                {{ Form::radio($set.'_modified['.$uuid.']', 'modified', isset($modified_elements[$uuid]) ? ($modified_elements[$uuid] == 'modified') : null, []) }} {{ trans('strings.backend.component.modified') }}<br />
                                            </td>
                                        </tr>
                @endforeach
            @endif
        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        @if(in_array('group', $options))
                <div class="row">
                    <div class="col-lg-offset-2 col-lg-10"><hr/></div>
                    <div class="col-lg-2"></div>
                </div>
        @endif
    @endforeach
                <div class="set-body row">
                    <div class="col-lg-12 col-xs-12">
                        <div class="form-group">
                            {{ Form::label($component_type, trans('labels.backend.heritage.component.pages.changes'), ['class' => 'col-lg-2 control-label']) }}
                            <div class="col-lg-4 selects">
                                {{ Form::select('modification_type', $modification_types, [], ['class' => 'col-lg-4 form-control basic-select2']) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xs-6">

                    </div>
                </div>
                <div class="set-body row">
                    <div class="col-lg-12 col-xs-12">
                        <div class="form-group">
                            {{ Form::label($component_type, trans('labels.backend.heritage.component.pages.observations'), ['class' => 'col-lg-2 control-label']) }}

                            <div class="col-lg-4 selects">
                                {{ Form::textarea($component_type) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div><!--box-->

    {{ Form::close() }}


    <div class="box box-success">
        <div class="box-body">
            <div class="row">
                <div class="form-group">
                    {{ Form::label($component_type, trans('labels.backend.heritage.component.pages.images'), ['class' => 'col-lg-2 control-label']) }}
                    <div class="col-lg-4 selects">
                        {{ Form::file('photos[]', ["data-url" => "/admin/heritage/upload", "multiple", "id" => "fileupload"]) }}
                        <div id="files_list"></div>
                        <p id="loading"></p>
                        <input type="hidden" name="file_ids" id="file_ids" value="" />
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
        </div><!-- /.box-body -->
    </div><!--box-->

    <div class="box box-success">
        <div class="box-body">
            <div class="pull-left">
                {{ link_to_route('admin.heritage.components.index', trans('buttons.general.cancel'), [$resource->getid(), $production->getId()], ['class' => 'btn btn-danger btn-xs']) }}
            </div><!--pull-left-->

            <div class="pull-right">
                {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-success btn-xs']) }}
            </div><!--pull-right-->

            <div class="clearfix"></div>
        </div><!-- /.box-body -->
    </div><!--box-->

@endsection

@section('after-scripts')
    <!-- Chosen -->
    {{ Html::script('js/backend/plugin/chosen/chosen.jquery.min.js') }}
    <!-- jQuery File Upload -->
    {{ Html::script('js/backend/plugin/jquery-file-upload/vendor/jquery.ui.widget.js') }}
    {{ Html::script('js/backend/plugin/jquery-file-upload/jquery.iframe-transport.js') }}
    {{ Html::script('js/backend/plugin/jquery-file-upload/jquery.fileupload.js') }}

    <script type="text/javascript">
    $(document).ready(function() {
//        $(".basic-select2").select2({
//            width: '100%'
//        });
        $(".basic-select2").chosen().on('change', function(evt, params) {
            if ('selected' in params) {
                var displays = $(this).parent('.selects').next();
                var source = $('option[value='+params.selected+']');
                var label = source.text();
                var name = source.parent().attr('name').replace(/\[\]$/,'') + '_modified';

                // add new
                    $('<tr/>').attr(
                        'data-identifier', params.selected
                    ).append(
                        $('<td>').append(
                            $('<span>').addClass('track').append(
                                $('<i class="fa fa-check-square-o"></i>&nbsp;')
                            ).append('&nbsp;' + label)
                        )
                    ).append(
                        $('<td>').append(
                            $('<input>').attr('name', name+'['+params.selected+']').attr('type', 'radio').val('unmodified')
                        ).append(
                            ' {{ trans('strings.backend.component.unmodified') }}<br>'
                        ).append(
                            $('<input>').attr('name', name+'['+params.selected+']').attr('type', 'radio').val('modified')
                        ).append(
                            ' {{ trans('strings.backend.component.modified') }}<br>'
                        )
                    )
                    .appendTo(displays.find('table tbody'));
            }
            if ('deselected' in params) {
                // remove existing
                $("[data-identifier='" + params.deselected + "']").remove();
            }
        });

        // http://laraveldaily.com/laravel-ajax-file-upload-blueimp-jquery-library/
        $('#fileupload').fileupload({
            dataType: 'json',
            add: function (e, data) {
                $('#loading').text('Uploading...');
                data.submit();
            },
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $('<p/>').html(file.name + ' (' + file.size + ' KB)').appendTo($('#files_list'));
                    if ($('#file_ids').val() != '') {
                        $('#file_ids').val($('#file_ids').val() + ',');
                    }
                    $('#file_ids').val($('#file_ids').val() + file.fileID);
                });
                $('#loading').text('');
            }
        });
//        $('a#clone_me').on('click', function(){
//            var $clone = jQuery('#toClone select:first').clone();
//            $clone.removeAttr('style');
//            //$clone.chosen('destroy');
//            jQuery('#toClone').append($clone);
//            jQuery('#toClone select:last').chosen();
//        });
    });
    </script>
@endsection
