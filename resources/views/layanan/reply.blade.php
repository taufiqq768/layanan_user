<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Balas Pertanyaan - Admin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        .header {
            background: white;
            padding: 20px 30px;
            border-radius: 10px 10px 0 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            color: #667eea;
            font-size: 1.8em;
            margin-bottom: 5px;
        }

        .header .breadcrumb {
            color: #666;
            font-size: 0.9em;
        }

        .header .breadcrumb a {
            color: #667eea;
            text-decoration: none;
        }

        .header .breadcrumb a:hover {
            text-decoration: underline;
        }

        .content {
            background: white;
            padding: 30px;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .question-info {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            border-left: 4px solid #667eea;
        }

        .info-row {
            display: flex;
            margin-bottom: 12px;
            align-items: start;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-label {
            font-weight: 600;
            color: #667eea;
            min-width: 120px;
        }

        .info-value {
            color: #333;
            flex: 1;
        }

        .aplikasi-badge {
            display: inline-block;
            padding: 4px 12px;
            background: #667eea;
            color: white;
            border-radius: 15px;
            font-size: 0.85em;
            font-weight: 600;
        }

        .question-text {
            background: white;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #e0e0e0;
            line-height: 1.6;
            margin-top: 8px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 0.95em;
        }

        .form-group label .required {
            color: #e74c3c;
        }

        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1em;
            font-family: inherit;
            resize: vertical;
            min-height: 150px;
            transition: all 0.3s ease;
        }

        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group input[type="text"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        .form-group input[type="text"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .send-options {
            background: #f0f7ff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .send-options h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 1.1em;
        }

        .checkbox-group {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .checkbox-item input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .checkbox-item label {
            cursor: pointer;
            color: #333;
            font-weight: 500;
        }

        .checkbox-item.disabled {
            opacity: 0.5;
        }

        .checkbox-item.disabled input,
        .checkbox-item.disabled label {
            cursor: not-allowed;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
        }

        .alert.success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            display: block;
        }

        .alert.error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            display: block;
        }

        .alert.info {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
            display: block;
        }

        .contact-info {
            background: #fff3cd;
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            border-left: 4px solid #ffc107;
        }

        .contact-info strong {
            color: #856404;
        }

        .file-upload-container {
            margin-top: 10px;
            padding: 15px;
            border: 2px dashed #e0e0e0;
            border-radius: 8px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .file-upload-container:hover {
            border-color: #667eea;
            background-color: #f8f9fa;
        }

        .file-upload-container.drag-over {
            border-color: #667eea;
            background-color: #f0f0ff;
        }

        .file-upload-label {
            display: block;
            cursor: pointer;
            color: #666;
            font-size: 0.9em;
        }

        input[type="file"] {
            display: none;
        }

        .image-preview {
            margin-top: 10px;
            display: none;
            position: relative;
        }

        .image-preview.active {
            display: block;
        }

        .image-preview img {
            max-width: 100%;
            max-height: 300px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .remove-image {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            cursor: pointer;
            font-size: 18px;
            line-height: 1;
            transition: all 0.3s ease;
        }

        .remove-image:hover {
            background: #c0392b;
            transform: scale(1.1);
        }

        .file-info {
            margin-top: 10px;
            font-size: 0.85em;
            color: #999;
        }

        .question-image {
            margin-top: 15px;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 8px;
        }

        .question-image img {
            max-width: 100%;
            max-height: 400px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .image-label {
            display: block;
            color: #667eea;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 0.9em;
        }

        @media (max-width: 768px) {
            .info-row {
                flex-direction: column;
            }

            .info-label {
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Balas Pertanyaan</h1>
            <div class="breadcrumb">
                <a href="{{ route('layanan.admin') }}">Dashboard</a> / Balas Pertanyaan #{{ $pertanyaan->id }}
            </div>
        </div>

        <div class="content">
            <div id="alertMessage" class="alert"></div>

            @if($pertanyaan->jawaban)
                <div class="alert info">
                    <strong>Pertanyaan ini sudah dijawab!</strong><br>
                    Dijawab oleh: {{ $pertanyaan->replied_by ?? 'Admin' }} pada {{ $pertanyaan->replied_at ? $pertanyaan->replied_at->format('d/m/Y H:i') : '-' }}
                </div>
            @endif

            <div class="question-info">
                <div class="info-row">
                    <span class="info-label">Aplikasi:</span>
                    <span class="info-value">
                        <span class="aplikasi-badge">{{ $pertanyaan->aplikasi }}</span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal:</span>
                    <span class="info-value">{{ $pertanyaan->created_at->format('d/m/Y H:i:s') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value">{{ ucfirst($pertanyaan->status) }}</span>
                </div>
            </div>

            <div class="question-info">
                <div class="info-row">
                    <span class="info-label">Pertanyaan:</span>
                </div>
                <div class="question-text">
                    {{ $pertanyaan->pertanyaan }}
                </div>

                @if($pertanyaan->gambar)
                    <div class="question-image">
                        <span class="image-label">📷 Screenshot dari penanya:</span>
                        <img src="{{ asset($pertanyaan->gambar) }}" alt="Screenshot Pertanyaan">
                    </div>
                @endif
            </div>

            <div class="contact-info">
                <strong>Kontak Penanya:</strong><br>
                @if($pertanyaan->email)
                    Email: <strong>{{ $pertanyaan->email }}</strong><br>
                @endif
                @if($pertanyaan->whatsapp)
                    WhatsApp: <strong>{{ $pertanyaan->whatsapp }}</strong>
                @endif
            </div>

            <form id="replyForm">
                @csrf
                <div class="form-group">
                    <label for="replied_by">
                        Nama Anda (Admin) <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        id="replied_by"
                        name="replied_by"
                        placeholder="Nama admin yang menjawab"
                        value="{{ $pertanyaan->replied_by ?? '' }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="jawaban">
                        Jawaban <span class="required">*</span>
                    </label>
                    <textarea
                        id="jawaban"
                        name="jawaban"
                        placeholder="Tuliskan jawaban Anda di sini..."
                        required
                    >{{ $pertanyaan->jawaban ?? '' }}</textarea>

                    <div class="file-upload-container" id="uploadContainer">
                        <input type="file" id="gambar_jawaban" name="gambar_jawaban" accept="image/*">
                        <label for="gambar_jawaban" class="file-upload-label">
                            <div style="font-size: 2em; color: #667eea; margin-bottom: 5px;">📷</div>
                            <div><strong>Upload Screenshot Jawaban (Opsional)</strong></div>
                            <div style="font-size: 0.85em; margin-top: 5px;">Klik atau drag & drop gambar di sini</div>
                            <div class="file-info">Format: JPG, PNG, GIF (Max: 2MB)</div>
                        </label>
                    </div>

                    <div class="image-preview" id="imagePreview">
                        <button type="button" class="remove-image" id="removeImage">&times;</button>
                        <img id="previewImg" src="" alt="Preview">
                    </div>

                    @if($pertanyaan->gambar_jawaban)
                        <div class="question-image">
                            <span class="image-label">📷 Screenshot jawaban saat ini:</span>
                            <img src="{{ asset($pertanyaan->gambar_jawaban) }}" alt="Screenshot Jawaban">
                        </div>
                    @endif
                </div>

                <div class="send-options">
                    <h3>Kirim Jawaban Melalui:</h3>
                    <div class="checkbox-group">
                        <div class="checkbox-item {{ $pertanyaan->email ? '' : 'disabled' }}">
                            <input
                                type="checkbox"
                                id="send_email"
                                name="send_email"
                                value="1"
                                {{ $pertanyaan->email ? '' : 'disabled' }}
                                {{ $pertanyaan->email ? 'checked' : '' }}
                            >
                            <label for="send_email">
                                Email {{ $pertanyaan->email ? '('.$pertanyaan->email.')' : '(Tidak tersedia)' }}
                            </label>
                        </div>
                        <div class="checkbox-item {{ $pertanyaan->whatsapp ? '' : 'disabled' }}">
                            <input
                                type="checkbox"
                                id="send_whatsapp"
                                name="send_whatsapp"
                                value="1"
                                {{ $pertanyaan->whatsapp ? '' : 'disabled' }}
                                {{ $pertanyaan->whatsapp ? 'checked' : '' }}
                            >
                            <label for="send_whatsapp">
                                WhatsApp {{ $pertanyaan->whatsapp ? '('.$pertanyaan->whatsapp.')' : '(Tidak tersedia)' }}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="action-buttons">
                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                        Kirim Jawaban
                    </button>
                    <a href="{{ route('layanan.admin') }}" class="btn btn-secondary">
                        Kembali ke Dashboard
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('replyForm');
            const alertMessage = document.getElementById('alertMessage');
            const btnSubmit = document.getElementById('btnSubmit');

            // Image upload handling
            const fileInput = document.getElementById('gambar_jawaban');
            const uploadContainer = document.getElementById('uploadContainer');
            const imagePreview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            const removeImageBtn = document.getElementById('removeImage');

            // File input change handler
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    handleFile(file);
                }
            });

            // Drag and drop handlers
            uploadContainer.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                uploadContainer.classList.add('drag-over');
            });

            uploadContainer.addEventListener('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                uploadContainer.classList.remove('drag-over');
            });

            uploadContainer.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                uploadContainer.classList.remove('drag-over');

                const file = e.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) {
                    fileInput.files = e.dataTransfer.files;
                    handleFile(file);
                }
            });

            // Remove image handler
            removeImageBtn.addEventListener('click', function() {
                fileInput.value = '';
                imagePreview.classList.remove('active');
                uploadContainer.style.display = 'block';
            });

            // Handle file function
            function handleFile(file) {
                // Validate file type
                if (!file.type.startsWith('image/')) {
                    alert('File harus berupa gambar (JPG, PNG, GIF)');
                    fileInput.value = '';
                    return;
                }

                // Validate file size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file maksimal 2MB');
                    fileInput.value = '';
                    return;
                }

                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    imagePreview.classList.add('active');
                    uploadContainer.style.display = 'none';
                };
                reader.readAsDataURL(file);
            }

            function showAlert(message, type) {
                alertMessage.textContent = message;
                alertMessage.className = 'alert ' + type;
                alertMessage.style.display = 'block';
                alertMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

                if (type === 'success') {
                    setTimeout(() => {
                        window.location.href = '{{ route("layanan.admin") }}';
                    }, 2000);
                }
            }

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const jawaban = document.getElementById('jawaban').value.trim();
                const repliedBy = document.getElementById('replied_by').value.trim();
                const sendEmail = document.getElementById('send_email').checked;
                const sendWhatsapp = document.getElementById('send_whatsapp').checked;

                if (!jawaban) {
                    showAlert('Jawaban harus diisi!', 'error');
                    return;
                }

                if (!repliedBy) {
                    showAlert('Nama admin harus diisi!', 'error');
                    return;
                }

                if (!sendEmail && !sendWhatsapp) {
                    showAlert('Pilih minimal satu metode pengiriman (Email atau WhatsApp)!', 'error');
                    return;
                }

                const originalText = btnSubmit.textContent;
                btnSubmit.disabled = true;
                btnSubmit.textContent = 'Mengirim...';

                const formData = new FormData(form);

                fetch('{{ route("layanan.sendReply", $pertanyaan->id) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert(data.message, 'success');

                        // Jika ada WhatsApp link, buka di tab baru
                        if (data.whatsapp_link) {
                            window.open(data.whatsapp_link, '_blank');
                        }
                    } else {
                        showAlert(data.message, 'error');
                        btnSubmit.disabled = false;
                        btnSubmit.textContent = originalText;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Terjadi kesalahan saat mengirim jawaban. Silakan coba lagi.', 'error');
                    btnSubmit.disabled = false;
                    btnSubmit.textContent = originalText;
                });
            });
        });
    </script>
</body>
</html>