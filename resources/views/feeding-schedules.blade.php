@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-5" style="color: var(--teal);">
        <i class="fas fa-clock"></i> Feeding Schedules
    </h1>
    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <label for="filterExhibitFeed" class="form-label">Filter by Exhibit</label>
            <select class="form-select" id="filterExhibitFeed" onchange="loadFeedingSchedules()">
                <option value="">All</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="filterAnimalFeed" class="form-label">Filter by Animal</label>
            <select class="form-select" id="filterAnimalFeed" onchange="loadFeedingSchedules()">
                <option value="">All</option>
            </select>
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#feedingModal" onclick="clearFeedingForm()">
                <i class="fas fa-plus"></i> New Schedule
            </button>
        </div>
    </div>
    <div id="feeding-list"></div>
</div>

<!-- Feeding Modal -->
<div class="modal fade" id="feedingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="feedingModalLabel">New Feeding Schedule</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="feedingForm">
                    <input type="hidden" id="feedingId">
                    <div class="mb-3">
                        <label class="form-label">Assign to</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="assignType" id="assignExhibit" value="exhibit" checked>
                            <label class="form-check-label" for="assignExhibit">Exhibit</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="assignType" id="assignAnimal" value="animal">
                            <label class="form-check-label" for="assignAnimal">Animal</label>
                        </div>
                    </div>
                    <div class="mb-3" id="exhibitSelectDiv">
                        <label for="exhibit_id_feed" class="form-label">Exhibit</label>
                        <select class="form-select" id="exhibit_id_feed"></select>
                    </div>
                    <div class="mb-3" id="animalSelectDiv" style="display:none;">
                        <label for="animal_id_feed" class="form-label">Animal</label>
                        <select class="form-select" id="animal_id_feed"></select>
                    </div>
                    <div class="mb-3">
                        <label for="feeding_time" class="form-label">Feeding Time</label>
                        <input type="time" class="form-control" id="feeding_time" required>
                    </div>
                    <div class="mb-3">
                        <label for="food_type" class="form-label">Food Type</label>
                        <input type="text" class="form-control" id="food_type">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveFeedingSchedule()">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('input[name="assignType"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'exhibit') {
                document.getElementById('exhibitSelectDiv').style.display = 'block';
                document.getElementById('animalSelectDiv').style.display = 'none';
            } else {
                document.getElementById('exhibitSelectDiv').style.display = 'none';
                document.getElementById('animalSelectDiv').style.display = 'block';
            }
        });
    });

    function loadExhibitsAndAnimals() {
        fetch(API_BASE + '/exhibits')
            .then(res => res.json())
            .then(data => {
                let options = '<option value="">Select Exhibit</option>';
                data.data.forEach(ex => {
                    options += `<option value="${ex.id}">${ex.name}</option>`;
                });
                document.getElementById('exhibit_id_feed').innerHTML = options;
                document.getElementById('filterExhibitFeed').innerHTML = '<option value="">All</option>' + options;
            });

        fetch(API_BASE + '/animals')
            .then(res => res.json())
            .then(data => {
                let options = '<option value="">Select Animal</option>';
                data.data.forEach(an => {
                    options += `<option value="${an.id}">${an.name} (${an.species})</option>`;
                });
                document.getElementById('animal_id_feed').innerHTML = options;
                document.getElementById('filterAnimalFeed').innerHTML = '<option value="">All</option>' + options;
            });
    }

    function loadFeedingSchedules() {
        let url = API_BASE + '/feeding-schedules?';
        const exhibitId = document.getElementById('filterExhibitFeed').value;
        const animalId = document.getElementById('filterAnimalFeed').value;
        if (exhibitId) url += `exhibit_id=${exhibitId}&`;
        if (animalId) url += `animal_id=${animalId}`;
        fetch(url)
            .then(res => res.json())
            .then(data => {
                let html = '<table class="table table-hover"><thead><tr><th>ID</th><th>Exhibit/Animal</th><th>Time</th><th>Food</th><th>Actions</th></tr></thead><tbody>';
                data.data.forEach(s => {
                    let target = s.exhibit ? `Exhibit: ${s.exhibit.name}` : (s.animal ? `Animal: ${s.animal.name}` : '');
                    html += `<tr>
                        <td>${s.id}</td>
                        <td>${target}</td>
                        <td>${s.feeding_time}</td>
                        <td>${s.food_type || 'N/A'}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" onclick="editFeedingSchedule(${s.id})"><i class="fas fa-edit"></i> Edit</button>
                            <button class="btn btn-sm btn-danger" onclick="deleteFeedingSchedule(${s.id})"><i class="fas fa-trash"></i> Delete</button>
                        </td>
                    </tr>`;
                });
                html += '</tbody></table>';
                document.getElementById('feeding-list').innerHTML = html || '<p class="text-center">No schedules found.</p>';
            });
    }

    function clearFeedingForm() {
        document.getElementById('feedingId').value = '';
        document.getElementById('feeding_time').value = '';
        document.getElementById('food_type').value = '';
        document.getElementById('exhibit_id_feed').value = '';
        document.getElementById('animal_id_feed').value = '';
        document.getElementById('assignExhibit').checked = true;
        document.getElementById('exhibitSelectDiv').style.display = 'block';
        document.getElementById('animalSelectDiv').style.display = 'none';
        loadExhibitsAndAnimals();
    }

    function saveFeedingSchedule() {
        const id = document.getElementById('feedingId').value;
        const assignType = document.querySelector('input[name="assignType"]:checked').value;
        let data = {
            feeding_time: document.getElementById('feeding_time').value,
            food_type: document.getElementById('food_type').value
        };
        if (assignType === 'exhibit') {
            data.exhibit_id = document.getElementById('exhibit_id_feed').value;
            if (!data.exhibit_id) { alert('Please select an exhibit.'); return; }
        } else {
            data.animal_id = document.getElementById('animal_id_feed').value;
            if (!data.animal_id) { alert('Please select an animal.'); return; }
        }
        const method = id ? 'PUT' : 'POST';
        const url = id ? `${API_BASE}/feeding-schedules/${id}` : `${API_BASE}/feeding-schedules`;

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
            } else if (data.error) {
                alert('Error: ' + data.error);
            } else {
                bootstrap.Modal.getInstance(document.getElementById('feedingModal')).hide();
                loadFeedingSchedules();
            }
        });
    }

    function editFeedingSchedule(id) {
        fetch(`${API_BASE}/feeding-schedules/${id}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('feedingId').value = data.data.id;
                document.getElementById('feeding_time').value = data.data.feeding_time;
                document.getElementById('food_type').value = data.data.food_type || '';
                if (data.data.exhibit) {
                    document.getElementById('assignExhibit').checked = true;
                    document.getElementById('exhibitSelectDiv').style.display = 'block';
                    document.getElementById('animalSelectDiv').style.display = 'none';
                    loadExhibitsAndAnimals().then(() => {
                        document.getElementById('exhibit_id_feed').value = data.data.exhibit.id;
                    });
                } else if (data.data.animal) {
                    document.getElementById('assignAnimal').checked = true;
                    document.getElementById('exhibitSelectDiv').style.display = 'none';
                    document.getElementById('animalSelectDiv').style.display = 'block';
                    loadExhibitsAndAnimals().then(() => {
                        document.getElementById('animal_id_feed').value = data.data.animal.id;
                    });
                }
                document.getElementById('feedingModalLabel').innerText = 'Edit Feeding Schedule';
                new bootstrap.Modal(document.getElementById('feedingModal')).show();
            });
    }

    function deleteFeedingSchedule(id) {
        if (!confirm('Are you sure?')) return;
        fetch(`${API_BASE}/feeding-schedules/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        })
        .then(() => loadFeedingSchedules());
    }

    loadExhibitsAndAnimals();
    loadFeedingSchedules();
</script>
@endpush