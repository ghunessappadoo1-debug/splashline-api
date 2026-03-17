@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-5" style="color: var(--teal);">
        <i class="fas fa-ticket-alt"></i> Bookings
    </h1>
    <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#bookingModal" onclick="clearBookingForm()">
        <i class="fas fa-plus"></i> New Booking
    </button>
    <div id="bookings-list"></div>
</div>

<!-- Booking Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingModalLabel">New Booking</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="bookingForm">
                    <input type="hidden" id="bookingId">
                    <div class="mb-3">
                        <label for="visitor_id" class="form-label">Visitor</label>
                        <select class="form-select" id="visitor_id" required></select>
                    </div>
                    <div class="mb-3">
                        <label for="ticket_id" class="form-label">Ticket Type</label>
                        <select class="form-select" id="ticket_id" required></select>
                    </div>
                    <div class="mb-3">
                        <label for="visit_date" class="form-label">Visit Date</label>
                        <input type="date" class="form-control" id="visit_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" min="1" value="1" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveBooking()">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function loadVisitorsAndTickets() {
        // Load visitors dropdown
        fetch(API_BASE + '/visitors')
            .then(res => res.json())
            .then(data => {
                let options = '<option value="">Select Visitor</option>';
                data.data.forEach(v => {
                    options += `<option value="${v.id}">${v.name}</option>`;
                });
                document.getElementById('visitor_id').innerHTML = options;
            });

        fetch(API_BASE + '/tickets')
            .then(res => res.json())
            .then(data => {
                let options = '<option value="">Select Ticket</option>';
                data.data.forEach(t => {
                    options += `<option value="${t.id}">${t.type} - $${t.price}</option>`;
                });
                document.getElementById('ticket_id').innerHTML = options;
            });
    }

    function loadBookings() {
        fetch(API_BASE + '/bookings')
            .then(res => res.json())
            .then(data => {
                let html = '<table class="table table-hover"><thead><tr><th>ID</th><th>Visitor</th><th>Ticket</th><th>Date</th><th>Qty</th><th>Total</th><th>Status</th><th>Actions</th></tr></thead><tbody>';
                data.data.forEach(b => {
                    html += `<tr>
                        <td>${b.id}</td>
                        <td>${b.visitor ? b.visitor.name : ''}</td>
                        <td>${b.ticket ? b.ticket.type : ''}</td>
                        <td>${b.visit_date}</td>
                        <td>${b.quantity}</td>
                        <td>$${b.total_price}</td>
                        <td><span class="badge ${b.status === 'cancelled' ? 'bg-danger' : 'bg-success'}">${b.status}</span></td>
                        <td>
                            ${b.status !== 'cancelled' ? `<button class="btn btn-sm btn-warning" onclick="cancelBooking(${b.id})"><i class="fas fa-ban"></i> Cancel</button>` : ''}
                        </td>
                    </tr>`;
                });
                html += '</tbody></table>';
                document.getElementById('bookings-list').innerHTML = html || '<p class="text-center">No bookings found.</p>';
            });
    }

    function clearBookingForm() {
        document.getElementById('bookingId').value = '';
        document.getElementById('visit_date').value = '';
        document.getElementById('quantity').value = '1';
        loadVisitorsAndTickets();
    }

    function saveBooking() {
        const data = {
            visitor_id: document.getElementById('visitor_id').value,
            ticket_id: document.getElementById('ticket_id').value,
            visit_date: document.getElementById('visit_date').value,
            quantity: document.getElementById('quantity').value
        };
        fetch(API_BASE + '/bookings', {
            method: 'POST',
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
                bootstrap.Modal.getInstance(document.getElementById('bookingModal')).hide();
                loadBookings();
            }
        });
    }

    function cancelBooking(id) {
        if (!confirm('Cancel this booking?')) return;
        fetch(`${API_BASE}/bookings/${id}/cancel`, {
            method: 'PATCH',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        })
        .then(res => res.json())
        .then(() => loadBookings());
    }

    loadBookings();
</script>
@endpush