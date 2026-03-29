@extends('layouts.app')

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="glass-card">
            <h3 class="fw-bold mb-4">Visitor Registry</h3>
            <div class="table-responsive">
                <table class="table table-glass">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Registered</th>
                        </tr>
                    </thead>
                    <tbody id="visitor-table">
                        <tr><td colspan="4" class="text-center">Loading visitors...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="glass-card">
            <h3 class="fw-bold mb-4">Add Visitor</h3>
            <form id="visitorForm" onsubmit="saveVisitor(event)">
                <div class="mb-3">
                    <label class="form-label text-white-50">Full Name</label>
                    <input type="text" id="name" class="form-control form-control-glass" required>
                </div>
                <div class="mb-4">
                    <label class="form-label text-white-50">Email Address</label>
                    <input type="email" id="email" class="form-control form-control-glass" required>
                </div>
                <button type="submit" class="btn btn-glass w-100">Register Visitor</button>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    async function loadVisitors() {
        const visitors = await apiFetch('/visitors');
        const tbody = document.getElementById('visitor-table');
        tbody.innerHTML = visitors.map(v => `
            <tr>
                <td>#${v.id}</td>
                <td class="fw-bold">${v.name}</td>
                <td>${v.email}</td>
                <td class="text-white-50">${new Date(v.created_at).toLocaleDateString()}</td>
            </tr>
        `).join('') || '<tr><td colspan="4" class="text-center">No visitors registered.</td></tr>';
    }

    async function saveVisitor(e) {
        e.preventDefault();
        const data = {
            name: document.getElementById('name').value,
            email: document.getElementById('email').value
        };

        const result = await apiFetch('/visitors', {
            method: 'POST',
            body: JSON.stringify(data)
        });

        if (result.errors) {
            alert(Object.values(result.errors).flat().join('\n'));
        } else {
            alert('Visitor registered successfully!');
            document.getElementById('visitorForm').reset();
            loadVisitors();
        }
    }

    document.addEventListener('DOMContentLoaded', () => loadVisitors());
</script>
@endsection
@endsection
