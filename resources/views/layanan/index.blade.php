<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Layanan Pengguna - Tanya Jawab</title>
    {!! NoCaptcha::renderJs() !!}
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
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 900px;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .subtitle {
            font-size: 1.1em;
            opacity: 0.9;
        }

        .form-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 0.95em;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1em;
            font-family: inherit;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
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

        .file-upload-label i {
            font-size: 2em;
            color: #667eea;
            margin-bottom: 10px;
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

        .form-group select {
            cursor: pointer;
            background-color: white;
        }

        .error-message {
            display: block;
            color: #e74c3c;
            font-size: 0.85em;
            margin-top: 5px;
            min-height: 20px;
        }

        .note {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 20px;
            font-style: italic;
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .btn-faq {
            display: inline-block;
            width: 100%;
            padding: 12px;
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
            border-radius: 8px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
            margin-top: 10px;
        }

        .btn-faq:hover:not(:disabled) {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-faq:disabled {
            opacity: 0.4;
            cursor: not-allowed;
            border-color: #ccc;
            color: #999;
        }

        .response-message {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            display: none;
            font-size: 0.95em;
        }

        .response-message.success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            display: block;
        }

        .response-message.error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            display: block;
        }

        @media (max-width: 640px) {
            .header h1 {
                font-size: 2em;
            }

            .form-container {
                padding: 25px;
            }

            body {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">

            <!-- <h1>Helpdesk Layanan Aplikasi PTPN I</h1> -->

             <img src="{{ asset('images/logo.png') }}" alt="Logo PTPN I" class="logo">
            <h2>Respon Tanggap Layanan Aplikasi PTPN I</h2>
             <h3>Selamat Datang di Halaman Helpdesk Layanan Aplikasi PTPN I</h3>
            <p>Silahkan ajukan pertanyaan/keluhan/saran seputar aplikasi yang anda pilih</p>

        </div>

        <div class="form-container">
            <form id="serviceForm">
                @csrf
                <div class="form-group">
                    <label for="aplikasi">Pilih Aplikasi *</label>
                    <select id="aplikasi" name="aplikasi" required>
                        <option value="">Pilih Aplikasi</option>
                        @foreach($aplikasiList as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <button type="button" id="btnFaq" class="btn-faq" disabled>
                        FAQ - Lihat Pertanyaan yang Sering Diajukan
                    </button>
                    <span class="error-message" id="error-aplikasi"></span>
                </div>

                <div class="form-group">
                    <label for="pertanyaan">Pertanyaan/keluhan/saran Anda *</label>
                    <textarea
                        id="pertanyaan"
                        name="pertanyaan"
                        rows="6"
                        placeholder="Tuliskan pertanyaan Anda di sini..."
                        required
                    ></textarea>

                    <div class="file-upload-container" id="uploadContainer">
                        <input type="file" id="gambar" name="gambar" accept="image/*">
                        <label for="gambar" class="file-upload-label">
                            <div style="font-size: 2em; color: #667eea; margin-bottom: 5px;">📷</div>
                            <div><strong>Upload Screenshot (Opsional)</strong></div>
                            <div style="font-size: 0.85em; margin-top: 5px;">Klik atau drag & drop gambar di sini</div>
                            <div class="file-info">Format: JPG, PNG, GIF (Max: 2MB)</div>
                        </label>
                    </div>

                    <div class="image-preview" id="imagePreview">
                        <button type="button" class="remove-image" id="removeImage">&times;</button>
                        <img id="previewImg" src="" alt="Preview">
                    </div>

                    <span class="error-message" id="error-pertanyaan"></span>
                    <span class="error-message" id="error-gambar"></span>
                </div>

                <div class="form-group">
                    <label>Agar kami dapat merespon silakan isi Email dan/atau nomor WhatsApp</label>

                    <label for="email" class="note">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="contoh@email.com"
                    >
                    <span class="error-message" id="error-email"></span>
                    <label for="whatsapp" class="note">Nomor WhatsApp</label>
                    <input
                        type="tel"
                        id="whatsapp"
                        name="whatsapp"
                        placeholder="08123456789"
                    >
                    <span class="error-message" id="error-whatsapp"></span>
                <p class="note">* Minimal satu kontak (Email atau WhatsApp) harus diisi</p>
                </div>

                @if(config('captcha.enabled', true))
                <div class="form-group" style="margin-bottom: 20px;">
                    {!! NoCaptcha::display() !!}
                    <span class="error-message" id="error-captcha"></span>
                </div>
                @endif

                <button type="submit" class="btn-submit">Kirim Pertanyaan</button>
            </form>

            <div id="responseMessage" class="response-message"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('serviceForm');
            const responseMessage = document.getElementById('responseMessage');
            const aplikasiSelect = document.getElementById('aplikasi');
            const btnFaq = document.getElementById('btnFaq');

            // Auto-select aplikasi jika ada parameter dari URL
            @if(isset($selectedApp) && $selectedApp)
                aplikasiSelect.value = '{{ $selectedApp }}';
                // Enable FAQ button since aplikasi is auto-selected
                btnFaq.disabled = false;
            @endif

            // Enable/disable FAQ button based on aplikasi selection
            aplikasiSelect.addEventListener('change', function() {
                if (this.value) {
                    btnFaq.disabled = false;
                } else {
                    btnFaq.disabled = true;
                }
            });

            // Handle FAQ button click
            btnFaq.addEventListener('click', function() {
                const aplikasi = aplikasiSelect.value;
                if (aplikasi) {
                    window.location.href = '{{ route("layanan.faq") }}?aplikasi=' + aplikasi;
                }
            });

            // Image upload handling
            const fileInput = document.getElementById('gambar');
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
                } else {
                    showError('error-gambar', 'File harus berupa gambar');
                }
            });

            // Remove image handler
            removeImageBtn.addEventListener('click', function() {
                fileInput.value = '';
                imagePreview.classList.remove('active');
                uploadContainer.style.display = 'block';
                showError('error-gambar', '');
            });

            // Handle file function
            function handleFile(file) {
                // Validate file type
                if (!file.type.startsWith('image/')) {
                    showError('error-gambar', 'File harus berupa gambar (JPG, PNG, GIF)');
                    fileInput.value = '';
                    return;
                }

                // Validate file size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    showError('error-gambar', 'Ukuran file maksimal 2MB');
                    fileInput.value = '';
                    return;
                }

                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    imagePreview.classList.add('active');
                    uploadContainer.style.display = 'none';
                    showError('error-gambar', '');
                };
                reader.readAsDataURL(file);
            }

            function showError(elementId, message) {
                const errorElement = document.getElementById(elementId);
                if (errorElement) {
                    errorElement.textContent = message;
                }
            }

            function clearErrors() {
                const errorElements = document.querySelectorAll('.error-message');
                errorElements.forEach(element => {
                    element.textContent = '';
                });
            }

            function showResponseMessage(message, isSuccess) {
                responseMessage.textContent = message;
                responseMessage.className = 'response-message ' + (isSuccess ? 'success' : 'error');
                responseMessage.style.display = 'block';
                responseMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

                if (isSuccess) {
                    setTimeout(() => {
                        responseMessage.style.display = 'none';
                    }, 5000);
                }
            }

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                clearErrors();
                responseMessage.style.display = 'none';

                const aplikasi = document.getElementById('aplikasi').value.trim();
                const pertanyaan = document.getElementById('pertanyaan').value.trim();
                const email = document.getElementById('email').value.trim();
                const whatsapp = document.getElementById('whatsapp').value.trim();

                let isValid = true;

                if (aplikasi === '') {
                    showError('error-aplikasi', 'Pilih aplikasi terlebih dahulu');
                    isValid = false;
                }

                if (pertanyaan === '') {
                    showError('error-pertanyaan', 'Pertanyaan harus diisi');
                    isValid = false;
                }

                if (email === '' && whatsapp === '') {
                    showError('error-email', 'Minimal satu kontak harus diisi');
                    showError('error-whatsapp', 'Minimal satu kontak harus diisi');
                    isValid = false;
                }

                if (email !== '') {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        showError('error-email', 'Format email tidak valid');
                        isValid = false;
                    }
                }

                if (whatsapp !== '') {
                    const whatsappClean = whatsapp.replace(/[^0-9]/g, '');
                    if (whatsappClean.length < 10) {
                        showError('error-whatsapp', 'Nomor WhatsApp minimal 10 digit');
                        isValid = false;
                    }
                }

                if (!isValid) {
                    return;
                }

                const submitBtn = form.querySelector('.btn-submit');
                const originalText = submitBtn.textContent;
                submitBtn.disabled = true;
                submitBtn.textContent = 'Mengirim...';

                const formData = new FormData(form);

                fetch('{{ route("layanan.store") }}', {
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
                        showResponseMessage(data.message, true);
                        form.reset();
                        // Reset image preview
                        imagePreview.classList.remove('active');
                        uploadContainer.style.display = 'block';
                        fileInput.value = '';
                    } else {
                        showResponseMessage(data.message, false);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showResponseMessage('Terjadi kesalahan saat mengirim data. Silakan coba lagi.', false);
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                });
            });

            document.getElementById('email').addEventListener('blur', function() {
                const email = this.value.trim();
                if (email !== '') {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        showError('error-email', 'Format email tidak valid');
                    } else {
                        showError('error-email', '');
                    }
                } else {
                    showError('error-email', '');
                }
            });

            document.getElementById('whatsapp').addEventListener('blur', function() {
                const whatsapp = this.value.trim();
                if (whatsapp !== '') {
                    const whatsappClean = whatsapp.replace(/[^0-9]/g, '');
                    if (whatsappClean.length < 10) {
                        showError('error-whatsapp', 'Nomor WhatsApp minimal 10 digit');
                    } else {
                        showError('error-whatsapp', '');
                    }
                } else {
                    showError('error-whatsapp', '');
                }
            });
        });
    </script>
</body>
</html>
