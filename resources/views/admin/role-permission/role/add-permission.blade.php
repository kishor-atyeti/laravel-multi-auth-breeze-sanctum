<x-admin-app-layout>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-8">
                        <h1>Role: {{ $role->name }}</h1>
                    </div>
                    <div class="col-sm-4 text-right">

                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        @if (session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Role: {{ $role->name }}</h3>

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
                            <div class="card-body">
                                <form action="{{ url('admin/roles/' . $role->id . '/give-permission') }}"
                                    method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        @foreach ($permissions as $record)
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input type="checkbox" name="permission[]"
                                                        value="{{ $record->name }}" id="permission-{{ $record->id }}" {{in_array($record->id, $rolePermissions) ? 'checked': '' }}>
                                                    <label
                                                        for="permission-{{ $record->id }}">{{ $record->name }}</label>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-success btn-md">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-body -->
                            @error('permission')
                                <div class="card-footer">
                                    <span class="text-danger">{{ $message }}</span>
                                </div>
                            @enderror
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
