@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.heritage.resources.management') . ' | ' . trans('labels.backend.heritage.resources.edit'))

@section('after-styles')
    {{ Html::style("css/backend/plugin/chosen/chosen.min.css") }}
    {{ Html::style("css/backend/plugin/jquery-file-upload/jquery.fileupload.css") }}
    {{ Html::style("css/backend/plugin/jquery-file-upload/jquery.fileupload-ui.css") }}
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
    {{ Form::model($resource, ['route' => ['admin.heritage.components.update', $resource->getid(), $production->getId(), $component->getId()], 'id' => 'main-form', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PUT']) }}

        <div class="box box-success">
            <div class="box-header with-border">
                <h4 class="panel-title">{{ trans('labels.backend.heritage.resources.structure') }}</h4>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="col-lg-12">
                    <h3>{{ trans('labels.backend.heritage.resources.components') }} &raquo; <u>{{ trans('strings.backend.component.' . $component_type) }}</u></h3>
                </div>
    @foreach($architectural_element_map[$component_type] as $set => $options)
                <div class="set-body row">
                    <div class="col-lg-12 col-xs-12">
                        <div class="form-group">
                            {{ Form::label($component_type . '_' . $set, trans('labels.backend.heritage.component.' . $component_type . '.' . $set), ['class' => 'col-lg-2 control-label']) }}

                            <div class="col-lg-8 selects elements">
        @if(in_array('single', $options))
            @foreach($architectural_elements[$component_type][$set] as $key => $value)
                @php
                    $checked = [];
                    if(isset($existing_architectural_elements[$component_type][$set])) {
                        $checked = ($existing_architectural_elements[$component_type][$set][0] == $key ? ['checked'] : []);
                    }
                @endphp
                                {{ Form::radio($set, $key, null, array_merge($checked, [])) }} {{ $value }}&nbsp;
            @endforeach
        @elseif(in_array('multiple', $options))
            @php
                $value = [];
                if (isset($existing_architectural_elements[$component_type]) && array_key_exists($set, $existing_architectural_elements[$component_type])) {
                    $value = $existing_architectural_elements[$component_type][$set];
                }
                $mods  = (in_array('mods', $options)) ? ' mods' : '';
            @endphp
                                {{ Form::select($set.'[]', $architectural_elements[$component_type][$set], $value, ['multiple', 'class' => 'col-lg-2 form-control basic-select2' . $mods]) }}
        @else
                                {{ Form::select($set, $architectural_elements[$component_type][$set], $value, ['class' => 'col-lg-2 form-control basic-select2']) }}
        @endif
                            </div>
                            <div class="col-lg-offset-4 col-lg-6 col-xs-12 displays">
        @if(in_array('mods', $options))
            @if(isset($existing_architectural_elements[$component_type][$set]))
                @foreach($existing_architectural_elements[$component_type][$set] as $uuid)
                                <div class="row" data-identifier="{{ $uuid }}">
                                    <div class="col-lg-6 col-xs-12">
                                        <span class="track"><i class="fa fa-check-square-o"></i>&nbsp;{{ $architectural_elements[$component_type][$set][$uuid] }}</span>
                                    </div>
                                    <div class="col-lg-6 col-xs-12">
                                        <span class="track">{{ Form::radio($set.'_modified['.$uuid.']', 'other', isset($modified_elements[$uuid]) ? ($modified_elements[$uuid] == 'other') : null, []) }} {{ trans('strings.backend.component.other') }}&nbsp;&nbsp;
                                            {{ Form::radio($set.'_modified['.$uuid.']', 'unmodified', isset($modified_elements[$uuid]) ? ($modified_elements[$uuid] == 'unmodified') : null, []) }} {{ trans('strings.backend.component.unmodified') }}&nbsp;&nbsp;
                                            {{ Form::radio($set.'_modified['.$uuid.']', 'modified', isset($modified_elements[$uuid]) ? ($modified_elements[$uuid] == 'modified') : null, []) }} {{ trans('strings.backend.component.modified') }}</span>
                                    </div>
                                    <div class="col-lg-12 col-xs-12">
                                        {{ Form::textarea($set.'_note['.$uuid.']', isset($element_notes[$uuid]) ? $element_notes[$uuid] : '', ["rows" => "2", "cols" => null, "class" => "form-control description"]) }}
                                    </div>
                                </div>
                @endforeach
            @endif
        @endif
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
                            <div class="col-lg-8 selects modifications">
                                {{ Form::select('modification_type[]', $modification_types, $component->getModificationsTypeIds(), ['multiple', 'class' => 'col-lg-4 form-control basic-select2']) }}
                            </div>
                            <div class="col-lg-offset-4 col-lg-6 col-xs-12 displays">
@foreach($component->getModifications() as $modification)
                                <div class="row" data-identifier="{{ $modification->getModificationEvent()->getModificationType()->getId() }}">
                                    <div class="col-lg-12 col-xs-12">
                                        <span class="track"><i class="fa fa-check-square-o"></i>&nbsp;{{ $modification->getModificationEvent()->getModificationType()->getNameRo() }}</span>
                                    </div>
                                    <div class="col-lg-12 col-xs-12">
                                        <span class="track">
                                            {{ Form::textarea('modification_type_description['.$modification->getModificationEvent()->getModificationType()->getId().']', $modification->getModificationEvent()->getModificationDescription()->getNote() ?: '', ["rows" => "2", "cols" => null, "class" => "form-control description"]) }}
                                        </span>
                                    </div>
                                </div>
@endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-offset-2 col-lg-10"><hr/></div>
                    <div class="col-lg-2"></div>
                </div>
                <div class="set-body row">
                    <div class="col-lg-12 col-xs-12">
                        <div class="form-group">
                            {{ Form::label('notes', trans('labels.backend.heritage.component.pages.observations'), ['class' => 'col-lg-2 control-label']) }}

                            <div class="col-lg-8">
                                {{ Form::textarea('notes', $component->getNote(), ["class" => "form-control description"]) }}
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
                    <div class="col-lg-12 col-xs-12">
                        <h4>Photos</h4>
                    </div>
                </div>
                <div class="row">
    @foreach($photos as $id => $photo)
        <div class="col-lg-4 col-md-6 col-xs-12 existingimage">
            <img src="{{ $photo }}" class="img-responsive" /><br />
            <span class="btn btn-danger delete" data-image="{{ $id }}"></span>
        </div>
    @endforeach
                </div>
                <div class="row">
                    <div class="col-lg-12 col-xs-12">
                        <h4>Upload new photos</h4>
                    </div>
                </div>
                <form id="fileupload" action="/admin/heritage/component/{{ $component->getId() }}/upload" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-6 col-xs-6 fileupload-buttonbar">
                            <span class="btn btn-success fileinput-button">
                                <span>Add files...</span>
                                <input type="file" name="photos[]" multiple>
                            </span>
                            <!--/ Extra file input stop -->
                            <button type="submit" class="btn btn-primary start">Start upload</button>
                            <button type="reset" class="btn btn-info cancel">Cancel upload</button>
                            <button type="button" class="btn btn-danger delete">Delete selected</button>
                            <input type="checkbox" class="toggle">
                        </div>
                        <div class="col-lg-6 col-xs-6" id="progress">
                            <div class="progressbar fileupload-progressbar"><div style="width:0%;"></div></div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12 col-xs-12">
                            <table class="table table-striped"><tbody class="files"></tbody></table>
                        </div>
                    </div>
                </form>
            </div><!-- /.box-body -->
        </div><!--box-->

        <div class="box box-success">
            <div class="box-body">
                <div class="pull-left">
                    {{ link_to_route('admin.heritage.components.index', trans('buttons.general.cancel'), [$resource->getid(), $production->getId()], ['class' => 'btn btn-danger btn-xs']) }}
                </div><!--pull-left-->

                <div class="pull-right">
                    {{ Form::submit(trans('buttons.general.crud.update'), ['id' => 'main-submit', 'class' => 'btn btn-success btn-xs']) }}
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
    {{ Html::script('js/backend/plugin/jquery-file-upload/vendor/tmpl.min.js') }}
    {{ Html::script('js/backend/plugin/jquery-file-upload/vendor/load-image.all.min.js') }}
    {{ Html::script('js/backend/plugin/jquery-file-upload/vendor/canvas-to-blob.min.js') }}
    {{--{{ Html::script('js/backend/plugin/jquery-file-upload/vendor/jquery.blueimp-gallery.min.js') }}--}}
    {{ Html::script('js/backend/plugin/jquery-file-upload/jquery.iframe-transport.js') }}
    {{ Html::script('js/backend/plugin/jquery-file-upload/jquery.fileupload.js') }}
    {{ Html::script('js/backend/plugin/jquery-file-upload/jquery.fileupload-process.js') }}
    {{ Html::script('js/backend/plugin/jquery-file-upload/jquery.fileupload-image.js') }}
    {{ Html::script('js/backend/plugin/jquery-file-upload/jquery.fileupload-validate.js') }}
    {{ Html::script('js/backend/plugin/jquery-file-upload/jquery.fileupload-ui.js') }}


    <script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
    </script>
    <script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
    </script>

    <script type="text/javascript">
    $(document).ready(function() {
        $(".basic-select2").chosen().on('change', function(evt, params) {
            if ('selected' in params) {
                var displays = $(this).parent('.selects').next();
                var source = $('option[value='+params.selected+']');
                var label = source.text();
                var name = source.parent().attr('name').replace(/\[\]$/,'');

                // add new
                if ($(this).parent().hasClass('elements')) {
                    console.log($(this).parent());
                    modified = name + '_modified';
                    note = name = '_note';
                    $('<div class="row">').attr(
                        'data-identifier', params.selected
                    ).append(
                        $('<div class="col-lg-6 col-xs-12">').append(
                            $('<span>').addClass('track').append(
                                $('<i class="fa fa-check-square-o"></i>&nbsp;')
                            ).append('&nbsp;' + label)
                        )
                    ).append(
                        $('<div class="col-lg-6 col-xs-12">').append(
                            $('<span>').addClass('track').append(
                                $('<input checked>').attr('name', modified+'['+params.selected+']').attr('type', 'radio').val('other')
                            ).append(
                                ' {{ trans('strings.backend.component.other') }}&nbsp;&nbsp;'
                            ).append(
                                $('<input>').attr('name', modified+'['+params.selected+']').attr('type', 'radio').val('unmodified')
                            ).append(
                                ' {{ trans('strings.backend.component.unmodified') }}&nbsp;&nbsp;'
                            ).append(
                                $('<input>').attr('name', modified+'['+params.selected+']').attr('type', 'radio').val('modified')
                            ).append(
                                ' {{ trans('strings.backend.component.modified') }}'
                            )
                        )
                    ).append(
                        $('<div class="col-lg-12 col-xs-12">').append(
                            $('<textarea class="form-control description">').attr('name', note+'['+params.selected+']')
                        )
                    ).appendTo(displays);
                } else if($(this).parent().hasClass('modifications')) {
                    description = name + '_description';
                    $('<div class="row">').attr(
                        'data-identifier', params.selected
                    ).append(
                        $('<div class="col-lg-12 col-xs-12">').append(
                            $('<span>').addClass('track').append(
                                $('<i class="fa fa-check-square-o"></i>&nbsp;')
                            ).append('&nbsp;' + label)
                        )
                    ).append(
                        $('<div class="col-lg-12 col-xs-12">').append(
                            $('<span>').addClass('track').append(
                                $('<textarea class="form-control description">').attr('name', description+'['+params.selected+']').attr('type', 'text').addClass('input-md full-width')
                            )
                        )
                    ).appendTo(displays);
                }
            }
            if ('deselected' in params) {
                $("[data-identifier='" + params.deselected + "']").remove();
            }
        });

        // http://laraveldaily.com/laravel-ajax-file-upload-blueimp-jquery-library/
        $('<button/>')
            .addClass('btn btn-primary')
            .prop('disabled', true)
            .text('Processing...')
            .on('click', function () {
                var $this = $(this),
                    data = $this.data();
                $this
                    .off('click')
                    .text('Abort')
                    .on('click', function () {
                        $this.remove();
                        data.abort();
                    });
                data.submit().always(function () {
                    $this.remove();
                });
            });
        $('#fileupload').fileupload({
            dataType: 'json',
            autoUpload: false,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent),
            previewMaxWidth: 200,
            previewMaxHeight: 150,
            previewCrop: true
        }).on('fileuploadprogressall', function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }).on('fileuploaddone', function (e, data) {
            $.each(data.result.files, function (index, file) {
                if (file.url) {
                    var link = $('<a>')
                        .attr('target', '_blank')
                        .prop('href', file.url);
                    $(data.context.children()[index])
                        .wrap(link);
                } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
                    $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
                }
            });
        }).on('fileuploadfail', function (e, data) {
            $.each(data.files, function (index) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            });
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');

        $("#main-submit").click(function () {
            $("#main-form").submit();
        });
    });
    </script>
@endsection
