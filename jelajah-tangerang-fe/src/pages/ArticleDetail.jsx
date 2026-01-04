import React, { useEffect } from "react";
import { useParams, Link } from "react-router-dom";
import Navbar from "../components/Navbar";
import Footer from "../components/Footer";
import { articles } from "../data/mockData";
import {
  Calendar,
  User,
  ArrowLeft,
  Share2,
  Tag,
  ArrowRight,
} from "lucide-react";

const ArticleDetail = () => {
  const { id } = useParams();

  // Cari artikel berdasarkan ID
  const article = articles.find((item) => item.id === parseInt(id));

  // Mock Data untuk Sidebar (Ambil 4 artikel pertama sebagai 'Trending')
  const trendingArticles = articles.slice(0, 4);

  // Scroll ke atas saat pindah artikel
  useEffect(() => {
    window.scrollTo(0, 0);
  }, [id]);

  if (!article) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-white dark:bg-gray-900 text-gray-900 dark:text-white font-sans">
        <div className="text-center">
          <h2 className="text-2xl font-bold mb-4">Artikel Tidak Ditemukan</h2>
          <Link to="/artikel" className="text-primary hover:underline">
            Kembali ke Indeks
          </Link>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-sans transition-colors duration-300">
      <Navbar toggleSidebar={() => {}} />

      <main className="pt-24 pb-12">
        {/* Breadcrumb */}
        <div className="container mx-auto px-4 mb-8">
          <Link
            to="/artikel"
            className="inline-flex items-center gap-2 text-gray-500 hover:text-primary transition-colors mb-4 text-sm font-medium"
          >
            <ArrowLeft size={16} /> Kembali ke Indeks
          </Link>
          <div className="flex flex-wrap gap-2 text-sm text-gray-500 items-center">
            <Link to="/" className="hover:text-primary">
              Beranda
            </Link>
            <span>/</span>
            <Link to="/artikel" className="hover:text-primary">
              Artikel
            </Link>
            <span>/</span>
            <span className="text-gray-900 dark:text-white font-medium truncate max-w-[200px]">
              {article.title}
            </span>
          </div>
        </div>

        <div className="container mx-auto px-4">
          <div className="grid grid-cols-1 lg:grid-cols-12 gap-12">
            {/* === KOLOM UTAMA (Konten Artikel) === */}
            <div className="lg:col-span-8">
              {/* Header Artikel */}
              <div className="mb-8">
                <span className="inline-block px-3 py-1 bg-blue-50 text-primary dark:bg-blue-900/30 dark:text-blue-300 rounded-full text-xs font-bold uppercase tracking-wider mb-4">
                  {article.category}
                </span>
                <h1 className="text-3xl md:text-5xl font-extrabold leading-tight mb-6 text-gray-900 dark:text-white">
                  {article.title}
                </h1>

                <div className="flex items-center gap-6 text-gray-500 dark:text-gray-400 text-sm border-b border-gray-100 dark:border-gray-800 pb-6">
                  <div className="flex items-center gap-2">
                    <div className="w-8 h-8 rounded-full bg-gray-200 overflow-hidden">
                      <img
                        src={`https://ui-avatars.com/api/?name=${article.author}&background=random`}
                        alt={article.author}
                      />
                    </div>
                    <span className="font-semibold text-gray-900 dark:text-white">
                      {article.author || "Redaksi"}
                    </span>
                  </div>
                  <div className="flex items-center gap-2">
                    <Calendar size={16} />
                    <span>{article.date}</span>
                  </div>
                </div>
              </div>

              {/* Gambar Utama */}
              <div className="mb-10 rounded-2xl overflow-hidden shadow-xl aspect-video">
                <img
                  src={article.image}
                  alt={article.title}
                  className="w-full h-full object-cover"
                />
              </div>

              {/* Isi Konten (Rich Text Simulation) */}
              <article
                className="prose prose-lg prose-blue dark:prose-invert max-w-none leading-relaxed text-gray-700 dark:text-gray-300"
                dangerouslySetInnerHTML={{
                  __html: article.fullContent || `<p>${article.summary}</p>`,
                }}
              />

              {/* Tags & Share */}
              <div className="mt-12 pt-8 border-t border-gray-100 dark:border-gray-800 flex flex-col sm:flex-row justify-between items-center gap-6">
                <div className="flex items-center gap-2">
                  <Tag size={18} className="text-gray-400" />
                  <span className="text-sm font-semibold text-gray-900 dark:text-white">
                    Tags:
                  </span>
                  <div className="flex gap-2">
                    <span className="text-xs bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded-full text-gray-600 dark:text-gray-300 hover:bg-gray-200 cursor-pointer transition">
                      Wisata
                    </span>
                    <span className="text-xs bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded-full text-gray-600 dark:text-gray-300 hover:bg-gray-200 cursor-pointer transition">
                      Tangerang
                    </span>
                  </div>
                </div>
                <button className="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-primary transition font-medium">
                  <Share2 size={18} /> Bagikan
                </button>
              </div>

              <div className="mt-12 pt-10 border-t border-gray-100 dark:border-gray-800">
                <h3 className="text-xl font-bold mb-6 text-gray-900 dark:text-white">
                  Diskusi Pembaca (2)
                </h3>

                {/* Form Komentar */}
                <div className="flex gap-4 mb-10">
                  <div className="w-10 h-10 rounded-full bg-gray-200 overflow-hidden shrink-0">
                    <img
                      src="https://ui-avatars.com/api/?name=Guest&background=random"
                      alt="Guest"
                    />
                  </div>
                  <div className="flex-grow">
                    <textarea
                      placeholder="Tulis tanggapan Anda..."
                      className="w-full p-4 rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-primary/50 min-h-[100px] text-gray-900 dark:text-white placeholder-gray-400"
                    ></textarea>
                    <div className="mt-2 flex justify-end">
                      <button className="px-6 py-2 bg-primary text-white font-bold rounded-lg hover:bg-blue-700 transition shadow-lg shadow-blue-500/20">
                        Kirim Komentar
                      </button>
                    </div>
                  </div>
                </div>

                {/* List Komentar Dummy */}
                <div className="space-y-8">
                  {/* Komentar 1 */}
                  <div className="flex gap-4">
                    <div className="w-10 h-10 rounded-full bg-gray-200 overflow-hidden shrink-0">
                      <img
                        src="https://ui-avatars.com/api/?name=Andi+P&background=random"
                        alt="User"
                      />
                    </div>
                    <div>
                      <div className="flex items-center gap-2 mb-1">
                        <span className="font-bold text-gray-900 dark:text-white">
                          Andi Pratama
                        </span>
                        <span className="text-xs text-gray-400">
                          • 2 jam yang lalu
                        </span>
                      </div>
                      <p className="text-gray-600 dark:text-gray-300 text-sm leading-relaxed">
                        Wah, baru tau kalau tempat ini sudah buka lagi. Terakhir
                        kesana masih renovasi. Wajib masuk list weekend ini nih!
                        👍
                      </p>
                      <button className="text-xs text-primary font-semibold mt-2 hover:underline">
                        Balas
                      </button>
                    </div>
                  </div>

                  {/* Komentar 2 */}
                  <div className="flex gap-4">
                    <div className="w-10 h-10 rounded-full bg-gray-200 overflow-hidden shrink-0">
                      <img
                        src="https://ui-avatars.com/api/?name=Siti+N&background=random"
                        alt="User"
                      />
                    </div>
                    <div>
                      <div className="flex items-center gap-2 mb-1">
                        <span className="font-bold text-gray-900 dark:text-white">
                          Siti Nurhaliza
                        </span>
                        <span className="text-xs text-gray-400">
                          • 5 jam yang lalu
                        </span>
                      </div>
                      <p className="text-gray-600 dark:text-gray-300 text-sm leading-relaxed">
                        Artikelnya sangat informatif. Min, tolong bahas juga
                        tentang akses transportasi umum menuju ke sana dong,
                        biar yang gak bawa kendaraan pribadi gampang aksesnya.
                      </p>
                      <button className="text-xs text-primary font-semibold mt-2 hover:underline">
                        Balas
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {/* === SIDEBAR (Widget Portal Berita) === */}
            <aside className="lg:col-span-4 space-y-8">
              {/* Widget 1: Sedang Hangat (Trending) */}
              <div className="bg-gray-50 dark:bg-gray-800/50 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 sticky top-28">
                <h3 className="text-lg font-bold mb-6 flex items-center gap-2 border-b border-gray-200 dark:border-gray-700 pb-2">
                  <span className="w-1 h-5 bg-accent rounded-full"></span>
                  Sedang Hangat
                </h3>
                <div className="space-y-6">
                  {trendingArticles.map((item, idx) => (
                    <Link
                      key={item.id}
                      to={`/artikel/${item.id}`}
                      className="flex gap-4 group"
                    >
                      <span className="text-3xl font-bold text-gray-200 dark:text-gray-700 group-hover:text-primary transition-colors">
                        0{idx + 1}
                      </span>
                      <div>
                        <h4 className="font-semibold text-gray-900 dark:text-white leading-snug group-hover:text-primary transition-colors line-clamp-2">
                          {item.title}
                        </h4>
                        <span className="text-xs text-gray-500 mt-1 block uppercase tracking-wide">
                          {item.category}
                        </span>
                      </div>
                    </Link>
                  ))}
                </div>
                <div className="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                  <Link
                    to="/artikel"
                    className="text-sm font-bold text-primary flex items-center gap-1 hover:gap-2 transition-all"
                  >
                    Lihat Indeks Berita <ArrowRight size={14} />
                  </Link>
                </div>
              </div>

              {/* Widget 2: Newsletter */}
              <div className="bg-gray-900 text-white p-8 rounded-2xl text-center relative overflow-hidden">
                <div className="absolute top-0 right-0 w-24 h-24 bg-primary blur-3xl opacity-50 rounded-full"></div>
                <div className="relative z-10">
                  <h3 className="font-bold text-xl mb-2">Jelajah Lebih Jauh</h3>
                  <p className="text-gray-400 text-sm mb-6">
                    Dapatkan rekomendasi wisata terkurasi langsung di inbox
                    Anda.
                  </p>
                  <input
                    type="email"
                    placeholder="Email Anda..."
                    className="w-full px-4 py-3 rounded-lg text-gray-900 mb-3 focus:outline-none focus:ring-2 focus:ring-primary"
                  />
                  <button className="w-full py-3 bg-primary hover:bg-blue-600 rounded-lg font-bold transition shadow-lg shadow-blue-500/30">
                    Berlangganan
                  </button>
                </div>
              </div>
            </aside>
          </div>
        </div>
      </main>
      <Footer />
    </div>
  );
};

export default ArticleDetail;
