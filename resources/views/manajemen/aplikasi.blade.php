@extends('layouts.admin')

@section('title', 'Kelola Aplikasi')

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
    }

    .badge.active {
        background: #d4edda;
        color: #155724;
    }

    .badge.inactive {
        background: #f8d7da;
        color: #721c24;
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
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 0.95em;
        transition: border-color 0.3s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #667eea;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .radio-group {
        display: flex;
        gap: 20px;
    }

    .radio-group label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: normal;
        cursor: pointer;
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
</style>
@endsection

@section('content')
<div class="page-header">
    <h1>📱 Kelola Aplikasi</h1>
    <button class="btn-add" onclick="openModal('create')">
        ➕ Tambah Aplikasi
    </button>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Inisial</th>
                <th>Nama Aplikasi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($aplikasiList as $index => $aplikasi)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong>{{ $aplikasi->inisial }}</strong></td>
                <td>{{ $aplikasi->nama }}</td>
                <td>
                    <span class="badge {{ $aplikasi->is_active ? 'active' : 'inactive' }}">
                        {{ $aplikasi->is_active ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </td>
                <td>
                    <button class="btn-action btn-edit" onclick='editData(@json($aplikasi))'>
                        ✏️ Edit
                    </button>
                    <button class="btn-action btn-delete" onclick="deleteData({{ $aplikasi->id }}, '{{ $aplikasi->nama }}')">
                        🗑️ Hapus
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 40px; color: #999;">
                    Belum ada data aplikasi
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
            <h2 id="modalTitle">Tambah Aplikasi</h2>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>

        <form id="aplikasiForm">
            <input type="hidden" id="aplikasiId">
            <input type="hidden" id="formMode" value="create">

            <div class="form-group">
                <label for="inisial">Inisial <span style="color: red;">*</span></label>
                <input type="text" id="inisial" name="inisial" maxlength="50" required
                       placeholder="Contoh: NADINE, DFarm, HRIS">
            </div>

            <div class="form-group">
                <label for="nama">Nama Aplikasi <span style="color: red;">*</span></label>
                <input type="text" id="nama" name="nama" required
                       placeholder="Contoh: Nadine - Aplikasi Keuangan">
            </div>

            <div class="form-group">
                <label>Status <span style="color: red;">*</span></label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="is_active" value="1" checked>
                        Aktif
                    </label>
                    <label>
                        <input type="radio" name="is_active" value="0">
                        Tidak Aktif
                    </label>
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
    const form = document.getElementById('aplikasiForm');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // Open modal
    function openModal(mode, data = null) {
        document.getElementById('formMode').value = mode;

        if (mode === 'create') {
            document.getElementById('modalTitle').textContent = 'Tambah Aplikasi';
            form.reset();
            document.getElementById('aplikasiId').value = '';
        } else {
            document.getElementById('modalTitle').textContent = 'Edit Aplikasi';
            // Data akan di-set dari editData()
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
        document.getElementById('aplikasiId').value = data.id;
        document.getElementById('inisial').value = data.inisial;
        document.getElementById('nama').value = data.nama;

        // Set radio button
        const radioActive = document.querySelector(`input[name="is_active"][value="${data.is_active ? '1' : '0'}"]`);
        if (radioActive) radioActive.checked = true;

        openModal('edit');
    }

    // Delete data
    function deleteData(id, nama) {
        if (!confirm(`Hapus aplikasi "${nama}"?\n\nData yang terkait dengan aplikasi ini mungkin akan terpengaruh.`)) {
            return;
        }

        fetch(`/admin/manajemen/aplikasi/${id}`, {
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
        const id = document.getElementById('aplikasiId').value;

        const url = mode === 'create'
            ? '/admin/manajemen/aplikasi'
            : `/admin/manajemen/aplikasi/${id}`;

        const method = mode === 'create' ? 'POST' : 'PUT';

        // Convert FormData to JSON
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });

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
