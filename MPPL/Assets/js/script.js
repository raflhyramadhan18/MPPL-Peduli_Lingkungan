// ===========================================
// BAGIAN SIDEBAR & RESPONSIVITAS
// ===========================================

const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');
const toggleBtn = document.getElementById('sidebar-toggle');
const mainContent = document.getElementById('main-content');

// Helper function untuk mengatur margin konten utama
function updateMainContentMargin(isClosed) {
    if (!mainContent) return; 

    // Desktop
    if (window.innerWidth >= 768) {
        // Jika tertutup, margin 0. Jika terbuka, margin 72 (18rem)
        mainContent.classList.toggle('md:ml-72', !isClosed);
        mainContent.classList.toggle('ml-0', isClosed);
    } else {
        // Mobile: Margin selalu 0
        mainContent.classList.remove('md:ml-72');
        mainContent.classList.add('ml-0');
    }
}

// Logika Toggle Sidebar
toggleBtn?.addEventListener('click', () => {
    // Toggle class sidebar-closed. isClosed akan TRUE jika sekarang ditutup.
    const isClosed = sidebar.classList.toggle('sidebar-closed'); 
    
    sidebar.classList.toggle('sidebar-open', !isClosed); // Update ke open/closed state
    
    if (window.innerWidth < 768) {
        // Mobile: tampilkan/sembunyikan overlay
        overlay?.classList.toggle('hidden', isClosed);
    }
    
    updateMainContentMargin(isClosed);
});

// Tutup sidebar jika overlay diklik (Mobile)
overlay?.addEventListener('click', () => {
    sidebar.classList.add('sidebar-closed');
    sidebar.classList.remove('sidebar-open');
    overlay?.classList.add('hidden');
    updateMainContentMargin(true);
});

// Responsivitas saat resize layar
window.addEventListener('resize', () => {
    // Di desktop, kita pastikan sidebar dan margin diatur berdasarkan state terakhir
    if (window.innerWidth >= 768) {
        overlay?.classList.add('hidden');
        // Gunakan state saat ini
        const isClosed = sidebar?.classList.contains('sidebar-closed') ?? false;
        updateMainContentMargin(isClosed); 
    } else {
        // Di mobile, pastikan margin selalu 0 dan overlay tertutup jika window resize
        sidebar?.classList.add('sidebar-closed');
        sidebar?.classList.remove('sidebar-open');
        overlay?.classList.add('hidden');
        updateMainContentMargin(true); 
    }
});

// ===========================================
// BAGIAN LOGOUT KONFIRMASI (FIXED)
// ===========================================

function konfirmasiLogout() {
    const logoutBtn = document.getElementById("logout-btn");
    // Cek ID yang benar ada di navmain.php
    if (logoutBtn) {
        // PENTING: e.preventDefault() memastikan link tidak langsung diakses
        logoutBtn.addEventListener("click", (e) => {
            if (!confirm("Apakah Anda yakin ingin keluar (logout) dari akun Anda?")) {
                e.preventDefault(); // Mencegah pindah ke logout.php
            }
        });
    } else {
        console.warn("Element #logout-btn tidak ditemukan. Konfirmasi logout tidak aktif.");
    }
}

// ===========================================
// FUNGSI LAIN
// ===========================================

const tips = [
  "Kurangi penggunaan plastik sekali pakai 🌱",
  "Hemat listrik dengan mematikan peralatan yang tidak dipakai ⚡",
  "Tanam pohon atau tanaman di halaman rumah 🌳",
  "Gunakan transportasi ramah lingkungan 🚲",
  "Daur ulang sampah rumah tangga ♻️",
  "Gunakan air dengan bijak 💧",
  "Kurangi penggunaan kendaraan pribadi, pilih jalan kaki atau transportasi umum 🚶‍♂️",
  "Ikut kegiatan bersih-bersih lingkungan 🧹"
];

function setDailyTip() {
  const tipElement = document.getElementById('daily-tips');
  const randomIndex = Math.floor(Math.random() * tips.length);
  if (tipElement) tipElement.textContent = tips[randomIndex];
}

// ===========================================
// INISIALISASI SAAT DOM SIAP
// ===========================================

document.addEventListener('DOMContentLoaded', () => {
    // 1. Inisialisasi Sidebar Margin Awal (agar tidak terjadi flicker)
    if (sidebar) {
      // Periksa apakah sidebar-closed ada, jika tidak, anggap terbuka
      const isClosed = sidebar.classList.contains('sidebar-closed'); 
      updateMainContentMargin(isClosed);
    }
    
    // 2. Inisialisasi Konfirmasi Logout
    konfirmasiLogout(); 
    
    // 3. Inisialisasi Tips Harian
    setDailyTip();
    
    // ... Fungsi lain yang Anda miliki ...
});