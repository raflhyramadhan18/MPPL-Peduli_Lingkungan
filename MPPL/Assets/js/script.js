const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');
const toggleBtn = document.getElementById('sidebar-toggle');
const mainContent = document.getElementById('main-content');

function updateMainContentMargin(isClosed) {
    if (!mainContent) return;

    if (window.innerWidth >= 768) {
        mainContent.classList.toggle('md:ml-72', !isClosed);
        mainContent.classList.toggle('ml-0', isClosed);
    } else {
        mainContent.classList.remove('md:ml-72');
        mainContent.classList.add('ml-0');
    }
}

toggleBtn?.addEventListener('click', () => {
    const isClosed = sidebar.classList.toggle('sidebar-closed');

    sidebar.classList.toggle('sidebar-open', !isClosed);
    if (window.innerWidth < 768) {
        overlay?.classList.toggle('hidden', isClosed);
    }

    updateMainContentMargin(isClosed);
});


overlay?.addEventListener('click', () => {
    sidebar.classList.add('sidebar-closed');
    sidebar.classList.remove('sidebar-open');
    overlay?.classList.add('hidden');
    updateMainContentMargin(true);
});


window.addEventListener('resize', () => {
    if (window.innerWidth >= 768) {
        
        overlay?.classList.add('hidden');
        
        const isClosed = sidebar?.classList.contains('sidebar-closed') ?? false;
        updateMainContentMargin(isClosed);
    } else {
        sidebar?.classList.add('sidebar-closed');
        sidebar?.classList.remove('sidebar-open');
        overlay?.classList.add('hidden');
        updateMainContentMargin(true);
    }
});


function konfirmasiLogout() {
    const logoutBtn = document.getElementById("logout-btn");

    if (logoutBtn) {
        logoutBtn.addEventListener("click", (e) => {

            if (!confirm("Apakah Anda yakin ingin keluar (logout) dari akun Anda?")) {
                e.preventDefault(); 
            }
        });
    } else {
        console.warn("Element #logout-btn tidak ditemukan. Konfirmasi logout tidak aktif.");
    }
}



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


function inputAktif() {
    const inputs = document.querySelectorAll(".form-input input");
    if (!inputs.length) return;

    inputs.forEach(input => {
        function toggleActive() {
            input.parentElement.classList.toggle("active", input === document.activeElement || input.value);
        }
        input.addEventListener("focus", toggleActive);
        input.addEventListener("blur", toggleActive);
        toggleActive();
    });
}

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

function aktifkanScrollHalaman(offset = 80) {
    document.querySelectorAll('a[href^="#"]').forEach(tautan => {
        tautan.addEventListener('click', function (e) {
            e.preventDefault();

            const idTarget = this.getAttribute('href');
            if (idTarget === '#') return;

            const elemenTarget = document.querySelector(idTarget);
            if (elemenTarget) {
              
                window.scrollTo({
                    top: elemenTarget.offsetTop - offset,
                    behavior: 'smooth'
                });
            }
        });
    });
}


document.addEventListener('DOMContentLoaded', () => {
    if (sidebar) {
        const isClosed = sidebar.classList.contains('sidebar-closed') ?? false;
        updateMainContentMargin(isClosed);
    }

    konfirmasiLogout();
    setDailyTip();
    inputAktif(); 
    intiPassword(); 
    aktifkanScrollHalaman(); 
});