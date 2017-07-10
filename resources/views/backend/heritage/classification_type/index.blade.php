@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.heritage.resources.management'))

@section('after-styles')
    {{ Html::style("css/backend/plugin/datatables/dataTables.bootstrap.min.css") }}
@endsection

@section('page-header')
    <h1>
        {{ trans('labels.backend.heritage.classification.management') }}
        <small>{{ trans('labels.backend.heritage.classification.list') }}</small>
    </h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.heritage.resources.list') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.heritage.includes.header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="resources-table" class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>{{ trans('labels.backend.heritage.classification.table.id') }}</th>
                        <th>{{ trans('labels.backend.heritage.classification.table.type_set') }}</th>
                        <th>{{ trans('labels.backend.heritage.classification.table.type') }}</th>
                        <th>{{ trans('labels.backend.heritage.classification.table.published') }}</th>
                        <th>{{ trans('labels.backend.heritage.classification.table.created') }}</th>
                        <th>{{ trans('labels.backend.heritage.classification.table.updated') }}</th>
                        <th>{{ trans('labels.general.actions') }}</th>
                    </tr>
                    </thead>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('history.backend.recent_history') }}</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box tools -->
        </div><!-- /.box-header -->
        <div class="box-body">
            {!! history()->renderType('Classification') !!}
        </div><!-- /.box-body -->
    </div><!--box box-success-->
@endsection

@section('after-scripts')
    {{ Html::script("js/backend/plugin/datatables/jquery.dataTables.min.js") }}
    {{ Html::script("js/backend/plugin/datatables/dataTables.bootstrap.min.js") }}

    <script>
        $(function() {
            $('#resources-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.heritage.classification-type.get") }}',
                    type: 'post',
                    data: {status: 1, trashed: false}
                },
                columns: [
                    {data: 'id', name: 'classification.id'},
                    {data: 'type_set', name: 'classification.type_set'},
                    {data: 'type', name: 'classification.type'},
                    {data: 'published', name: 'classification.published'},
                    {data: 'created_at', name: 'classification.created_at'},
                    {data: 'updated_at', name: 'classification.updated_at'},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false}
                ],
                order: [[0, "asc"]],
                searchDelay: 500
            });
        });
    </script>
@endsection
