@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-5" style="color: var(--teal);">
        <i class="fas fa-ship"></i> Tours
    </h1>
    <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#tourModal" onclick="clearTourForm()">
        <i class="fas fa-plus"></i> New Tour
    </button>
    <button class="btn btn-info mb-4 ms-2" onclick="loadUpcomingTours()">
        <i class="fas fa-calendar-alt"></i> Show Upcoming Tours
    </button>
    <div id="tours-list"></div>
</div>

<!-- Tour Modal -->
<div class="modal fade" id="tourModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tourModalLabel">New Tour</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="tourForm">
                    <input type="hidden" id="tourId">
                    <div class="mb-3">
                        <label for="tourName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="tourName" required>
                    </div>
                    <div class="mb-3">
                        <label for="tourDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="tourDescription" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="start_time" class="form-label">Start Time</label>
                        <input type="datetime-local" class="form-control" id="start_time" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_time" class="form-label">End Time</label>
                        <input type="datetime-local" class="form-control" id="end_time" required>
                    </div>
                    <div class="mb-3">
                        <label for="max_participants" class="form-label">Max Participants</label>
                        <input type="number" class="form-control" id="max_participants" min="1" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveTour()">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function loadTours(url = API_BASE + '/tours') {
        fetch(url)
            .then(res => res.json())
            .then(data => {
                let html = '<table class="table table-hover"><thead><tr><th>ID</th><th>Name</th><th>Start</th><th>End</th><th>Max</th><th>Registrations</th><th>Actions</th></tr></thead><tbody>';
                data.data.forEach(t => {
                    html += `<tr>
                        <td>${t.id}</td>
                        <td>${t.name}</td>
                        <td>${t.start_time}</td>
                        <td>${t.end_time}</td>
                        <td>${t.max_participants}</td>
                        <td>${t.registrations_count || 0}</td>
                        <td>
                            <button class="btn btn-sm btn-info" onclick="registerVisitor(${t.id})"><i class="fas fa-user-plus"></i> Register</button>
                            <button class="btn btn-sm btn-warning" onclick="editTour(${t.id})"><i class="fas fa-edit"></i> Edit</button>
                            <button class="btn btn-sm btn-danger" onclick="deleteTour(${t.id})"><i class="fas fa-trash"></i> Delete</button>
                        </td>
                    </tr>`;
                });
                html += '</tbody></table>';
                document.getElementById('tours-list').innerHTML = html || '<p class="text-center">No tours found.</p>';
            });
    }

    function loadUpcomingTours() {
        loadTours(API_BASE + '/tours/upcoming');
    }

    function clearTourForm() {
        document.getElementById('tourId').value = '';
        document.getElementById('tourName').value = '';
        document.getElementById('tourDescription').value = '';
        document.getElementById('start_time').value = '';
        document.getElementById('end_time').value = '';
        document.getElementById('max_participants').value = '';
        document.getElementById('tourModalLabel').innerText = 'New Tour';
    }

    function saveTour() {
        const id = document.getElementById('tourId').value;
        const data = {
            name: document.getElementById('tourName').value,
            description: document.getElementById('tourDescription').value,
            start_time: document.getElementById('start_time').value,
            end_time: document.getElementById('end_time').value,
            max_participants: document.getElementById('max_participants').value
        };
        const method = id ? 'PUT' : 'POST';
        const url = id ? `${API_BASE}/tours/${id}` : `${API_BASE}/tours`;

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
                bootstrap.Modal.getInstance(document.getElementById('tourModal')).hide();
                loadTours();
            }
        });
    }

    function editTour(id) {
        fetch(`${API_BASE}/tours/${id}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('tourId').value = data.data.id;
                document.getElementById('tourName').value = data.data.name;
                document.getElementById('tourDescription').value = data.data.description || '';
                document.getElementById('start_time').value = data.data.start_time.slice(0,16);
                document.getElementById('end_time').value = data.data.end_time.slice(0,16);
                document.getElementById('max_participants').value = data.data.max_participants;
                document.getElementById('tourModalLabel').innerText = 'Edit Tour';
                new bootstrap.Modal(document.getElementById('tourModal')).show();
            });
    }

    function deleteTour(id) {
        if (!confirm('Are you sure?')) return;
        fetch(`${API_BASE}/tours/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        })
        .then(() => loadTours());
    }

    function registerVisitor(tourId) {
        const visitorId = prompt('Enter Visitor ID:');
        if (!visitorId) return;
        fetch(`${API_BASE}/tours/${tourId}/register`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ visitor_id: visitorId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                alert('Error: ' + data.error);
            } else {
                alert('Registration successful!');
                loadTours();
            }
        });
    }

    loadTours();
</script>
@endpush