@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('styles')
<style>
    .page-header {
        background: white;
        padding: 25px;
        border-radius: 10px;
        margin-bottom: 25px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .page-header h1 {
        color: #333;
        margin-bottom: 5px;
        font-size: 1.8em;
    }

    .page-header p {
        color: #666;
    }

    .stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 25px 20px;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        text-align: center;
        transition: all 0.3s ease;
        border-left: 4px solid;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.12);
    }

    .stat-card:hover::before {
        opacity: 1;
    }

    .stat-card h3 {
        font-size: 2.8em;
        margin-bottom: 8px;
        font-weight: 700;
        line-height: 1;
    }

    .stat-card p {
        font-size: 0.85em;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0;
    }

    /* Card Total - Blue Gradient */
    .stat-card.total {
        border-left-color: #3b82f6;
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    }

    .stat-card.total::before {
        background: linear-gradient(90deg, #3b82f6, #2563eb);
    }

    .stat-card.total h3 {
        color: #1e40af;
    }

    .stat-card.total p {
        color: #3b82f6;
    }

    /* Card Pending - Orange Gradient */
    .stat-card.pending {
        border-left-color: #f59e0b;
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
    }

    .stat-card.pending::before {
        background: linear-gradient(90deg, #f59e0b, #d97706);
    }

    .stat-card.pending h3 {
        color: #b45309;
    }

    .stat-card.pending p {
        color: #f59e0b;
    }

    /* Card Replied - Green Gradient */
    .stat-card.replied {
        border-left-color: #10b981;
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    }

    .stat-card.replied::before {
        background: linear-gradient(90deg, #10b981, #059669);
    }

    .stat-card.replied h3 {
        color: #047857;
    }

    .stat-card.replied p {
        color: #10b981;
    }

    /* Card Closed - Purple Gradient */
    .stat-card.closed {
        border-left-color: #8b5cf6;
        background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%);
    }

    .stat-card.closed::before {
        background: linear-gradient(90deg, #8b5cf6, #7c3aed);
    }

    .stat-card.closed h3 {
        color: #6d28d9;
    }

    .stat-card.closed p {
        color: #8b5cf6;
    }

    /* Card Email - Cyan Gradient */
    .stat-card.email {
        border-left-color: #06b6d4;
        background: linear-gradient(135deg, #ecfeff 0%, #cffafe 100%);
    }

    .stat-card.email::before {
        background: linear-gradient(90deg, #06b6d4, #0891b2);
    }

    .stat-card.email h3 {
        color: #0e7490;
    }

    .stat-card.email p {
        color: #06b6d4;
    }

    /* Card WhatsApp - Teal Gradient */
    .stat-card.whatsapp {
        border-left-color: #14b8a6;
        background: linear-gradient(135deg, #f0fdfa 0%, #ccfbf1 100%);
    }

    .stat-card.whatsapp::before {
        background: linear-gradient(90deg, #14b8a6, #0d9488);
    }

    .stat-card.whatsapp h3 {
        color: #0f766e;
    }

    .stat-card.whatsapp p {
        color: #14b8a6;
    }

    .filters {
        background: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 25px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .filters form {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        align-items: flex-end;
    }

    .filter-group {
        flex: 1;
        min-width: 200px;
    }

    .filter-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
        color: #333;
        font-size: 0.9em;
    }

    .filter-group select {
        width: 100%;
        padding: 10px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 0.95em;
        transition: border-color 0.3s ease;
    }

    .filter-group select:focus {
        outline: none;
        border-color: #667eea;
    }

    .btn-filter, .btn-reset {
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-filter {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(102, 126, 234, 0.4);
    }

    .btn-reset {
        background: #f5f5f5;
        color: #666;
        text-decoration: none;
        display: inline-block;
        line-height: 1.5;
    }

    .btn-reset:hover {
        background: #e0e0e0;
    }

    .questions-container {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .refresh-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }

    .refresh-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(102, 126, 234, 0.4);
    }

    .question-card {
        background: #f9f9f9;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .question-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .question-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .question-date {
        color: #667eea;
        font-weight: 600;
    }

    .question-meta {
        display: flex;
        gap: 15px;
        align-items: center;
        flex-wrap: wrap;
    }

    .aplikasi-badge {
        padding: 5px 12px;
        background: #667eea;
        color: white;
        border-radius: 20px;
        font-size: 0.85em;
        font-weight: 600;
    }

    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.85em;
        font-weight: 600;
    }

    .status-badge.pending {
        background: #fff3cd;
        color: #856404;
    }

    .status-badge.replied {
        background: #d4edda;
        color: #155724;
    }

    .status-badge.closed {
        background: #d1ecf1;
        color: #0c5460;
    }

    .question-ip {
        color: #999;
        font-size: 0.9em;
    }

    .question-content {
        background: white;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 15px;
        line-height: 1.6;
        border-left: 4px solid #667eea;
    }

    .question-image {
        margin: 15px 0;
        text-align: center;
    }

    .image-label {
        display: block;
        font-size: 0.9em;
        color: #666;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .question-image img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        cursor: pointer;
        transition: transform 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .question-image img:hover {
        transform: scale(1.02);
    }

    .contact-info {
        display: flex;
        gap: 20px;
        margin: 15px 0;
        flex-wrap: wrap;
    }

    .contact-item {
        background: white;
        padding: 10px 15px;
        border-radius: 8px;
        font-size: 0.9em;
    }

    .contact-item strong {
        color: #667eea;
        margin-right: 5px;
    }

    .contact-item a {
        color: #333;
        text-decoration: none;
    }

    .contact-item a:hover {
        color: #667eea;
        text-decoration: underline;
    }

    .status-actions {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
    }

    .status-select {
        padding: 10px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 0.9em;
    }

    .btn-update-status {
        padding: 10px 20px;
        background: #667eea;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-update-status:hover {
        background: #764ba2;
        transform: translateY(-2px);
    }

    .no-data {
        text-align: center;
        padding: 40px;
        color: #999;
        font-size: 1.1em;
    }

    /* Lightbox */
    .lightbox {
        display: none;
        position: fixed;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        justify-content: center;
        align-items: center;
    }

    .lightbox.active {
        display: flex;
    }

    .lightbox-close {
        position: absolute;
        top: 20px;
        right: 40px;
        color: white;
        font-size: 40px;
        cursor: pointer;
    }

    .lightbox img {
        max-width: 90%;
        max-height: 90%;
        border-radius: 10px;
    }

    @media (max-width: 768px) {
        .filters form {
            flex-direction: column;
        }

        .filter-group {
            width: 100%;
        }

        .contact-info {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <h1>Dashboard Admin</h1>
    <p>Kelola pertanyaan dari pengguna</p>
</div>

<div class="stats">
    <div class="stat-card total">
        <h3>{{ $stats['total'] }}</h3>
        <p>Total Pertanyaan</p>
    </div>
    <div class="stat-card pending">
        <h3>{{ $stats['pending'] }}</h3>
        <p>Pending</p>
    </div>
    <div class="stat-card replied">
        <h3>{{ $stats['replied'] }}</h3>
        <p>Replied</p>
    </div>
    <div class="stat-card closed">
        <h3>{{ $stats['closed'] }}</h3>
        <p>Closed</p>
    </div>
    <div class="stat-card email">
        <h3>{{ $stats['dengan_email'] }}</h3>
        <p>Dengan Email</p>
    </div>
    <div class="stat-card whatsapp">
        <h3>{{ $stats['dengan_whatsapp'] }}</h3>
        <p>Dengan WhatsApp</p>
    </div>
</div>

<div class="filters">
    <form method="GET" action="{{ route('layanan.admin') }}">
        <div class="filter-group">
            <label for="filter-aplikasi">Filter Aplikasi</label>
            <select name="aplikasi" id="filter-aplikasi">
                <option value="">Semua Aplikasi</option>
                @foreach($aplikasiList as $app)
                    <option value="{{ $app }}" {{ request('aplikasi') == $app ? 'selected' : '' }}>
                        {{ $app }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="filter-group">
            <label for="filter-status">Filter Status</label>
            <select name="status" id="filter-status">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Replied</option>
                <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
        </div>
        <button type="submit" class="btn-filter">Filter</button>
        <a href="{{ route('layanan.admin') }}" class="btn-reset">Reset</a>
    </form>
</div>

<div class="questions-container">
    <button class="refresh-btn" onclick="location.reload()">Refresh Data</button>

    @if($pertanyaan->isEmpty())
        <div class="no-data">
            Belum ada pertanyaan masuk
        </div>
    @else
        @foreach($pertanyaan as $item)
            <div class="question-card">
                <div class="question-header">
                    <div style="display: flex; flex-direction: column; gap: 5px;">
                        <span class="question-date">
                            {{ $item->created_at->format('d/m/Y H:i:s') }}
                        </span>
                        @if($item->nomor_tiket)
                            <span style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 4px 10px; border-radius: 15px; font-size: 0.8em; font-weight: 600; display: inline-block; width: fit-content;">
                                🎫 {{ $item->nomor_tiket }}
                            </span>
                        @endif
                    </div>
                    <div class="question-meta">
                        <span class="aplikasi-badge">{{ $item->aplikasi }}</span>
                        <span class="status-badge {{ $item->status }}">
                            {{ ucfirst($item->status) }}
                        </span>
                        <span class="question-ip">IP: {{ $item->ip_address }}</span>
                    </div>
                </div>

                <div class="question-content">
                    <strong>Pertanyaan:</strong><br>
                    {{ $item->pertanyaan }}
                </div>

                @if($item->gambar)
                    <div class="question-image">
                        <span class="image-label">📷 Screenshot:</span>
                        <img src="{{ asset($item->gambar) }}"
                             alt="Screenshot Pertanyaan"
                             onclick="openLightbox('{{ asset($item->gambar) }}')">
                    </div>
                @endif

                @if($item->jawaban)
                    <div class="question-content" style="background: #e8f4f8; border-left: 4px solid #28a745;">
                        <strong>Jawaban:</strong><br>
                        {{ $item->jawaban }}<br>
                        <small style="color: #666; margin-top: 10px; display: block;">
                            <em>Dijawab oleh: {{ $item->replied_by ?? 'Admin' }} pada {{ $item->replied_at ? $item->replied_at->format('d/m/Y H:i') : '-' }}</em>
                        </small>
                    </div>

                    @if($item->gambar_jawaban)
                        <div class="question-image">
                            <span class="image-label">📷 Screenshot jawaban:</span>
                            <img src="{{ asset($item->gambar_jawaban) }}"
                                 alt="Screenshot Jawaban"
                                 onclick="openLightbox('{{ asset($item->gambar_jawaban) }}')">
                        </div>
                    @endif
                @endif

                <div class="contact-info">
                    @if($item->email)
                        <div class="contact-item">
                            <strong>Email:</strong>
                            <a href="mailto:{{ $item->email }}">{{ $item->email }}</a>
                        </div>
                    @endif

                    @if($item->whatsapp)
                        <div class="contact-item">
                            <strong>WhatsApp:</strong>
                            <a href="{{ $item->whatsapp_link }}" target="_blank">{{ $item->whatsapp }}</a>
                        </div>
                    @endif
                </div>

                <div class="status-actions">
                    <a href="{{ route('layanan.reply', $item->id) }}" class="btn-update-status" style="text-decoration: none; display: inline-block;">
                        {{ $item->jawaban ? 'Edit Jawaban' : 'Balas Pertanyaan' }}
                    </a>
                    <select class="status-select" data-id="{{ $item->id }}">
                        <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="replied" {{ $item->status == 'replied' ? 'selected' : '' }}>Replied</option>
                        <option value="closed" {{ $item->status == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                    <button class="btn-update-status" onclick="updateStatus({{ $item->id }})">
                        Update Status
                    </button>
                </div>
            </div>
        @endforeach
    @endif
</div>

<!-- Lightbox untuk preview gambar fullscreen -->
<div id="lightbox" class="lightbox" onclick="closeLightbox()">
    <span class="lightbox-close">&times;</span>
    <img id="lightbox-img" src="" alt="Preview Gambar">
</div>
@endsection

@section('scripts')
<script>
    // Lightbox functions
    function openLightbox(imageSrc) {
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightbox-img');
        lightboxImg.src = imageSrc;
        lightbox.classList.add('active');
    }

    function closeLightbox() {
        const lightbox = document.getElementById('lightbox');
        lightbox.classList.remove('active');
    }

    // Close lightbox dengan ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });

    // Update status function
    function updateStatus(pertanyaanId) {
        const select = document.querySelector(`.status-select[data-id="${pertanyaanId}"]`);
        const newStatus = select.value;

        if (!confirm(`Update status menjadi "${newStatus}"?`)) {
            return;
        }

        fetch(`/admin/layanan/${pertanyaanId}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ status: newStatus })
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
            alert('Terjadi kesalahan saat update status');
        });
    }
</script>
@endsection
