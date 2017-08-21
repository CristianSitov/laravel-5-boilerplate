@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.heritage.actors.management'))

@section('after-styles')
    {{ Html::style("css/backend/plugin/datatables/dataTables.bootstrap.min.css") }}
@endsection

@section('page-header')
    <h1>
        {{ trans('labels.backend.heritage.actors.management') }}
        <small>{{ trans('labels.backend.heritage.actors.list') }}</small>
    </h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.heritage.actors.list') }}</h3>

            <div class="box-tools pull-right">
                {{--@include('backend.heritage.includes.header-buttons')--}}
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body table-responsive">
            <table id="actors-table" class="table table-condensed table-hover">
                <thead>
                <tr>
                    <th>{{ trans('labels.backend.heritage.resources.table.name') }}</th>
                    <th>{{ trans('labels.backend.heritage.resources.table.address') }}</th>
                    {{--<th>{{ trans('labels.general.actions') }}</th>--}}
                </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="box box-info collapsed-box">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('history.backend.recent_history') }}</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box tools -->
        </div><!-- /.box-header -->
        <div class="box-body">
            {{--{!! history()->renderType('Resource') !!}--}}
        </div><!-- /.box-body -->
    </div><!--box box-success-->
@endsection

@section('after-scripts')
    {{ Html::script("js/backend/plugin/datatables/jquery.dataTables.min.js") }}
    {{ Html::script("js/backend/plugin/datatables/dataTables.bootstrap.min.js") }}

    <script>
        $(function() {
            $('#actors-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.heritage.actors.table.get", $resource->getId()) }}',
                    type: 'post',
                    data: {}
                },
                columns: [
                    {data: 'address', name: 'address'},
                    {data: 'name', name: 'name', render: function (data, type, row) {
                        return data + '<br> <small class="text-muted">c: '+row.created_at+'<br>u: '+row.updated_at+'</small>';
                    }},
//                    {data: 'actions', name: 'actions', searchable: false, sortable: false}
                ],
                order: [[0, "asc"]],
                stateSave: true,
                searchDelay: 500
            });
        });
    </script>
@endsection
