@extends('layouts.admin')

@section('title', 'Kelola Admin')

@section('styles')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: white;
        padding: 25px;
        border-radius: 10px;
        margin-bottom: 25px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .page-header h1 {
        color: #333;
        margin: 0;
    }

    .btn-add {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(102, 126, 234, 0.4);
    }

    .table-container {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: #535355ff;
        color: white;
        padding: 15px;
        text-align: left;
        font-weight: 600;
    }

    td {
        padding: 15px;
        border-bottom: 1px solid #e0e0e0;
    }

    tr:hover {
        background: #f9f9f9;
    }

    .badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.85em;
        font-weight: 600;
        margin: 2px;
        display: inline-block;
    }

    .badge.app {
        background: #e3f2fd;
        color: #1976d2;
    }

    .btn-action {
        padding: 8px 16px;
        margin: 0 5px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.9em;
        transition: all 0.3s ease;
    }

    .btn-edit {
        background: #ffc107;
        color: #333;
    }

    .btn-edit:hover {
        background: #ffb300;
    }

    .btn-delete {
        background: #dc3545;
        color: white;
    }

    .btn-delete:hover {
        background: #c82333;
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        overflow: auto;
    }

    .modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: white;
        padding: 30px;
        border-radius: 10px;
        width: 90%;
        max-width: 600px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .modal-header h2 {
        margin: 0;
        color: #667eea;
    }

    .close {
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        color: #999;
    }

    .close:hover {
        color: #333;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 12px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 0.95em;
        transition: border-color 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #667eea;
    }

    .form-group select[multiple] {
        min-height: 150px;
    }

    .form-group select[multiple] option {
        padding: 8px 12px;
        border-radius: 4px;
        margin: 2px 0;
    }

    .form-group select[multiple] option:checked {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 25px;
    }

    .btn-cancel {
        background: #6c757d;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-submit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(102, 126, 234, 0.4);
    }

    .password-hint {
        font-size: 0.85em;
        color: #666;
        margin-top: 5px;
        font-style: italic;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <h1>👥 Kelola Admin</h1>
    <button class="btn-add" onclick="openModal('create')">
        ➕ Tambah Admin
    </button>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Aplikasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($admins as $index => $admin)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong>{{ $admin->name }}</strong></td>
                <td>{{ $admin->email }}</td>
                <td>
                    @foreach($admin->aplikasi_list as $app)
                        <span class="badge app">{{ $app }}</span>
                    @endforeach
                </td>
                <td>
                    <button class="btn-action btn-edit" onclick='editData(@json($admin))'>
                        ✏️ Edit
                    </button>
                    <button class="btn-action btn-delete" onclick="deleteData({{ $admin->id }}, '{{ $admin->name }}')">
                        🗑️ Hapus
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 40px; color: #999;">
                    Belum ada data admin
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Create/Edit -->
<div id="modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modalTitle">Tambah Admin</h2>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>

        <form id="adminForm">
            <input type="hidden" id="adminId">
            <input type="hidden" id="formMode" value="create">

            <div class="form-group">
                <label for="name">Nama <span style="color: red;">*</span></label>
                <input type="text" id="name" name="name" required
                       placeholder="Nama lengkap admin">
            </div>

            <div class="form-group">
                <label for="email">Email <span style="color: red;">*</span></label>
                <input type="email" id="email" name="email" required
                       placeholder="email@example.com">
            </div>

            <div class="form-group">
                <label for="password">Password <span style="color: red;" id="passwordRequired">*</span></label>
                <input type="password" id="password" name="password"
                       placeholder="Minimal 6 karakter">
                <div class="password-hint" id="passwordHint"></div>
            </div>

            <div class="form-group">
                <label for="aplikasi">Aplikasi yang di-handle <span style="color: red;">*</span></label>
                <select id="aplikasi" name="aplikasi[]" multiple size="5" required>
                    @foreach($aplikasiList as $app)
                        <option value="{{ $app->inisial }}">{{ $app->inisial }}</option>
                    @endforeach
                </select>
                <div style="font-size: 0.85em; color: #666; margin-top: 5px;">
                    Tekan Ctrl (Windows) atau Cmd (Mac) untuk memilih lebih dari satu
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const modal = document.getElementById('modal');
    const form = document.getElementById('adminForm');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // Open modal
    function openModal(mode, data = null) {
        document.getElementById('formMode').value = mode;

        if (mode === 'create') {
            document.getElementById('modalTitle').textContent = 'Tambah Admin';
            form.reset();
            document.getElementById('adminId').value = '';
            document.getElementById('password').required = true;
            document.getElementById('passwordRequired').style.display = 'inline';
            document.getElementById('passwordHint').textContent = '';
        } else {
            document.getElementById('modalTitle').textContent = 'Edit Admin';
            document.getElementById('password').required = false;
            document.getElementById('passwordRequired').style.display = 'none';
            document.getElementById('passwordHint').textContent = 'Kosongkan jika tidak ingin mengubah password';
        }

        modal.classList.add('active');
    }

    // Close modal
    function closeModal() {
        modal.classList.remove('active');
        form.reset();
    }

    // Edit data
    function editData(data) {
        document.getElementById('adminId').value = data.id;
        document.getElementById('name').value = data.name;
        document.getElementById('email').value = data.email;
        document.getElementById('password').value = '';

        // Deselect all aplikasi options first
        const selectElement = document.getElementById('aplikasi');
        Array.from(selectElement.options).forEach(option => {
            option.selected = false;
        });

        // Select the aplikasi that this admin handles
        if (data.aplikasi_list && data.aplikasi_list.length > 0) {
            data.aplikasi_list.forEach(app => {
                const option = Array.from(selectElement.options).find(opt => opt.value === app);
                if (option) {
                    option.selected = true;
                }
            });
        }

        openModal('edit');
    }

    // Delete data
    function deleteData(id, nama) {
        if (!confirm(`Hapus admin "${nama}"?\n\nData yang terkait dengan admin ini akan dihapus.`)) {
            return;
        }

        fetch(`/admin/manajemen/admin/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus data');
        });
    }

    // Form submit handler
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(form);
        const mode = document.getElementById('formMode').value;
        const id = document.getElementById('adminId').value;

        // Validate at least one aplikasi is selected
        const selectedAplikasi = formData.getAll('aplikasi[]');
        if (selectedAplikasi.length === 0) {
            alert('Pilih minimal satu aplikasi yang akan di-handle oleh admin ini');
            return;
        }

        const url = mode === 'create'
            ? '/admin/manajemen/admin'
            : `/admin/manajemen/admin/${id}`;

        const method = mode === 'create' ? 'POST' : 'PUT';

        // Convert FormData to JSON
        const data = {};
        formData.forEach((value, key) => {
            if (key === 'aplikasi[]') {
                if (!data.aplikasi) {
                    data.aplikasi = [];
                }
                data.aplikasi.push(value);
            } else {
                data[key] = value;
            }
        });

        // Remove empty password on edit
        if (mode === 'edit' && !data.password) {
            delete data.password;
        }

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan data');
        });
    });

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target == modal) {
            closeModal();
        }
    }
</script>
@endsection
