<x-admin-app-layout>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-8">
                        <h1>Administrators</h1>
                    </div>
                    <div class="col-sm-4 text-right">
                        <a href="{{ url('admin/administrator/create') }}" class="btn btn-primary btn-md">Create</a>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>


        <!-- Main content -->
        <section class="content">

            <div class="container-fluid">
                @if (@session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                    @endsession
                    <div class="row">

                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Administrator</h3>

                                    <div class="card-tools">
                                        <div class="input-group input-group-sm" style="width: 150px;">
                                            <input type="text" name="table_search" class="form-control float-right"
                                                placeholder="Search">

                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Roles</th>
                                                <th>Created At</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($administrators as $record)
                                                <tr>
                                                    <td>{{ $record->id }}</td>
                                                    <td>{{ $record->name }}</td>
                                                    <td>{{ $record->email }}</td>
                                                    <td>
                                                        @if (!empty($record->getRoleNames()))
                                                            @foreach ($record->getRoleNames() as $roleName)
                                                                <label
                                                                    class="badge badge-warning badge-sm">{{ $roleName }}</label>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>{{ date('Y-m-d', strtotime($record->created_at)) }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.administrator.edit', $record->id) }}"
                                                            class="btn btn-primary btn-sm">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                        <a href="{{ url('admin/administrator/' . $record->id . '/delete') }}"
                                                            class="btn btn-danger btn-sm">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</x-admin-app-layout>
