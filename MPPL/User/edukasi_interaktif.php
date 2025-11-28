<?php
// Pastikan user sudah login
require '../Akses/auth_check.php';
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edukasi Interaktif - Peduli Lingkungan</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
<style>
/* CSS dari dashboard_user.php */
#sidebar { transition: transform 0.3s ease; }
.sidebar-open { transform: translateX(0) !important; }
.sidebar-closed { transform: translateX(-18rem) !important; }
@media (max-width: 767px) {
    .sidebar-open { transform: translateX(-18rem) !important; }
    #sidebar.sidebar-open { transform: translateX(0) !important; }
}
@media (min-width: 768px) {
    .sidebar-closed { transform: translateX(-18rem) !important; }
    #sidebar.sidebar-open { transform: translateX(0) !important; }
}

body {
  background-image: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1920&q=80');
  background-size: cover;
  background-position: center;
}
.backdrop-card {
  background-color: rgba(255,255,255,0.7);
  backdrop-filter: blur(10px);
}
</style>
</head>

<body class="min-h-screen flex pt-16 text-gray-800">

<div id="overlay" class="fixed inset-0 bg-black/50 hidden z-10 md:hidden"></div>

<?php include '../Navigasi/navmain.php'; ?>

<?php include '../Navigasi/navbar.php'; ?>

<main id="main-content" class="flex-1 p-10 ml-0 md:ml-72 transition-all duration-300">
  
  <h2 class="text-4xl font-bold text-green-800 mb-8">Kamus Sampah Interaktif ♻️</h2>
  
  <div class="backdrop-card p-8 rounded-2xl shadow-xl w-full max-w-2xl mx-auto">
    
    <p class="text-gray-700 mb-6">
        Cari tahu jenis sampah dan cara pengelolaan yang tepat untuk setiap barang!
    </p>

    <form id="search-form" class="flex gap-3 mb-8">
      <input type="text" id="keyword" placeholder="Contoh: botol plastik, bungkus snack"
        class="flex-1 px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:outline-none" required>
      <button type="submit"
        class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 flex items-center gap-2">
        <span class="material-symbols-outlined">search</span> Cari
      </button>
    </form>

    <div id="result-area" class="mt-8 hidden">
        <h3 class="text-2xl font-bold text-green-700 mb-4">Hasil Pencarian: <span id="item-name" class="italic font-normal text-gray-800"></span></h3>

        <div class="space-y-4">
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                <p class="font-semibold text-blue-700">Jenis:</p>
                <p class="text-xl font-bold text-blue-900" id="type-result"></p>
            </div>

            <div class="bg-green-50 border-l-4 border-green-500 p-4">
                <p class="font-semibold text-green-700">Cara Pengelolaan:</p>
                <ul class="list-disc list-inside mt-2 text-gray-700" id="steps-result">
                    </ul>
            </div>
        </div>
    </div>
    
  </div>

</main>

<script src="../Assets/js/script.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('search-form');
    const keywordInput = document.getElementById('keyword');
    const resultArea = document.getElementById('result-area');
    const itemName = document.getElementById('item-name');
    const typeResult = document.getElementById('type-result');
    const stepsResult = document.getElementById('steps-result');

    // --- DATA SIMULASI KAMUS SAMPAH (DIPERLUAS) ---
    const dictionary = {
        "botol plastik": {
            type: "Anorganik (Plastik PET)",
            steps: ["Keluarkan sisa minuman.", "Cuci botol hingga bersih.", "Tekan/lipat botol agar pipih.", "Buang ke tempat sampah plastik atau Bank Sampah terdekat."],
        },
        "kardus pizza": {
            type: "Organik (Terkontaminasi Minyak)",
            steps: ["Robek bagian yang terkena minyak dan buang ke sampah organik.", "Daur ulang bagian yang bersih (kertas/kardus).", "Jangan daur ulang jika berminyak/basah sepenuhnya."],
        },
        "baterai bekas": {
            type: "B3 (Bahan Berbahaya & Beracun)",
            steps: ["Kumpulkan baterai di wadah tertutup.", "Jangan dibuang ke tempat sampah biasa.", "Bawa ke pusat pengumpulan limbah B3 (kantor pemerintahan atau pusat daur ulang besar)."],
        },
        "sisa makanan": {
            type: "Organik",
            steps: ["Pastikan tidak tercampur bahan anorganik (plastik).", "Olah menjadi kompos rumahan (pupuk).", "Jika tidak bisa kompos, buang ke tempat sampah organik."],
        },
        "kertas HVS": {
            type: "Anorganik (Kertas/Karton)",
            steps: ["Pastikan bersih dari noda dan minyak.", "Kumpulkan dan ikat.", "Bawa ke Bank Sampah atau pemulung."],
        },
        "kemasan sachet": {
            type: "Anorganik (Multi-layer Plastik/Alumunium)",
            steps: ["Bersihkan sisa isi sachet.", "Kumpulkan dalam jumlah banyak (ecobrick).", "Sangat sulit didaur ulang, hindari penggunaannya sebisa mungkin."],
        },
        "lampu bohlam": {
            type: "B3 (Mengandung Mercury/Logam Berat)",
            steps: ["Jangan pecahkan.", "Kumpulkan secara terpisah di wadah aman.", "Kirim ke fasilitas daur ulang B3 atau drop-off khusus."],
        },
        "minyak jelantah": {
            type: "Organik (Limbah Cair B3 jika dibuang ke saluran air)",
            steps: ["Saring dan dinginkan.", "Kumpulkan dalam botol tertutup.", "Tukarkan ke Bank Sampah yang menerima minyak jelantah, bisa diolah jadi biodiesel atau sabun."],
        },
        "botol kaca": {
            type: "Anorganik (Kaca)",
            steps: ["Cuci bersih untuk menghilangkan residu.", "Lepaskan label.", "Buang ke tempat sampah kaca terpisah, karena kaca dapat didaur ulang 100%."],
        },
        "kaleng minuman": {
            type: "Anorganik (Alumunium/Logam)",
            steps: ["Cuci bersih dan keringkan.", "Tekan hingga pipih untuk menghemat ruang.", "Kumpulkan dan jual ke Bank Sampah atau pemulung."],
        },
    };
    // --- AKHIR DATA SIMULASI KAMUS SAMPAH ---

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const keyword = keywordInput.value.toLowerCase().trim();
        // Normalisasi input agar mudah dicari (misalnya: "botol" -> "botol plastik")
        let result = dictionary[keyword];
        
        // Cek jika keyword hanya sebagian dari nama
        if (!result) {
            for (const key in dictionary) {
                if (key.includes(keyword)) {
                    result = dictionary[key];
                    break;
                }
            }
        }


        itemName.textContent = `"${keyword}"`;
        stepsResult.innerHTML = ''; 

        if (result) {
            typeResult.textContent = result.type;
            result.steps.forEach(step => {
                const li = document.createElement('li');
                li.textContent = step;
                stepsResult.appendChild(li);
            });
            resultArea.classList.remove('hidden');
        } else {
            typeResult.textContent = 'Tidak Ditemukan';
            stepsResult.innerHTML = '<li>Maaf, item yang Anda cari tidak ada dalam database kami. Coba cari dengan kata kunci yang lebih umum.</li>';
            resultArea.classList.remove('hidden');
        }
    });
});
</script>

</body>
</html>