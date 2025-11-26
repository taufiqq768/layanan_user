<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - Daftar Pertanyaan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left h1 {
            font-size: 2em;
            margin-bottom: 5px;
        }

        .header-left p {
            opacity: 0.9;
        }

        .header-right {
            text-align: right;
        }

        .admin-info {
            margin-bottom: 15px;
        }

        .admin-info .name {
            font-size: 1.1em;
            font-weight: 600;
            margin-bottom: 3px;
        }

        .admin-info .email {
            font-size: 0.9em;
            opacity: 0.8;
        }

        .admin-info .apps {
            font-size: 0.85em;
            opacity: 0.8;
            margin-top: 5px;
        }

        .btn-logout {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid white;
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9em;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-logout:hover {
            background: white;
            color: #667eea;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .stat-card h3 {
            color: #667eea;
            font-size: 2.5em;
            margin-bottom: 5px;
        }

        .stat-card p {
            color: #666;
            font-size: 0.9em;
        }

        .filters {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: end;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .filter-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: 600;
            font-size: 0.9em;
        }

        .filter-group select {
            width: 100%;
            padding: 10px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 1em;
        }

        .btn-filter {
            padding: 10px 20px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
        }

        .btn-filter:hover {
            background: #5568d3;
        }

        .btn-reset {
            padding: 10px 20px;
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
        }

        .questions-container {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .question-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .question-card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .question-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
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
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .question-image {
            margin-bottom: 15px;
        }

        .question-image img {
            max-width: 100%;
            max-height: 400px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .question-image img:hover {
            transform: scale(1.02);
        }

        .image-label {
            display: block;
            color: #667eea;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 0.9em;
        }

        /* Lightbox untuk preview gambar */
        .lightbox {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        .lightbox.active {
            display: flex;
        }

        .lightbox img {
            max-width: 90%;
            max-height: 90%;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
        }

        .lightbox-close {
            position: absolute;
            top: 20px;
            right: 30px;
            color: white;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
            z-index: 10000;
        }

        .lightbox-close:hover {
            color: #ccc;
        }

        .contact-info {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            background: #f0f0f0;
            border-radius: 5px;
        }

        .contact-item strong {
            color: #667eea;
        }

        .contact-item a {
            color: #333;
            text-decoration: none;
        }

        .contact-item a:hover {
            color: #667eea;
        }

        .status-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .status-actions select {
            padding: 8px 12px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            font-size: 0.9em;
        }

        .btn-update-status {
            padding: 8px 15px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9em;
        }

        .btn-update-status:hover {
            background: #218838;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
            font-size: 1.1em;
        }

        .refresh-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            margin-bottom: 20px;
        }

        .refresh-btn:hover {
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
            }

            .header-right {
                text-align: left;
                width: 100%;
            }

            .question-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .contact-info {
                flex-direction: column;
            }

            .filters {
                flex-direction: column;
            }

            .filter-group {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-left">
                <h1>Dashboard Admin</h1>
                <p>Kelola pertanyaan dari pengguna</p>
            </div>
            <div class="header-right">
                <div class="admin-info">
                    <div class="name">{{ auth()->guard('admin')->user()->name }}</div>
                    <div class="email">{{ auth()->guard('admin')->user()->email }}</div>
                    <div class="apps">
                        Mengelola: {{ implode(', ', auth()->guard('admin')->user()->aplikasi_list) }}
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            </div>
        </div>

        <div class="stats">
            <div class="stat-card">
                <h3>{{ $stats['total'] }}</h3>
                <p>Total Pertanyaan</p>
            </div>
            <div class="stat-card">
                <h3>{{ $stats['pending'] }}</h3>
                <p>Pending</p>
            </div>
            <div class="stat-card">
                <h3>{{ $stats['replied'] }}</h3>
                <p>Replied</p>
            </div>
            <div class="stat-card">
                <h3>{{ $stats['closed'] }}</h3>
                <p>Closed</p>
            </div>
            <div class="stat-card">
                <h3>{{ $stats['dengan_email'] }}</h3>
                <p>Dengan Email</p>
            </div>
            <div class="stat-card">
                <h3>{{ $stats['dengan_whatsapp'] }}</h3>
                <p>Dengan WhatsApp</p>
            </div>
        </div>

        <div class="filters">
            <form method="GET" action="{{ route('layanan.admin') }}" style="display: flex; gap: 15px; flex-wrap: wrap; width: 100%;">
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
                <a href="{{ route('layanan.admin') }}" class="btn-reset" style="text-decoration: none; display: inline-block; line-height: 1.5;">Reset</a>
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
                            <a href="{{ route('layanan.reply', $item->id) }}" class="btn-update-status" style="text-decoration: none; background: #667eea; display: inline-block;">
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
    </div>

    <!-- Lightbox untuk preview gambar fullscreen -->
    <div id="lightbox" class="lightbox" onclick="closeLightbox()">
        <span class="lightbox-close">&times;</span>
        <img id="lightbox-img" src="" alt="Preview Gambar">
    </div>

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

        // Close lightbox with ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeLightbox();
            }
        });

        function updateStatus(id) {
            const select = document.querySelector(`.status-select[data-id="${id}"]`);
            const newStatus = select.value;

            if (!confirm('Yakin ingin mengubah status pertanyaan ini?')) {
                return;
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            fetch(`/admin/layanan/${id}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Status berhasil diupdate!');
                    location.reload();
                } else {
                    alert('Gagal mengupdate status: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengupdate status');
            });
        }
    </script>
</body>
</html>