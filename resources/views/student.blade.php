@extends('layouts.sidebar')

@section('title', 'Students List')

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card" style="border: none; border-radius: 15px; overflow: hidden; box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);">

    <div class="card-header" style="background: #0f172a; color: #fff; padding: 20px 25px;">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <h3 style="margin: 0; font-weight: 600;">Students List</h3>

            <div class="d-flex gap-2 align-items-center">
                <div class="d-flex">
                    <form action="{{ route('students.index') }}" method="GET" class="d-flex m-0">
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search students..." class="form-control" style="border-radius: 8px 0 0 8px; padding: 8px 12px; border: 1px solid #374151; color: #6c6f72; min-width: 200px; height: 38px;">
                        <button type="submit" class="btn btn-primary" style="border-radius: 0 8px 8px 0; padding: 8px 16px; background: #4f46e5; border: none; color: white; height: 38px;">
                            🔍
                        </button>
                    </form>
                </div>
                @if($search)
                    <a href="{{ route('students.index') }}" class="btn btn-secondary" style="background: #6b7280; border: none; border-radius: 8px; padding: 8px 16px; color: white; height: 38px;">
                        ✕ Clear
                    </a>
                @endif
                <a href="{{ route('students.create') }}" class="btn btn-light" style="background: #4f46e5; border: none; border-radius: 8px; padding: 8px 16px; color: white; height: 38px;">
                    + Add Student
                </a>
            </div>
        </div>
    </div>

    <div class="card-body p-0" style="background: #1f2937;">

        <div class="table-responsive">
            <table class="table table-hover align-middle" style="margin-bottom: 0; color: #1f1f1f">
                <thead style="background: #0f172a;">
                <tr>
                    <th style="font-weight: 600; color: #1f1f1f; border-bottom: 2px solid #374151;">#</th>
                    <th style="font-weight: 600; color: #1f1f1f; border-bottom: 2px solid #374151;">First Name</th>
                    <th style="font-weight: 600; color: #1f1f1f; border-bottom: 2px solid #374151;">Middle Name</th>
                    <th style="font-weight: 600; color: #1f1f1f; border-bottom: 2px solid #374151;">Last Name</th>
                    <th style="font-weight: 600; color: #1f1f1f; border-bottom: 2px solid #374151;">Grade & Section</th>
                    <th style="font-weight: 600; color: #1f1f1f; border-bottom: 2px solid #374151;">LRN</th>
                    <th width="220" style="font-weight: 600; color: #1f1f1f; border-bottom: 2px solid #374151;">Actions</th>
                </tr>
                </thead>

                <tbody>

                @forelse($students as $student)
                    <tr style="transition: background 0.2s;" onmouseover="this.style.background='#374151'" onmouseout="this.style.background='transparent'">
                        <td>{{ ($students->currentPage() - 1) * $students->perPage() + $loop->iteration }}</td>

                        <td>{{ $student->first_name }}</td>

                        <td>
                            {{ $student->middle_name ?: '-' }}
                        </td>

                        <td>{{ $student->last_name }}</td>

                        <td>
                            @if($student->currentGradeAndSection)
                                <span class="badge bg-primary" style="font-size: 0.85rem; padding: 6px 10px;">
                                    {{ $student->currentGradeAndSection->grade_level }} - {{ $student->currentGradeAndSection->section }}
                                </span>
                            @else
                                <span class="text-muted">No grade assigned</span>
                            @endif
                        </td>

                        <td>{{ $student->lrn }}</td>

                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('students.edit', $student->id) }}"
                                   class="btn btn-primary btn-sm" style="border-radius: 8px; background: #4f46e5; border: none;">
                                    Edit
                                </a>
                                <a href="{{ route('students.generateQr', $student->id) }}"
                                   class="btn btn-warning btn-sm" style="border-radius: 8px; background: #f59e0b; border: none;">
                                    QR
                                </a>
                                <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" style="border-radius: 8px; background: #ef4444; border: none;"
                                            onclick="return confirm('Are you sure you want to delete this student?');">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty

                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            No students found.
                        </td>
                    </tr>

                @endforelse

                </tbody>
            </table>
        </div>

    </div>

    @if($students->hasPages())
        <div class="card-footer" style="background: #0f172a; color: #e5e7eb; padding: 20px 25px;">
            {{ $students->appends(request()->query())->links() }}
        </div>
    @endif

</div>
@endsection

<style>
    .pagination {
        margin: 0;
    }

    .page-link {
        background-color: #1f2937;
        border-color: #374151;
        color: #e5e7eb;
    }

    .page-link:hover {
        background-color: #374151;
        border-color: #4f46e5;
        color: white;
    }

    .page-item.active .page-link {
        background-color: #4f46e5;
        border-color: #4f46e5;
        color: white;
    }

    .page-item.disabled .page-link {
        background-color: #1f2937;
        border-color: #374151;
        color: #6b7280;
    }
</style>
