document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('serviceForm');
    const responseMessage = document.getElementById('responseMessage');

    // Fungsi untuk menampilkan pesan error
    function showError(elementId, message) {
        const errorElement = document.getElementById(elementId);
        if (errorElement) {
            errorElement.textContent = message;
        }
    }

    // Fungsi untuk membersihkan semua pesan error
    function clearErrors() {
        const errorElements = document.querySelectorAll('.error-message');
        errorElements.forEach(element => {
            element.textContent = '';
        });
    }

    // Fungsi untuk menampilkan response message
    function showResponseMessage(message, isSuccess) {
        responseMessage.textContent = message;
        responseMessage.className = 'response-message ' + (isSuccess ? 'success' : 'error');
        responseMessage.style.display = 'block';

        // Scroll ke pesan
        responseMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

        // Sembunyikan pesan setelah 5 detik jika sukses
        if (isSuccess) {
            setTimeout(() => {
                responseMessage.style.display = 'none';
            }, 5000);
        }
    }

    // Validasi form
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Bersihkan error sebelumnya
        clearErrors();
        responseMessage.style.display = 'none';

        // Ambil nilai input
        const pertanyaan = document.getElementById('pertanyaan').value.trim();
        const email = document.getElementById('email').value.trim();
        const whatsapp = document.getElementById('whatsapp').value.trim();

        let isValid = true;

        // Validasi pertanyaan
        if (pertanyaan === '') {
            showError('error-pertanyaan', 'Pertanyaan harus diisi');
            isValid = false;
        }

        // Validasi minimal satu kontak
        if (email === '' && whatsapp === '') {
            showError('error-email', 'Minimal satu kontak harus diisi');
            showError('error-whatsapp', 'Minimal satu kontak harus diisi');
            isValid = false;
        }

        // Validasi format email
        if (email !== '') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                showError('error-email', 'Format email tidak valid');
                isValid = false;
            }
        }

        // Validasi nomor WhatsApp
        if (whatsapp !== '') {
            const whatsappClean = whatsapp.replace(/[^0-9]/g, '');
            if (whatsappClean.length < 10) {
                showError('error-whatsapp', 'Nomor WhatsApp minimal 10 digit');
                isValid = false;
            }
        }

        // Jika tidak valid, hentikan
        if (!isValid) {
            return;
        }

        // Disable tombol submit
        const submitBtn = form.querySelector('.btn-submit');
        const originalText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.textContent = 'Mengirim...';

        // Kirim data via AJAX
        const formData = new FormData(form);

        fetch('process.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showResponseMessage(data.message, true);
                form.reset(); // Reset form jika berhasil
            } else {
                showResponseMessage(data.message, false);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showResponseMessage('Terjadi kesalahan saat mengirim data. Silakan coba lagi.', false);
        })
        .finally(() => {
            // Enable tombol submit kembali
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        });
    });

    // Real-time validation untuk email
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

    // Real-time validation untuk WhatsApp
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