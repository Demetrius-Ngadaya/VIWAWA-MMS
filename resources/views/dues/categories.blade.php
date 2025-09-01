@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5>Due Categories</h5>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
        Add New Category
    </button>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>Created By</th>
                        <th>Last Updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>TZS {{ number_format($category->due_amount, 2) }}</td>
                        <td>{{ $category->description ?? 'N/A' }}</td>
                        <td>{{ $category->creator->name ?? 'N/A' }}</td>
                        <td>
                            @if($category->updated_by)
                                {{ $category->updater->name ?? 'N/A' }}<br>
                                <small>{{ $category->updated_at->format('M d, Y') }}</small>
                            @else
                                Never updated
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-warning" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editCategoryModal"
                                    data-category-id="{{ $category->id }}"
                                    data-category-name="{{ $category->name }}"
                                    data-category-amount="{{ $category->due_amount }}"
                                    data-category-description="{{ $category->description }}">
                                Edit
                            </button>
                            <form action="{{ route('due-categories.destroy', $category) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Category Modal -->
<div class="modal fade" id="createCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Due Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('due-categories.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Category Name *</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Due Amount (TZS) *</label>
                        <input type="number" name="due_amount" step="0.01" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Due Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="editCategoryForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Category Name *</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Due Amount (TZS) *</label>
                        <input type="number" name="due_amount" step="0.01" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // JavaScript to handle edit modal
    document.addEventListener('DOMContentLoaded', function() {
        const editModal = document.getElementById('editCategoryModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const categoryId = button.getAttribute('data-category-id');
            const categoryName = button.getAttribute('data-category-name');
            const categoryAmount = button.getAttribute('data-category-amount');
            const categoryDescription = button.getAttribute('data-category-description');
            
            const form = document.getElementById('editCategoryForm');
            form.action = '/due-categories/' + categoryId;
            
            form.querySelector('input[name="name"]').value = categoryName;
            form.querySelector('input[name="due_amount"]').value = categoryAmount;
            form.querySelector('textarea[name="description"]').value = categoryDescription;
        });
    });
</script>
@endsection