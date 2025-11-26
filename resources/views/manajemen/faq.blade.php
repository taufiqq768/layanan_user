@extends('layouts.admin')

@section('title', 'Kelola FAQ')

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
        max-width: 700px;
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
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 12px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 0.95em;
        transition: border-color 0.3s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: #667eea;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 120px;
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
    <h1>❓ Kelola FAQ</h1>
    <button class="btn-add" onclick="openModal('create')">
        ➕ Tambah FAQ
    </button>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Aplikasi</th>
                <th>Pertanyaan</th>
                <th>Jawaban</th>
                <th>Urutan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($faqList as $index => $faq)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong>{{ $faq->aplikasi }}</strong></td>
                <td>{{ Str::limit($faq->pertanyaan, 60) }}</td>
                <td>{{ Str::limit($faq->jawaban, 60) }}</td>
                <td>{{ $faq->urutan }}</td>
                <td>
                    <span class="badge {{ $faq->is_active ? 'active' : 'inactive' }}">
                        {{ $faq->is_active ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </td>
                <td>
                    <button class="btn-action btn-edit" onclick='editData(@json($faq))'>
                        ✏️ Edit
                    </button>
                    <button class="btn-action btn-delete" onclick="deleteData({{ $faq->id }}, '{{ Str::limit($faq->pertanyaan, 30) }}')">
                        🗑️ Hapus
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 40px; color: #999;">
                    Belum ada data FAQ
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
            <h2 id="modalTitle">Tambah FAQ</h2>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>

        <form id="faqForm">
            <input type="hidden" id="faqId">
            <input type="hidden" id="formMode" value="create">

            <div class="form-group">
                <label for="aplikasi">Aplikasi <span style="color: red;">*</span></label>
                <select id="aplikasi" name="aplikasi" required>
                    <option value="">Pilih Aplikasi</option>
                    @foreach($aplikasiList as $app)
                        <option value="{{ $app->inisial }}">{{ $app->inisial }} - {{ $app->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="pertanyaan">Pertanyaan <span style="color: red;">*</span></label>
                <textarea id="pertanyaan" name="pertanyaan" required
                          placeholder="Tulis pertanyaan yang sering diajukan..."></textarea>
            </div>

            <div class="form-group">
                <label for="jawaban">Jawaban <span style="color: red;">*</span></label>
                <textarea id="jawaban" name="jawaban" required
                          placeholder="Tulis jawaban lengkap untuk pertanyaan di atas..."></textarea>
            </div>

            <div class="form-group">
                <label for="urutan">Urutan Tampilan <span style="color: red;">*</span></label>
                <input type="number" id="urutan" name="urutan" min="0" value="0" required
                       placeholder="Urutan FAQ (0 = paling atas)">
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
    const form = document.getElementById('faqForm');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // Open modal
    function openModal(mode, data = null) {
        document.getElementById('formMode').value = mode;

        if (mode === 'create') {
            document.getElementById('modalTitle').textContent = 'Tambah FAQ';
            form.reset();
            document.getElementById('faqId').value = '';
        } else {
            document.getElementById('modalTitle').textContent = 'Edit FAQ';
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
        document.getElementById('faqId').value = data.id;
        document.getElementById('aplikasi').value = data.aplikasi;
        document.getElementById('pertanyaan').value = data.pertanyaan;
        document.getElementById('jawaban').value = data.jawaban;
        document.getElementById('urutan').value = data.urutan;

        // Set radio button
        const radioActive = document.querySelector(`input[name="is_active"][value="${data.is_active ? '1' : '0'}"]`);
        if (radioActive) radioActive.checked = true;

        openModal('edit');
    }

    // Delete data
    function deleteData(id, pertanyaan) {
        if (!confirm(`Hapus FAQ "${pertanyaan}"?`)) {
            return;
        }

        fetch(`/admin/manajemen/faq/${id}`, {
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
        const id = document.getElementById('faqId').value;

        const url = mode === 'create'
            ? '/admin/manajemen/faq'
            : `/admin/manajemen/faq/${id}`;

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
