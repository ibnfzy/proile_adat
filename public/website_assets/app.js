// ===== Combined JavaScript for Adat Nusantara Website =====
// This file merges all previously separate scripts into a single bundle.

// Toggle to switch between mock data and API data
// Set to true to enable API data fetching
const ENABLE_API = true;

// API and page endpoints
const baseUrlMeta = document.querySelector('meta[name="base-url"]');
const BASE_URL = normalizeBaseUrl(
  baseUrlMeta ? baseUrlMeta.getAttribute("content") : "/"
);

const API_ENDPOINTS = {
  artikel: joinWithBase("api/artikel"),
  galeri: joinWithBase("api/galeri"),
  informasi: joinWithBase("api/informasi"),
};

const PAGE_URLS = {
  home: BASE_URL,
  artikelList: joinWithBase("artikel"),
  artikelDetail: (id) =>
    `${joinWithBase("artikel/detail")}?id=${encodeId(id)}`,
  informasiList: joinWithBase("informasi"),
  informasiDetail: (id) =>
    `${joinWithBase("informasi/detail")}?id=${encodeId(id)}`,
};
// Simple in-memory caches to avoid repeated fetch calls
let artikelDataCache = null;
let galeriDataCache = null;
let informasiDataCache = null;

function normalizeBaseUrl(url) {
  if (!url) {
    return "/";
  }

  return url.endsWith("/") ? url : `${url}/`;
}

function joinWithBase(path = "") {
  if (!path) {
    return BASE_URL;
  }

  if (/^https?:\/\//i.test(path)) {
    return path;
  }

  return `${BASE_URL}${path.replace(/^\/+/, "")}`;
}

function encodeId(value) {
  if (value === null || typeof value === "undefined") {
    return "";
  }

  return encodeURIComponent(value);
}

// ===== Mock Data =====
const ARTIKEL_DATA = [
  {
    id: 1,
    title: "Upacara Rambu Solo: Tradisi Pemakaman Adat Toraja",
    excerpt:
      "Rambu Solo merupakan upacara pemakaman adat yang sangat sakral bagi masyarakat Toraja, termasuk di Kecamatan Nosu.",
    image: "https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=600",
    date: "2025-01-15",
    category: "adat",
    author: "Admin Nosu",
    content: `
            <p>Rambu Solo merupakan upacara pemakaman adat yang sangat sakral bagi masyarakat Toraja, termasuk di Kecamatan Nosu. Upacara ini mencerminkan penghormatan terakhir kepada leluhur dan merupakan bagian integral dari sistem kepercayaan Aluk To Dolo.</p>

            <h3>Makna Filosofis</h3>
            <p>Dalam kepercayaan masyarakat Toraja, kematian bukanlah akhir dari segalanya, melainkan perpindahan ke alam lain yang disebut Puya. Rambu Solo adalah upacara yang memfasilitasi perjalanan roh menuju Puya dengan penuh kehormatan.</p>

            <h3>Tahapan Upacara</h3>
            <p>Upacara Rambu Solo terdiri dari beberapa tahapan penting yang dilaksanakan dalam beberapa hari bahkan minggu. Dimulai dari persiapan, penyambutan tamu, hingga prosesi pemakaman yang diiringi berbagai ritual adat.</p>

            <h3>Nilai Sosial</h3>
            <p>Rambu Solo juga memiliki fungsi sosial yang kuat dalam memperkuat ikatan kekeluargaan dan solidaritas masyarakat. Seluruh keluarga besar berkumpul untuk menghormati yang telah pergi.</p>
        `,
  },
  {
    id: 2,
    title: "Kesenian Tradisional Ma'badong",
    excerpt:
      "Ma'badong adalah tarian dan nyanyian tradisional yang dilakukan dalam upacara adat dengan makna filosofis mendalam.",
    image: "https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=600",
    date: "2025-01-10",
    category: "budaya",
    author: "Admin Nosu",
    content: `
            <p>Ma'badong merupakan salah satu kesenian tradisional khas Toraja yang masih lestari hingga kini. Tarian ini dilakukan dalam lingkaran sambil menyanyikan syair-syair yang sarat makna.</p>

            <h3>Sejarah Ma'badong</h3>
            <p>Ma'badong telah ada sejak zaman nenek moyang dan menjadi bagian tak terpisahkan dari upacara adat, terutama dalam upacara pemakaman (Rambu Solo).</p>

            <h3>Gerakan dan Makna</h3>
            <p>Setiap gerakan dalam Ma'badong memiliki makna filosofis. Lingkaran melambangkan kesatuan dan kebersamaan, sementara gerakan tangan menggambarkan doa dan penghormatan.</p>

            <h3>Syair dan Lantunan</h3>
            <p>Syair yang dinyanyikan berisi tentang kisah kehidupan, nasihat leluhur, dan doa-doa untuk perjalanan roh ke alam baka.</p>
        `,
  },
  {
    id: 3,
    title: "Rumah Tongkonan: Arsitektur Khas Mamasa",
    excerpt:
      "Tongkonan adalah rumah adat yang menjadi simbol kebesaran keluarga dengan filosofi perjalanan hidup manusia.",
    image: "https://images.unsplash.com/photo-1582407947304-fd86f028f716?w=600",
    date: "2025-01-05",
    category: "budaya",
    author: "Admin Nosu",
    content: `
            <p>Tongkonan merupakan rumah adat khas Toraja yang memiliki bentuk atap melengkung menyerupai perahu. Rumah ini bukan sekadar tempat tinggal, tetapi simbol status sosial dan identitas keluarga.</p>

            <h3>Bentuk dan Filosofi</h3>
            <p>Bentuk atap yang melengkung menyerupai perahu melambangkan filosofi bahwa kehidupan adalah perjalanan, sebagaimana nenek moyang yang datang dengan perahu.</p>

            <h3>Ukiran dan Ornamen</h3>
            <p>Setiap ukiran pada Tongkonan memiliki makna tersendiri. Motif geometris dan simbolis menggambarkan berbagai aspek kehidupan dan kepercayaan masyarakat Toraja.</p>

            <h3>Fungsi Sosial</h3>
            <p>Tongkonan menjadi pusat kegiatan adat dan sosial keluarga besar. Setiap keputusan penting keluarga dimusyawarahkan di Tongkonan.</p>
        `,
  },
  {
    id: 4,
    title: "Upacara Rambu Tuka: Ritual Syukuran Kehidupan",
    excerpt:
      "Rambu Tuka adalah upacara adat yang dilaksanakan sebagai ungkapan syukur atas berkat dalam kehidupan.",
    image: "https://images.unsplash.com/photo-1533929736458-ca588d08c8be?w=600",
    date: "2024-12-28",
    category: "adat",
    author: "Admin Nosu",
    content: `
            <p>Berbeda dengan Rambu Solo yang berkaitan dengan kematian, Rambu Tuka adalah upacara yang merayakan kehidupan dan kesyukuran atas berkat yang diterima.</p>

            <h3>Jenis-jenis Rambu Tuka</h3>
            <p>Ada berbagai jenis Rambu Tuka seperti upacara panen, pernikahan, dan syukuran atas kelahiran. Setiap jenis memiliki tata cara yang berbeda namun tetap dalam koridor adat istiadat.</p>

            <h3>Prosesi Upacara</h3>
            <p>Prosesi Rambu Tuka diawali dengan pemberian sesaji kepada Puang Matua (Tuhan), dilanjutkan dengan pemotongan hewan dan pesta rakyat.</p>
        `,
  },
  {
    id: 5,
    title: "Sistem Kekerabatan Tongkonan dalam Masyarakat Nosu",
    excerpt:
      "Sistem kekerabatan berbasis Tongkonan masih menjadi pondasi struktur sosial di Kecamatan Nosu.",
    image: "https://images.unsplash.com/photo-1519817650390-35c2e43772fd?w=600",
    date: "2024-12-20",
    category: "sejarah",
    author: "Admin Nosu",
    content: `
            <p>Sistem kekerabatan di Kecamatan Nosu didasarkan pada Tongkonan sebagai pusat keluarga besar. Setiap individu memiliki ikatan dengan Tongkonan asal mereka.</p>

            <h3>Struktur Keluarga</h3>
            <p>Keluarga besar Toraja terikat dalam sistem bilateral yang mengakui garis keturunan dari kedua belah pihak orang tua.</p>

            <h3>Peran dalam Kehidupan</h3>
            <p>Tongkonan menentukan peran sosial, tanggung jawab adat, dan hak waris setiap anggota keluarga dalam masyarakat.</p>
        `,
  },
  {
    id: 6,
    title: "Tenun Tradisional Toraja: Warisan Leluhur",
    excerpt:
      "Seni menenun kain tradisional masih dilestarikan oleh masyarakat Nosu dengan motif-motif khas.",
    image: "https://images.unsplash.com/photo-1464207687429-7505649dae38?w=600",
    date: "2024-12-15",
    category: "budaya",
    author: "Admin Nosu",
    content: `
            <p>Tenun tradisional Toraja merupakan salah satu warisan budaya yang masih dilestarikan hingga kini. Setiap motif memiliki makna dan fungsi tertentu dalam upacara adat.</p>

            <h3>Motif dan Makna</h3>
            <p>Motif-motif seperti sekong kandaure (ayam berkokok), pa'tedong (kerbau), dan pa'barre allo (matahari) memiliki makna filosofis yang mendalam.</p>

            <h3>Proses Pembuatan</h3>
            <p>Proses menenun dilakukan secara tradisional menggunakan alat tenun kayu. Pewarnaan menggunakan bahan-bahan alami dari tumbuhan.</p>
        `,
  },
];

const GALERI_DATA = [
  {
    id: 1,
    title: "Upacara Adat Rambu Solo",
    image: "https://images.unsplash.com/photo-1533929736458-ca588d08c8be?w=600",
  },
  {
    id: 2,
    title: "Tarian Ma'badong",
    image: "https://images.unsplash.com/photo-1519817650390-35c2e43772fd?w=600",
  },
  {
    id: 3,
    title: "Rumah Tongkonan Traditional",
    image: "https://images.unsplash.com/photo-1464207687429-7505649dae38?w=600",
  },
  {
    id: 4,
    title: "Festival Budaya Nosu",
    image: "https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=600",
  },
];

const INFORMASI_DATA = [
  {
    id: 1,
    title: "Sejarah Kecamatan Nosu",
    icon: "📜",
    excerpt:
      "Perjalanan sejarah panjang Kecamatan Nosu dari masa ke masa sebagai bagian dari Kabupaten Mamasa.",
    image: "https://images.unsplash.com/photo-1461360370896-922624d12aa1?w=600",
    category: "sejarah",
    content: `
            <p>Kecamatan Nosu memiliki sejarah panjang yang erat kaitannya dengan perkembangan wilayah Mamasa. Wilayah ini telah dihuni sejak ratusan tahun yang lalu oleh masyarakat Toraja yang membawa sistem kepercayaan dan budaya mereka.</p>

            <h3>Masa Kerajaan</h3>
            <p>Pada masa lampau, wilayah Nosu berada di bawah pengaruh beberapa kerajaan lokal yang memiliki sistem pemerintahan adat yang kuat. Tongkonan menjadi pusat kekuasaan dan pengambilan keputusan.</p>

            <h3>Era Kolonial</h3>
            <p>Kedatangan pemerintah kolonial Belanda membawa perubahan signifikan dalam struktur pemerintahan, namun masyarakat Nosu tetap mempertahankan nilai-nilai adat istiadat mereka.</p>

            <h3>Perkembangan Modern</h3>
            <p>Setelah kemerdekaan, Nosu berkembang menjadi salah satu kecamatan di Kabupaten Mamasa yang tetap menjaga kearifan lokal di tengah modernisasi.</p>
        `,
  },
  {
    id: 2,
    title: "Budaya dan Tradisi",
    icon: "🎭",
    excerpt:
      "Keanekaragaman budaya dan tradisi yang masih lestari di tengah masyarakat Kecamatan Nosu.",
    image: "https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=600",
    category: "budaya",
    content: `
            <p>Budaya dan tradisi di Kecamatan Nosu sangat kaya dan beragam. Masyarakat masih menjaga dengan baik warisan leluhur yang telah diwariskan turun-temurun.</p>

            <h3>Upacara Adat</h3>
            <p>Berbagai upacara adat seperti Rambu Solo (upacara kematian) dan Rambu Tuka (upacara syukuran) masih dilaksanakan dengan khidmat mengikuti aturan adat yang telah ditetapkan nenek moyang.</p>

            <h3>Kesenian Tradisional</h3>
            <p>Kesenian tradisional seperti Ma'badong, Pa'gellu, dan berbagai tarian adat lainnya masih sering ditampilkan dalam berbagai acara adat maupun festival budaya.</p>

            <h3>Sistem Kepercayaan</h3>
            <p>Meskipun mayoritas masyarakat telah memeluk agama resmi, kepercayaan terhadap Aluk To Dolo masih memengaruhi praktik budaya dan adat istiadat.</p>
        `,
  },
  {
    id: 3,
    title: "Geografi dan Lingkungan",
    icon: "🏔️",
    excerpt:
      "Kondisi geografis dan lingkungan alam Kecamatan Nosu yang indah dan memukau.",
    image: "https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600",
    category: "lingkungan",
    content: `
            <p>Kecamatan Nosu terletak di wilayah pegunungan dengan ketinggian yang bervariasi. Kondisi geografis ini memberikan keindahan alam yang luar biasa serta udara yang sejuk dan segar.</p>

            <h3>Topografi</h3>
            <p>Wilayah Nosu didominasi oleh perbukitan dan pegunungan dengan lembah-lembah yang subur. Kondisi ini sangat cocok untuk pertanian dan perkebunan.</p>

            <h3>Iklim</h3>
            <p>Iklim tropis dengan curah hujan yang cukup tinggi membuat wilayah ini sangat hijau sepanjang tahun. Suhu udara berkisar antara 18-25 derajat Celsius.</p>

            <h3>Kekayaan Alam</h3>
            <p>Hutan-hutan di sekitar Nosu menyimpan keanekaragaman hayati yang tinggi dengan berbagai jenis flora dan fauna endemik Sulawesi.</p>
        `,
  },
  {
    id: 4,
    title: "Sistem Pemerintahan",
    icon: "🏛️",
    excerpt:
      "Struktur pemerintahan dan tata kelola Kecamatan Nosu dalam kerangka NKRI.",
    image: "https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=600",
    category: "pemerintahan",
    content: `
            <p>Kecamatan Nosu dipimpin oleh seorang Camat yang bertanggung jawab atas jalannya pemerintahan di wilayah tersebut. Struktur pemerintahan mengikuti sistem yang berlaku di Indonesia.</p>

            <h3>Struktur Organisasi</h3>
            <p>Pemerintahan kecamatan terdiri dari Camat, Sekretaris Kecamatan, dan beberapa Kepala Seksi yang membidangi berbagai urusan pemerintahan.</p>

            <h3>Desa-Desa di Nosu</h3>
            <p>Kecamatan Nosu terdiri dari beberapa desa yang masing-masing dipimpin oleh Kepala Desa. Setiap desa memiliki BPD (Badan Permusyawaratan Desa) sebagai mitra pemerintah desa.</p>

            <h3>Integrasi Adat dan Pemerintahan</h3>
            <p>Uniknya, sistem pemerintahan formal berjalan beriringan dengan sistem pemerintahan adat yang masih dihormati masyarakat.</p>
        `,
  },
  {
    id: 5,
    title: "Potensi Ekonomi",
    icon: "💰",
    excerpt:
      "Berbagai potensi ekonomi yang dapat dikembangkan untuk kesejahteraan masyarakat Nosu.",
    image: "https://images.unsplash.com/photo-1464207687429-7505649dae38?w=600",
    category: "ekonomi",
    content: `
            <p>Kecamatan Nosu memiliki berbagai potensi ekonomi yang dapat dikembangkan untuk meningkatkan kesejahteraan masyarakat.</p>

            <h3>Pertanian</h3>
            <p>Sektor pertanian menjadi tulang punggung ekonomi masyarakat dengan komoditas utama padi, kopi, kakao, dan sayur-sayuran.</p>

            <h3>Pariwisata</h3>
            <p>Keindahan alam dan kekayaan budaya menjadi modal besar untuk pengembangan sektor pariwisata yang berkelanjutan.</p>

            <h3>Kerajinan Tangan</h3>
            <p>Produk kerajinan tradisional seperti tenun, ukiran kayu, dan anyaman bambu memiliki nilai ekonomi yang tinggi.</p>
        `,
  },
  {
    id: 6,
    title: "Pendidikan dan Kesehatan",
    icon: "📚",
    excerpt:
      "Kondisi dan perkembangan sektor pendidikan dan kesehatan di Kecamatan Nosu.",
    image: "https://images.unsplash.com/photo-1519817650390-35c2e43772fd?w=600",
    category: "sosial",
    content: `
            <p>Pembangunan sektor pendidikan dan kesehatan terus ditingkatkan untuk meningkatkan kualitas hidup masyarakat Nosu.</p>

            <h3>Fasilitas Pendidikan</h3>
            <p>Kecamatan Nosu memiliki sejumlah sekolah dari tingkat SD hingga SMA yang tersebar di berbagai desa. Pemerintah terus berupaya meningkatkan kualitas pendidikan.</p>

            <h3>Layanan Kesehatan</h3>
            <p>Puskesmas dan posyandu tersedia untuk memberikan layanan kesehatan dasar kepada masyarakat. Program kesehatan preventif juga terus digalakkan.</p>

            <h3>Tantangan dan Harapan</h3>
            <p>Meski masih ada tantangan terkait akses dan kualitas, ada harapan besar untuk terus meningkatkan sektor pendidikan dan kesehatan.</p>
        `,
  },
];

// ===== Lightbox =====
let lightboxInstance = null;
let lastFocusedElement = null;

function initLightboxSystem() {
  if (lightboxInstance) {
    return lightboxInstance;
  }

  const overlay = document.createElement("div");
  overlay.className = "lightbox";
  overlay.id = "globalLightbox";
  overlay.setAttribute("role", "dialog");
  overlay.setAttribute("aria-modal", "true");
  overlay.setAttribute("aria-hidden", "true");

  overlay.innerHTML = `
        <div class="lightbox-content">
            <button class="lightbox-close" type="button" aria-label="Tutup gambar">&times;</button>
            <img src="" alt="" class="lightbox-image">
            <p class="lightbox-caption"></p>
        </div>
    `;

  document.body.appendChild(overlay);

  const image = overlay.querySelector(".lightbox-image");
  const caption = overlay.querySelector(".lightbox-caption");
  const closeButton = overlay.querySelector(".lightbox-close");

  function closeLightbox() {
    overlay.classList.remove("is-visible");
    overlay.setAttribute("aria-hidden", "true");
    document.body.classList.remove("lightbox-open");
    image.removeAttribute("src");
    caption.textContent = "";

    if (lastFocusedElement instanceof HTMLElement) {
      lastFocusedElement.focus();
      lastFocusedElement = null;
    }
  }

  function openLightbox(src, captionText) {
    lastFocusedElement = document.activeElement;
    image.src = src;
    image.alt = captionText || "";
    caption.textContent = captionText || "";
    overlay.classList.add("is-visible");
    overlay.setAttribute("aria-hidden", "false");
    document.body.classList.add("lightbox-open");
    closeButton.focus();
  }

  closeButton.addEventListener("click", closeLightbox);

  overlay.addEventListener("click", (event) => {
    if (event.target === overlay) {
      closeLightbox();
    }
  });

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape" && overlay.classList.contains("is-visible")) {
      closeLightbox();
    }
  });

  lightboxInstance = {
    open: openLightbox,
    close: closeLightbox,
    overlay,
    image,
    caption,
  };

  return lightboxInstance;
}

function attachLightboxToImages(scope = document) {
  const instance = initLightboxSystem();
  const images = scope.querySelectorAll("img:not([data-lightbox-disabled])");

  images.forEach((img) => {
    if (img.dataset.lightboxBound === "true") {
      return;
    }

    img.dataset.lightboxBound = "true";
    img.classList.add("has-lightbox");

    if (!img.hasAttribute("tabindex")) {
      img.setAttribute("tabindex", "0");
    }

    const getCaption = () => img.getAttribute("data-caption") || img.alt || "";
    const getSource = () => img.currentSrc || img.src;

    img.addEventListener("click", () => {
      instance.open(getSource(), getCaption());
    });

    img.addEventListener("keydown", (event) => {
      if (event.key === "Enter" || event.key === " ") {
        event.preventDefault();
        instance.open(getSource(), getCaption());
      }
    });
  });
}

// ===== Helper Functions =====
function getCategoryName(category) {
  const categories = {
    adat: "Adat Istiadat",
    budaya: "Budaya",
    sejarah: "Sejarah",
  };
  return categories[category] || category;
}

function formatDate(dateString) {
  const options = { year: "numeric", month: "long", day: "numeric" };
  return new Date(dateString).toLocaleDateString("id-ID", options);
}

function getArtikelIdFromUrl() {
  const params = new URLSearchParams(window.location.search);
  return Number.parseInt(params.get("id"), 10);
}

function getInformasiIdFromUrl() {
  const params = new URLSearchParams(window.location.search);
  return Number.parseInt(params.get("id"), 10);
}

async function fetchArtikelData() {
  if (!ENABLE_API) {
    return ARTIKEL_DATA;
  }

  if (artikelDataCache) {
    return artikelDataCache;
  }

  const response = await fetch(API_ENDPOINTS.artikel);
  if (!response.ok) {
    throw new Error(`Gagal mengambil data artikel: ${response.status}`);
  }

  const data = await response.json();
  artikelDataCache = data;
  return data;
}

async function fetchGaleriData() {
  if (!ENABLE_API) {
    return GALERI_DATA;
  }

  if (galeriDataCache) {
    return galeriDataCache;
  }

  const response = await fetch(API_ENDPOINTS.galeri);
  if (!response.ok) {
    throw new Error(`Gagal mengambil data galeri: ${response.status}`);
  }

  const data = await response.json();
  galeriDataCache = data;
  return data;
}

async function fetchInformasiData() {
  if (!ENABLE_API) {
    return INFORMASI_DATA;
  }

  if (informasiDataCache) {
    return informasiDataCache;
  }

  const response = await fetch(API_ENDPOINTS.informasi);
  if (!response.ok) {
    throw new Error(`Gagal mengambil data informasi: ${response.status}`);
  }

  const data = await response.json();
  informasiDataCache = data;
  return data;
}

// ===== Navigation =====
function initNavigation(isHomePage) {
  const header = document.getElementById("header");
  const mobileMenuToggle = document.getElementById("mobileMenuToggle");
  const nav = document.getElementById("nav");
  const navLinks = document.querySelectorAll(".nav-link");

  if (!header) {
    return;
  }

  window.addEventListener("scroll", () => {
    if (window.scrollY > 100) {
      header.style.backgroundColor = "rgba(45, 80, 22, 0.98)";
    } else {
      header.style.backgroundColor = "rgba(45, 80, 22, 0.95)";
    }
  });

  if (mobileMenuToggle && nav) {
    mobileMenuToggle.addEventListener("click", () => {
      nav.classList.toggle("active");

      const spans = mobileMenuToggle.querySelectorAll("span");
      if (nav.classList.contains("active")) {
        spans[0].style.transform = "rotate(45deg) translate(5px, 5px)";
        spans[1].style.opacity = "0";
        spans[2].style.transform = "rotate(-45deg) translate(7px, -6px)";
      } else {
        spans[0].style.transform = "none";
        spans[1].style.opacity = "1";
        spans[2].style.transform = "none";
      }
    });

    document.addEventListener("click", (event) => {
      if (
        !nav.contains(event.target) &&
        !mobileMenuToggle.contains(event.target) &&
        nav.classList.contains("active")
      ) {
        nav.classList.remove("active");
        const spans = mobileMenuToggle.querySelectorAll("span");
        spans[0].style.transform = "none";
        spans[1].style.opacity = "1";
        spans[2].style.transform = "none";
      }
    });
  }

  navLinks.forEach((link) => {
    const scrollTarget = link.dataset.scrollTarget;

    if (isHomePage && scrollTarget) {
      link.addEventListener("click", (event) => {
        event.preventDefault();
        const targetSection = document.querySelector(scrollTarget);

        if (!targetSection) {
          return;
        }

        const targetPosition = targetSection.offsetTop - header.offsetHeight;

        window.scrollTo({
          top: targetPosition,
          behavior: "smooth",
        });

        navLinks.forEach((navLink) => {
          if (navLink.dataset.scrollTarget) {
            navLink.classList.remove("active");
          }
        });
        link.classList.add("active");

        if (nav) {
          nav.classList.remove("active");
        }

        if (mobileMenuToggle) {
          const spans = mobileMenuToggle.querySelectorAll("span");
          spans[0].style.transform = "none";
          spans[1].style.opacity = "1";
          spans[2].style.transform = "none";
        }
      });
    }
  });

  if (isHomePage) {
    window.addEventListener("scroll", () => {
      const sections = document.querySelectorAll("section[id]");
      let currentSection = "";

      sections.forEach((section) => {
        const sectionTop = section.offsetTop;
        if (window.scrollY >= sectionTop - header.offsetHeight - 100) {
          currentSection = section.getAttribute("id") || "";
        }
      });

      navLinks.forEach((link) => {
        const scrollTarget = link.dataset.scrollTarget;
        if (!scrollTarget) {
          return;
        }

        const normalizedTarget = scrollTarget.replace(/^#/, "");

        link.classList.toggle(
          "active",
          normalizedTarget === currentSection
        );
      });
    });
  }
}

// ===== Home Page =====
async function initHomePage() {
  const heroSection = document.getElementById("home");
  if (!heroSection) {
    return;
  }

  const artikelGrid = document.getElementById("artikelGrid");
  const galeriGrid = document.getElementById("galeriGrid");

  if (artikelGrid) {
    try {
      const artikelData = await fetchArtikelData();
      artikelGrid.innerHTML = "";

      artikelData.slice(0, 3).forEach((artikel) => {
        const card = document.createElement("div");
        card.className = "artikel-card";
        card.innerHTML = `
                    <img src="${artikel.image}" alt="${artikel.title}" class="artikel-image">
                    <div class="artikel-content">
                        <h3 class="artikel-title">${artikel.title}</h3>
                        <p class="artikel-excerpt">${artikel.excerpt}</p>
                        <a href="${PAGE_URLS.artikelDetail(artikel.id)}" class="artikel-link">
                            Baca Selengkapnya →
                        </a>
                    </div>
                `;
        artikelGrid.appendChild(card);
        attachLightboxToImages(card);
      });
    } catch (error) {
      console.error("Error loading artikel:", error);
      artikelGrid.innerHTML =
        '<p style="text-align: center; color: #999;">Gagal memuat artikel</p>';
    }
  }

  if (galeriGrid) {
    try {
      const galeriData = await fetchGaleriData();
      galeriGrid.innerHTML = "";

      galeriData.forEach((item) => {
        const galeriItem = document.createElement("div");
        galeriItem.className = "galeri-item";
        galeriItem.innerHTML = `
                    <img src="${item.image}" alt="${item.title}" class="galeri-image">
                    <div class="galeri-overlay">
                        <h4 class="galeri-title">${item.title}</h4>
                    </div>
                `;
        galeriGrid.appendChild(galeriItem);
        attachLightboxToImages(galeriItem);
      });
    } catch (error) {
      console.error("Error loading galeri:", error);
      galeriGrid.innerHTML =
        '<p style="text-align: center; color: #999;">Gagal memuat galeri</p>';
    }
  }
}

// ===== Informasi List Page =====
async function initInformasiPage() {
  const informasiSection = document.querySelector(".informasi-page");
  if (!informasiSection) {
    return;
  }

  const informasiGrid = document.getElementById("informasiGrid");
  if (!informasiGrid) {
    return;
  }

  informasiGrid.innerHTML = "";

  try {
    const informasiData = await fetchInformasiData();

    if (!informasiData || informasiData.length === 0) {
      informasiGrid.innerHTML =
        '<p style="text-align: center; color: #999;">Belum ada informasi yang tersedia</p>';
      return;
    }

    informasiData.forEach((info) => {
      const card = document.createElement("div");
      card.className = "informasi-card";
      card.innerHTML = `
                <div class="informasi-icon">${info.icon || ""}</div>
                <img src="${info.image}" alt="${
        info.title
      }" class="informasi-image">
                <div class="informasi-content">
                    <h3 class="informasi-title">${info.title}</h3>
                    <p class="informasi-excerpt">${info.excerpt}</p>
                    <a href="${PAGE_URLS.informasiDetail(info.id)}" class="informasi-link">
                        Lihat Detail →
                    </a>
                </div>
            `;
      informasiGrid.appendChild(card);
      attachLightboxToImages(card);
    });
  } catch (error) {
    console.error("Error loading informasi:", error);
    informasiGrid.innerHTML =
      '<p style="text-align: center; color: #999;">Gagal memuat informasi</p>';
  }
}

// ===== Informasi Detail Page =====
async function initInformasiDetailPage() {
  const detailContainer = document.getElementById("informasiDetail");
  if (!detailContainer) {
    return;
  }

  const informasiId = getInformasiIdFromUrl();
  try {
    const informasiData = await fetchInformasiData();
    const informasi = informasiData.find((item) => item.id === informasiId);

    if (!informasi) {
      detailContainer.innerHTML = "<p>Informasi tidak ditemukan</p>";
      return;
    }

    const breadcrumbTitle = document.getElementById("breadcrumbTitle");
    if (breadcrumbTitle) {
      breadcrumbTitle.textContent = informasi.title;
    }

    detailContainer.innerHTML = `
            <div class="informasi-header">
                <div class="info-icon-large">${informasi.icon || ""}</div>
                <h1>${informasi.title}</h1>
            </div>
            <img src="${informasi.image}" alt="${
      informasi.title
    }" class="informasi-featured-image">
            <div class="informasi-body">
                ${informasi.content}
            </div>
            <div class="back-link">
                <a href="${PAGE_URLS.informasiList}" class="btn btn-primary">← Kembali ke Informasi</a>
            </div>
        `;

    attachLightboxToImages(detailContainer);
  } catch (error) {
    console.error("Error loading informasi detail:", error);
    detailContainer.innerHTML = "<p>Gagal memuat informasi</p>";
  }
}

// ===== Artikel List Page =====
async function initArtikelPage() {
  const artikelSection = document.querySelector(".artikel-page");
  if (!artikelSection) {
    return;
  }

  const artikelGrid = document.getElementById("artikelGrid");
  const searchInput = document.getElementById("searchInput");
  const filterButtons = document.querySelectorAll(".filter-btn");

  if (!artikelGrid || !searchInput || filterButtons.length === 0) {
    return;
  }

  let currentFilter = "all";
  let currentSearch = "";
  let artikelData = [];

  function renderArtikelList(data) {
    artikelGrid.innerHTML = "";

    if (data.length === 0) {
      artikelGrid.innerHTML =
        '<p style="text-align: center; color: #999; grid-column: 1/-1;">Tidak ada artikel ditemukan</p>';
      return;
    }

    data.forEach((artikel) => {
      const card = document.createElement("div");
      card.className = "artikel-card";
      card.innerHTML = `
                <img src="${artikel.image}" alt="${
        artikel.title
      }" class="artikel-image">
                <div class="artikel-content">
                    <span class="artikel-category">${getCategoryName(
                      artikel.category
                    )}</span>
                    <h3 class="artikel-title">${artikel.title}</h3>
                    <p class="artikel-excerpt">${artikel.excerpt}</p>
                    <div class="artikel-meta">
                        <span class="artikel-date">${formatDate(
                          artikel.date
                        )}</span>
                        <a href="${PAGE_URLS.artikelDetail(artikel.id)}" class="artikel-link">
                            Baca Selengkapnya →
                        </a>
                    </div>
                </div>
            `;
      artikelGrid.appendChild(card);
      attachLightboxToImages(card);
    });
  }

  function filterArtikel() {
    let filtered = artikelData;

    if (currentFilter !== "all") {
      filtered = filtered.filter(
        (artikel) => artikel.category === currentFilter
      );
    }

    if (currentSearch) {
      const keyword = currentSearch.toLowerCase();
      filtered = filtered.filter(
        (artikel) =>
          artikel.title.toLowerCase().includes(keyword) ||
          artikel.excerpt.toLowerCase().includes(keyword)
      );
    }

    renderArtikelList(filtered);
  }

  filterButtons.forEach((button) => {
    button.addEventListener("click", () => {
      filterButtons.forEach((btn) => btn.classList.remove("active"));
      button.classList.add("active");
      currentFilter = button.dataset.category || "all";
      filterArtikel();
    });
  });

  searchInput.addEventListener("input", (event) => {
    currentSearch = event.target.value;
    filterArtikel();
  });

  try {
    artikelData = await fetchArtikelData();
    renderArtikelList(artikelData);
  } catch (error) {
    console.error("Error loading artikel list:", error);
    artikelGrid.innerHTML =
      '<p style="text-align: center; color: #999; grid-column: 1/-1;">Gagal memuat artikel</p>';
  }
}

// ===== Artikel Detail Page =====
async function initArtikelDetailPage() {
  const detailContainer = document.getElementById("artikelDetail");
  if (!detailContainer) {
    return;
  }

  const artikelId = getArtikelIdFromUrl();
  try {
    const artikelData = await fetchArtikelData();
    const artikel = artikelData.find((item) => item.id === artikelId);

    if (!artikel) {
      detailContainer.innerHTML = "<p>Artikel tidak ditemukan</p>";
      return;
    }

    const breadcrumbTitle = document.getElementById("breadcrumbTitle");
    if (breadcrumbTitle) {
      breadcrumbTitle.textContent = artikel.title;
    }

    detailContainer.innerHTML = `
            <div class="artikel-header">
                <span class="artikel-category">${getCategoryName(
                  artikel.category
                )}</span>
                <h1>${artikel.title}</h1>
                <div class="artikel-meta">
                    <span class="meta-item">📅 ${formatDate(
                      artikel.date
                    )}</span>
                    <span class="meta-item">✍️ ${artikel.author}</span>
                </div>
            </div>
            <img src="${artikel.image}" alt="${
      artikel.title
    }" class="artikel-featured-image">
            <div class="artikel-body">
                ${artikel.content}
            </div>
            <div class="artikel-share">
                <h4>Bagikan Artikel:</h4>
                <div class="share-buttons">
                    <button class="share-btn" onclick="shareToFacebook()">Facebook</button>
                    <button class="share-btn" onclick="shareToTwitter()">Twitter</button>
                    <button class="share-btn" onclick="shareToWhatsApp()">WhatsApp</button>
                </div>
            </div>
        `;

    renderRelatedArtikel(artikel, artikelData);
    attachLightboxToImages(detailContainer);
  } catch (error) {
    console.error("Error loading artikel detail:", error);
    detailContainer.innerHTML = "<p>Gagal memuat artikel</p>";
  }
}

function renderRelatedArtikel(currentArtikel, artikelData = []) {
  const relatedGrid = document.getElementById("relatedGrid");
  if (!relatedGrid) {
    return;
  }

  const relatedArtikel = artikelData
    .filter(
      (artikel) =>
        artikel.category === currentArtikel.category &&
        artikel.id !== currentArtikel.id
    )
    .slice(0, 3);

  if (relatedArtikel.length === 0) {
    relatedGrid.innerHTML = "<p>Tidak ada artikel terkait</p>";
    return;
  }

  relatedGrid.innerHTML = "";

  relatedArtikel.forEach((artikel) => {
    const card = document.createElement("div");
    card.className = "artikel-card";
    card.innerHTML = `
            <img src="${artikel.image}" alt="${artikel.title}" class="artikel-image">
            <div class="artikel-content">
                <h3 class="artikel-title">${artikel.title}</h3>
                <p class="artikel-excerpt">${artikel.excerpt}</p>
                <a href="${PAGE_URLS.artikelDetail(artikel.id)}" class="artikel-link">
                    Baca Selengkapnya →
                </a>
            </div>
        `;
    relatedGrid.appendChild(card);
    attachLightboxToImages(card);
  });
}

// ===== Share Functions (Global) =====
function shareToFacebook() {
  const url = encodeURIComponent(window.location.href);
  window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, "_blank");
}

function shareToTwitter() {
  const url = encodeURIComponent(window.location.href);
  const text = encodeURIComponent(
    document.querySelector("h1")?.textContent || ""
  );
  window.open(
    `https://twitter.com/intent/tweet?url=${url}&text=${text}`,
    "_blank"
  );
}

function shareToWhatsApp() {
  const url = encodeURIComponent(window.location.href);
  const text = encodeURIComponent(
    document.querySelector("h1")?.textContent || ""
  );
  window.open(`https://wa.me/?text=${text} ${url}`, "_blank");
}

// ===== Initialize All Pages =====
document.addEventListener("DOMContentLoaded", () => {
  const isHomePage = Boolean(document.getElementById("home"));

  initNavigation(isHomePage);
  initHomePage();
  initInformasiPage();
  initInformasiDetailPage();
  initArtikelPage();
  initArtikelDetailPage();
  initLightboxSystem();
  attachLightboxToImages(document);
});

// Catatan: Data akan dimuat dari API backend ketika ENABLE_API bernilai true.
