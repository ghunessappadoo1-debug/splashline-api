@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-5" style="color: var(--teal);">
        <i class="fas fa-fish"></i> Animals
    </h1>

    <!-- Filter Row -->
    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <label for="filterSpecies" class="form-label">Filter by Species</label>
            <input type="text" class="form-control" id="filterSpecies" onkeyup="loadAnimals()" placeholder="e.g., Dolphin">
        </div>
        <div class="col-md-4">
            <label for="filterExhibit" class="form-label">Filter by Exhibit</label>
            <select class="form-select" id="filterExhibit" onchange="loadAnimals()">
                <option value="">All</option>
            </select>
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#animalModal" onclick="clearAnimalForm()">
                <i class="fas fa-plus"></i> New Animal
            </button>
        </div>
    </div>

    <!-- Animals Cards -->
    <div id="animals-list" class="row g-4"></div>
</div>

<!-- Animal Modal -->
<div class="modal fade" id="animalModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="animalModalLabel">Add Animal</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="animalForm">
                    <input type="hidden" id="animalId">
                    <div class="mb-3">
                        <label for="animalName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="animalName" required>
                    </div>
                    <div class="mb-3">
                        <label for="species" class="form-label">Species</label>
                        <input type="text" class="form-control" id="species" required>
                    </div>
                    <div class="mb-3">
                        <label for="age" class="form-label">Age</label>
                        <input type="number" class="form-control" id="age" min="0">
                    </div>
                    <div class="mb-3">
                        <label for="funFact" class="form-label">Fun Fact</label>
                        <textarea class="form-control" id="funFact" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="exhibit_id" class="form-label">Exhibit</label>
                        <select class="form-select" id="exhibit_id" required></select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveAnimal()">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Load exhibits for dropdowns
    function loadExhibitsForSelect() {
        return fetch(API_BASE + '/exhibits')
            .then(res => res.json())
            .then(data => {
                let options = '<option value="">Select Exhibit</option>';
                data.data.forEach(ex => {
                    options += `<option value="${ex.id}">${ex.name}</option>`;
                });
                document.getElementById('exhibit_id').innerHTML = options;
            });
    }

    // Load animals with optional filters
    function loadAnimals() {
        let url = API_BASE + '/animals?';
        const species = document.getElementById('filterSpecies').value;
        const exhibitId = document.getElementById('filterExhibit').value;
        if (species) url += `species=${encodeURIComponent(species)}&`;
        if (exhibitId) url += `exhibit_id=${exhibitId}`;
        fetch(url)
            .then(res => res.json())
            .then(data => {
                let html = '';
                data.data.forEach(animal => {
                    html += `
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">${animal.name}</h5>
                                    <p class="card-text"><strong>Species:</strong> ${animal.species}</p>
                                    <p class="card-text"><strong>Age:</strong> ${animal.age || 'Unknown'}</p>
                                    <p class="card-text"><strong>Fun Fact:</strong> ${animal.fun_fact || 'N/A'}</p>
                                    <button class="btn btn-sm btn-info" onclick="viewFeeding(${animal.id})"><i class="fas fa-clock"></i> Feeding</button>
                                    <button class="btn btn-sm btn-warning" onclick="editAnimal(${animal.id})"><i class="fas fa-edit"></i> Edit</button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteAnimal(${animal.id})"><i class="fas fa-trash"></i> Delete</button>
                                </div>
                            </div>
                        </div>
                    `;
                });
                document.getElementById('animals-list').innerHTML = html || '<p class="text-center">No animals found.</p>';
            });
    }

    function clearAnimalForm() {
        document.getElementById('animalId').value = '';
        document.getElementById('animalName').value = '';
        document.getElementById('species').value = '';
        document.getElementById('age').value = '';
        document.getElementById('funFact').value = '';
        document.getElementById('exhibit_id').value = '';
        document.getElementById('animalModalLabel').innerText = 'Add Animal';
        loadExhibitsForSelect();
    }

    function saveAnimal() {
        const id = document.getElementById('animalId').value;
        const data = {
            name: document.getElementById('animalName').value,
            species: document.getElementById('species').value,
            age: document.getElementById('age').value,
            fun_fact: document.getElementById('funFact').value,
            exhibit_id: document.getElementById('exhibit_id').value
        };
        const method = id ? 'PUT' : 'POST';
        const url = id ? `${API_BASE}/animals/${id}` : `${API_BASE}/animals`;

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(data => {
            if (data.errors) {
                alert('Error: ' + JSON.stringify(data.errors));
            } else {
                bootstrap.Modal.getInstance(document.getElementById('animalModal')).hide();
                loadAnimals();
            }
        });
    }

    function editAnimal(id) {
        fetch(`${API_BASE}/animals/${id}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('animalId').value = data.data.id;
                document.getElementById('animalName').value = data.data.name;
                document.getElementById('species').value = data.data.species;
                document.getElementById('age').value = data.data.age || '';
                document.getElementById('funFact').value = data.data.fun_fact || '';
                loadExhibitsForSelect().then(() => {
                    document.getElementById('exhibit_id').value = data.data.exhibit.id;
                });
                document.getElementById('animalModalLabel').innerText = 'Edit Animal';
                new bootstrap.Modal(document.getElementById('animalModal')).show();
            });
    }

    function deleteAnimal(id) {
        if (!confirm('Are you sure?')) return;
        fetch(`${API_BASE}/animals/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        })
        .then(() => loadAnimals());
    }

    function viewFeeding(animalId) {
        // Optionally open a modal with feeding schedules; for now just alert
        alert('Feeding schedules feature coming soon.');
    }

    // Load exhibit filter dropdown
    fetch(API_BASE + '/exhibits')
        .then(res => res.json())
        .then(data => {
            let options = '<option value="">All</option>';
            data.data.forEach(ex => {
                options += `<option value="${ex.id}">${ex.name}</option>`;
            });
            document.getElementById('filterExhibit').innerHTML = options;
        });

    loadAnimals();
</script>
@endpush