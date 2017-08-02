@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.heritage.resources.management') . ' | ' . trans('labels.backend.heritage.resources.edit'))

@section('after-styles')

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
@php $currGroup = false; @endphp
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

                            <div class="col-lg-6">
        @if(in_array('single', $options))
            @foreach($architectural_elements[$component_type][$set] as $key => $value)
                                {{ Form::radio($set, $key, null, []) }} {{ $value }}<br />
            @endforeach
        @elseif(in_array('multiple', $options))
            @php
                $value = (array_key_exists($component_type, $existing_architectural_elements)) ? $existing_architectural_elements[$component_type][$set] : [];
            @endphp
                                {{ Form::select($set.'[]', $architectural_elements[$component_type][$set], $value, ['multiple', 'class' => 'col-lg-2 form-control basic-select2']) }}
        @else
                                {{ Form::select($set, $architectural_elements[$component_type][$set], $value, ['class' => 'col-lg-2 form-control basic-select2']) }}
        @endif
                            </div>
                            <div class="col-lg-4">
        @if(in_array('mods', $options))
                                {{ Form::radio($set.'_mods', 'unmodified', null, []) }} {{ trans('strings.backend.component.unmodified') }}<br />
                                {{ Form::radio($set.'_mods', 'modified', null, []) }} {{ trans('strings.backend.component.modified') }}<br />
        @endif
                            </div>
                        </div>
                    </div>
                </div>
        @if(in_array('group', $options))
                <div class="row">
                    <div class="col-lg-offset-2 col-lg-8"><hr/></div>
                    <div class="col-lg-2"></div>
                </div>
        @endif
    @endforeach
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

    {{ Form::close() }}
@endsection

@section('after-scripts')
    <!-- Bootstrap Datepicker -->

    <script type="text/javascript">
    $(document).ready(function() {
        $(".basic-select2").select2({
            width: '100%'
        });
    });
    </script>
@endsection
