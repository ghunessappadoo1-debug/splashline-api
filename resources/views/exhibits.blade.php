@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4" style="color: var(--teal);"><i class="fas fa-water"></i> Exhibits</h1>
        <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#exhibitModal" onclick="clearExhibitForm()">
            <i class="fas fa-plus"></i> New Exhibit
        </button>
        <div id="exhibits-list" class="row g-4"></div>
    </div>

    <!-- Exhibit Modal (same structure, but with updated form styling) -->
    <div class="modal fade" id="exhibitModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exhibitModalLabel">Add Exhibit</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="exhibitForm">
                        <input type="hidden" id="exhibitId">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location">
                        </div>
                        <div class="mb-3">
                            <label for="capacity" class="form-label">Capacity</label>
                            <input type="number" class="form-control" id="capacity" min="1">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveExhibit()">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Animals Modal -->
    <div class="modal fade" id="animalsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Animals in Exhibit</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="animals-list-modal">
                    <!-- Loaded via JS -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function loadExhibits() {
        fetch(API_BASE + '/exhibits')
            .then(res => res.json())
            .then(data => {
                let html = '';
                data.data.forEach(exhibit => {
                    html += `
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">${exhibit.name}</h5>
                                    <p class="card-text">${exhibit.description || 'No description'}</p>
                                    <p><strong>Location:</strong> ${exhibit.location || 'N/A'}</p>
                                    <p><strong>Capacity:</strong> ${exhibit.capacity || 'N/A'}</p>
                                    <button class="btn btn-sm btn-info" onclick="viewAnimals(${exhibit.id})"><i class="fas fa-eye"></i> Animals</button>
                                    <button class="btn btn-sm btn-warning" onclick="editExhibit(${exhibit.id})"><i class="fas fa-edit"></i> Edit</button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteExhibit(${exhibit.id})"><i class="fas fa-trash"></i> Delete</button>
                                </div>
                            </div>
                        </div>
                    `;
                });
                document.getElementById('exhibits-list').innerHTML = html || '<p class="text-center">No exhibits found.</p>';
            });
    }

    // The rest of the JavaScript functions (clearExhibitForm, saveExhibit, editExhibit, deleteExhibit, viewAnimals) 
    // remain exactly as before. Include them here.
    // (I'll not repeat them for brevity, but they are the same as in the earlier answer.)
</script>
@endpush