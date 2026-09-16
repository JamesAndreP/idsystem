@extends('layouts.sidebar')

@section('title', 'Grade Levels')

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
            <h3 style="margin: 0; font-weight: 600;">Grade Levels & Sections</h3>

            <div class="d-flex gap-2 align-items-center">
                <div class="d-flex">
                    <form action="{{ route('grade-sections.index') }}" method="GET" class="d-flex m-0">
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search..." class="form-control" style="border-radius: 8px 0 0 8px; padding: 8px 12px; border: 1px solid #374151; color: #6c6f72; min-width: 200px; height: 38px;">
                        <button type="submit" class="btn btn-primary" style="border-radius: 0 8px 8px 0; padding: 8px 16px; background: #4f46e5; border: none; color: white; height: 38px;">
                            🔍
                        </button>
                    </form>
                </div>
                @if($search)
                    <a href="{{ route('grade-sections.index') }}" class="btn btn-secondary" style="background: #6b7280; border: none; border-radius: 8px; padding: 8px 16px; color: white; height: 38px;">
                        ✕ Clear
                    </a>
                @endif
                <a href="{{ route('grade-sections.create') }}" class="btn btn-light" style="background: #4f46e5; border: none; border-radius: 8px; padding: 8px 16px; color: white; height: 38px;">
                    + Add Grade
                </a>
            </div>
        </div>
    </div>

    <div class="card-body p-0" style="background: #1f2937;">

        <div class="table-responsive">
            <table class="table table-hover align-middle" style="margin-bottom: 0; color: #1f1f1f;">
                <thead style="background: #0f172a;">
                <tr>
                    <th style="font-weight: 600; color: #1f1f1f; border-bottom: 2px solid #374151;">#</th>
                    <th style="font-weight: 600; color: #1f1f1f; border-bottom: 2px solid #374151;">Grade Level</th>
                    <th style="font-weight: 600; color: #1f1f1f; border-bottom: 2px solid #374151;">Section</th>
                    <th style="font-weight: 600; color: #1f1f1f; border-bottom: 2px solid #374151;">Students Count</th>
                    <th width="220" style="font-weight: 600; color: #1f1f1f; border-bottom: 2px solid #374151;">Actions</th>
                </tr>
                </thead>

                <tbody>

                @forelse($gradeAndSections as $gradeAndSection)
                    <tr style="transition: background 0.2s;" onmouseover="this.style.background='#374151'" onmouseout="this.style.background='transparent'">
                        <td>{{ ($gradeAndSections->currentPage() - 1) * $gradeAndSections->perPage() + $loop->iteration }}</td>

                        <td>{{ $gradeAndSection->grade_level }}</td>

                        <td>
                            <span class="badge bg-primary" style="font-size: 0.85rem; padding: 6px 10px;">
                                {{ $gradeAndSection->section }}
                            </span>
                        </td>

                        <td>{{ $gradeAndSection->students()->count() }}</td>

                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('grade-sections.edit', $gradeAndSection->id) }}" class="btn btn-primary btn-sm" style="border-radius: 8px; background: #4f46e5; border: none;">
                                    Edit
                                </a>
                                <a href="{{ route('grade-sections.attendance', $gradeAndSection->id) }}" class="btn btn-warning btn-sm" style="border-radius: 8px; background: #f59e0b; border: none;">
                                    Attendance
                                </a>
                                <form action="{{ route('grade-sections.destroy', $gradeAndSection->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" style="border-radius: 8px; background: #ef4444; border: none;" onclick="return confirm('Are you sure you want to delete this grade and section?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty

                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            No grade levels found.
                        </td>
                    </tr>

                @endforelse

                </tbody>
            </table>
        </div>

    </div>

    @if($gradeAndSections->hasPages())
        <div class="card-footer" style="background: #0f172a; color: #e5e7eb; padding: 20px 25px;">
            {{ $gradeAndSections->appends(request()->query())->links() }}
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
