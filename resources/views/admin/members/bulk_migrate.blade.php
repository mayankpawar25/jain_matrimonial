@extends('admin.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{translate('Bulk Migrate Registered Members')}}</h1>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Migration Status')}}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="alert alert-info">
                                <h4 class="alert-heading">{{ $total_registrations }}</h4>
                                <p>{{ translate('Total Registrations') }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-success">
                                <h4 class="alert-heading">{{ $migrated_registrations }}</h4>
                                <p>{{ translate('Migrated Members') }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-warning">
                                <h4 class="alert-heading">{{ $pending_registrations }}</h4>
                                <p>{{ translate('Pending Migration') }}</p>
                            </div>
                        </div>
                    </div>

                    @if(session('migration_errors'))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach(session('migration_errors') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('migrated_count') || session('updated_count'))
                        <div class="alert alert-success">
                            <p>{{ translate('Migration Results:') }}</p>
                            <ul>
                                <li>{{ translate('New Users Created:') }} {{ session('migrated_count') }}</li>
                                <li>{{ translate('Existing Users Updated:') }} {{ session('updated_count') }}</li>
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('members.process_bulk_migration') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Number of records to migrate') }}</label>
                            <div class="col-md-3">
                                <input type="number" name="limit" class="form-control" value="5" min="1" max="100" required>
                                <small class="form-text text-muted">{{ translate('Recommended batch size: 5-50') }}</small>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary"
                                    onclick="return confirm('{{ translate('Are you sure you want to migrate these members?') }}')">
                                    {{ translate('Start Migration') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection