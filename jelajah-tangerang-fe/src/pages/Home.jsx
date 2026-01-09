import React, { useState, useEffect } from "react";
import Navbar from "../components/Navbar";
import NewsTicker from "../components/NewsTicker";
import Card from "../components/Card";
import Button from "../components/Button";
import Footer from "../components/Footer";
import { ArrowRight, Clock, MapPin, Loader2, Filter } from "lucide-react";
import { Link } from "react-router-dom";
import api from "../api";

const Home = () => {
  const [articles, setArticles] = useState([]);
  const [destinations, setDestinations] = useState([]);
  const [categories, setCategories] = useState(["Semua"]);
  const [loading, setLoading] = useState(true);
  const [activeCategory, setActiveCategory] = useState("Semua");

  useEffect(() => {
    const fetchData = async () => {
      try {
        setLoading(true);
        const [articlesRes, destinationsRes, categoriesRes] = await Promise.all(
          [
            api.get("/articles"), // Idealnya nanti di backend dikasih limit (?limit=10)
            api.get("/destinations"),
            api.get("/categories"),
          ]
        );

        setArticles(articlesRes.data);
        setDestinations(destinationsRes.data);
        const catNames = categoriesRes.data.map((cat) => cat.name);
        setCategories(["Semua", ...catNames]);
      } catch (err) {
        console.error("Gagal memuat data Home:", err);
      } finally {
        setLoading(false);
      }
    };
    fetchData();
  }, []);

  // --- LOGIKA TAMPILAN BERITA ---
  const headlineNews = articles.length > 0 ? articles[0] : null;
  const sideNews = articles.length > 1 ? articles.slice(1, 3) : [];

  // PERBAIKAN DISINI: Limit hanya ambil 6 berita setelah headline/side news
  // Jadi total yang tampil di grid bawah maksimal 6.
  const remainingArticles =
    articles.length > 3 ? articles.slice(3, 9) : articles;

  const filteredArticles =
    activeCategory === "Semua"
      ? remainingArticles
      : remainingArticles.filter((item) => item.category === activeCategory);

  if (loading) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-white dark:bg-gray-900">
        <Loader2 className="animate-spin text-primary" size={40} />
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-white dark:bg-gray-900 font-sans text-gray-900 dark:text-gray-100 transition-colors duration-300">
      <Navbar toggleSidebar={() => {}} />

      <main className="pt-24">
        {/* 1. NEWS TICKER */}
        <div className="mb-8">
          <NewsTicker />
        </div>

        {/* 2. HEADLINE SECTION */}
        <section className="container mx-auto px-4 mb-20 relative z-0">
          {headlineNews ? (
            <div className="grid grid-cols-1 lg:grid-cols-3 gap-6 h-auto lg:min-h-[500px]">
              {/* Berita Utama */}
              <Link
                to={`/artikel/${headlineNews.slug}`}
                className="lg:col-span-2 relative rounded-3xl overflow-hidden group cursor-pointer shadow-xl block min-h-[300px]"
              >
                <img
                  src={headlineNews.image}
                  alt={headlineNews.title}
                  className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                  onError={(e) => {
                    e.target.src = "https://placehold.co/800x600?text=No+Image";
                  }}
                />
                <div className="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent flex flex-col justify-end p-6 md:p-10">
                  <span className="bg-primary text-white text-xs font-bold px-3 py-1 rounded-full w-fit mb-3">
                    HEADLINE
                  </span>
                  <h2 className="text-2xl md:text-4xl font-extrabold text-white mb-3 leading-tight group-hover:text-blue-300 transition-colors">
                    {headlineNews.title}
                  </h2>
                  <p className="text-gray-300 line-clamp-2 mb-4 md:text-lg max-w-2xl font-light">
                    {headlineNews.summary}
                  </p>
                  <div className="flex items-center gap-4 text-gray-400 text-sm">
                    <span className="flex items-center gap-1">
                      <Clock size={14} /> {headlineNews.date}
                    </span>
                    <span className="text-white font-semibold">
                      Oleh: {headlineNews.author}
                    </span>
                  </div>
                </div>
              </Link>

              {/* Berita Samping */}
              <div className="flex flex-col gap-6">
                {sideNews.map((news) => (
                  <Link
                    to={`/artikel/${news.slug}`}
                    key={news.id}
                    className="flex-1 relative rounded-3xl overflow-hidden group cursor-pointer shadow-md block min-h-[200px]"
                  >
                    <img
                      src={news.image}
                      alt={news.title}
                      className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                      onError={(e) => {
                        e.target.src =
                          "https://placehold.co/600x400?text=No+Image";
                      }}
                    />
                    <div className="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent flex flex-col justify-end p-6">
                      <span className="text-accent text-xs font-bold uppercase mb-2 tracking-wider">
                        {news.category}
                      </span>
                      <h3 className="text-lg font-bold text-white leading-snug group-hover:underline line-clamp-2">
                        {news.title}
                      </h3>
                      <span className="text-gray-400 text-xs mt-2 flex items-center gap-1">
                        <Clock size={12} /> {news.date}
                      </span>
                    </div>
                  </Link>
                ))}
              </div>
            </div>
          ) : (
            <div className="text-center py-20 bg-gray-50 dark:bg-gray-800 rounded-2xl">
              <p className="text-gray-500">Belum ada berita utama.</p>
            </div>
          )}
        </section>

        {/* 3. LATEST NEWS */}
        <section className="container mx-auto px-4 mb-24 relative z-10 bg-white dark:bg-gray-900 rounded-t-3xl pt-4">
          <div className="flex flex-col md:flex-row justify-between items-end mb-8 gap-6 border-b border-gray-100 dark:border-gray-800 pb-4">
            <div>
              <h2 className="text-3xl font-bold mb-2 text-gray-900 dark:text-white">
                Berita Terkini
              </h2>
              <p className="text-gray-500">
                Update seputar pariwisata dan gaya hidup.
              </p>
            </div>

            <div className="flex gap-2 overflow-x-auto pb-2 w-full md:w-auto no-scrollbar">
              {categories.map((cat) => (
                <button
                  key={cat}
                  onClick={() => setActiveCategory(cat)}
                  className={`
                    whitespace-nowrap px-5 py-2 rounded-full text-sm font-bold transition-all border
                    ${
                      activeCategory === cat
                        ? "bg-gray-900 text-white border-gray-900 dark:bg-white dark:text-gray-900"
                        : "bg-white text-gray-500 border-gray-200 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-700"
                    }
                  `}
                >
                  {cat}
                </button>
              ))}
            </div>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {filteredArticles.length > 0 ? (
              filteredArticles.map((item) => (
                <Card
                  key={item.id}
                  id={item.slug}
                  title={item.title}
                  subtitle={item.summary}
                  image={item.image}
                  category={item.category}
                  date={item.date}
                  type="article"
                />
              ))
            ) : (
              <div className="col-span-3 text-center py-20 bg-gray-50 dark:bg-gray-800/50 rounded-2xl">
                <Filter className="mx-auto text-gray-300 mb-4" size={48} />
                <p className="text-gray-500 font-medium">
                  Tidak ada berita untuk kategori ini.
                </p>
              </div>
            )}
          </div>

          {/* TOMBOL LIHAT SEMUA */}
          <div className="mt-12 text-center">
            <Link to="/artikel">
              <Button
                variant="outline"
                className="px-8 py-3 rounded-full border-gray-300"
              >
                Lihat Arsip Berita <ArrowRight size={16} className="ml-2" />
              </Button>
            </Link>
          </div>
        </section>

        {/* 4. REKOMENDASI DESTINASI */}
        <section className="bg-gray-50 dark:bg-gray-800/30 py-20">
          <div className="container mx-auto px-4">
            <div className="flex flex-col md:flex-row justify-between items-end mb-12 gap-4">
              <div>
                <span className="text-primary font-bold tracking-wider text-xs uppercase mb-2 block">
                  Pilihan Redaksi
                </span>
                <h2 className="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white">
                  Destinasi Wajib Minggu Ini
                </h2>
              </div>
              <Link to="/destinasi">
                <Button variant="outline" className="group">
                  Lihat Semua Wisata{" "}
                  <ArrowRight
                    size={16}
                    className="group-hover:translate-x-1 transition-transform"
                  />
                </Button>
              </Link>
            </div>

            <div className="grid grid-cols-2 md:grid-cols-4 gap-6">
              {destinations.length > 0 ? (
                destinations.slice(0, 4).map((item) => (
                  <Link
                    to={`/destinasi/${item.slug}`}
                    key={item.id}
                    className="group relative aspect-[3/4] rounded-2xl overflow-hidden cursor-pointer block shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1"
                  >
                    <img
                      src={item.image}
                      alt={item.name}
                      className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                      onError={(e) => {
                        e.target.src =
                          "https://placehold.co/600x400?text=No+Image";
                      }}
                    />
                    <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent flex flex-col justify-end p-5">
                      <h3 className="text-white font-bold text-lg leading-tight mb-1">
                        {item.name}
                      </h3>
                      <div className="flex items-center gap-1 text-gray-300 text-xs opacity-80 group-hover:opacity-100 transition-opacity">
                        <MapPin size={12} className="text-accent" /> Tangerang
                        Kota
                      </div>
                    </div>
                  </Link>
                ))
              ) : (
                <div className="col-span-4 text-center text-gray-500 italic py-10">
                  Belum ada data destinasi.
                </div>
              )}
            </div>
          </div>
        </section>
      </main>
      <Footer />
    </div>
  );
};

export default Home;
