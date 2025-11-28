// ===== Sidebar Toggle =====
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');
const toggleBtn = document.getElementById('sidebar-toggle');
const content = document.getElementById('content'); // tambahin id ini di main container kamu

toggleBtn?.addEventListener('click', () => {
  sidebar.classList.toggle('sidebar-closed');
  sidebar.classList.toggle('sidebar-open');
  console.log('Sidebar toggled:', sidebar.classList);

  // kalau di desktop, konten ikut geser
  if (window.innerWidth >= 768) {
    if (sidebar.classList.contains('sidebar-closed')) {
      content.style.marginLeft = '0';
    } else {
      content.style.marginLeft = '18rem'; // sama kayak width sidebar kamu (72 * 0.25rem)
    }
  } else {
    // kalau di hp, munculin overlay
    overlay?.classList.toggle('hidden');
  }
});

overlay?.addEventListener('click', () => {
  sidebar.classList.add('sidebar-closed');
  sidebar.classList.remove('sidebar-open');
  overlay?.classList.add('hidden');
  content.style.marginLeft = '0';
});

// ===== Responsif kalau resize layar =====
window.addEventListener('resize', () => {
  if (window.innerWidth < 768) {
    content.style.marginLeft = '0';
  } else {
    if (!sidebar.classList.contains('sidebar-closed')) {
      content.style.marginLeft = '18rem';
    }
  }
});

// ===== Random Daily Tips =====
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
window.addEventListener('DOMContentLoaded', setDailyTip);

// ===== Logout Konfirmasi =====
const logoutBtn = document.getElementById("logout-btn");
logoutBtn?.addEventListener("click", (e) => {
  if (!confirm("Apakah Anda yakin ingin logout?")) e.preventDefault();
});

// ===== Login & Register: Label Aktif =====
function inputAktif() {
    const inputs = document.querySelectorAll(".form-input input");
    if (!inputs.length) return;

    inputs.forEach(input => {
        function toggleActive() {
            input.parentElement.classList.toggle("active", input === document.activeElement || input.value);
        }
        input.addEventListener("focus", toggleActive);
        input.addEventListener("blur", toggleActive);
    });
}
inputAktif();

// ===== Login & Register: Toggle Password =====
function intiPassword() {
    const iconKunci = document.querySelectorAll(".togglePassword");
    iconKunci.forEach(icon => {
        icon.addEventListener("click", () => {
            const input = icon.closest(".form-input")?.querySelector(".isi-password");
            if (!input) return;
            const isPassword = input.type === "password";
            input.type = isPassword ? "text" : "password";
            icon.textContent = isPassword ? "lock_open" : "lock";
        });
    });
}
intiPassword();


function aktifkanScrollHalaman(offset = 80) {
    document.querySelectorAll('a[href^="#"]').forEach(tautan => {
        tautan.addEventListener('click', function (e) {
            e.preventDefault();

            const idTarget = this.getAttribute('href');
            if(idTarget === '#') return;

            const elemenTarget = document.querySelector(idTarget);
            if(elemenTarget) {
                // Tutup navbar di versi mobile jika terbuka
                const tombolNavbar = document.querySelector('.navbar-toggler');
                const navbarCollapse = document.querySelector('.navbar-collapse');

                if(navbarCollapse && navbarCollapse.classList.contains('show')) {
                    tombolNavbar.click();
                }

                window.scrollTo({
                    top: elemenTarget.offsetTop - offset,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// Panggil function saat halaman selesai dimuat
document.addEventListener('DOMContentLoaded', () => {
    aktifkanScrollHalaman();
});
