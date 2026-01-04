import React, { useState } from "react";
import Navbar from "../components/Navbar";
import NewsTicker from "../components/NewsTicker"; // Import Ticker
import Card from "../components/Card";
import Button from "../components/Button";
import Footer from "../components/Footer";
import { articles, destinations } from "../data/mockData";
import { ArrowRight, Clock, MapPin } from "lucide-react";

const Home = () => {
  const [activeCategory, setActiveCategory] = useState("Semua");
  const categories = [
    "Semua",
    "Kuliner",
    "Sejarah",
    "Budaya",
    "Rekreasi",
    "Event",
  ];

  // Ambil 1 Berita Utama (Headline) & 2 Berita Samping (Sub-Headline)
  const headlineNews = articles[0];
  const sideNews = articles.slice(1, 3);

  // Filter untuk list berita di bawah
  const filteredArticles =
    activeCategory === "Semua"
      ? articles.slice(3) // Skip 3 berita pertama karena sudah jadi headline
      : articles.filter((item) => item.category === activeCategory);

  return (
    <div className="min-h-screen bg-white dark:bg-gray-900 font-sans text-gray-900 dark:text-gray-100">
      <Navbar toggleSidebar={() => {}} />

      <main className="pt-20">
        {" "}
        {/* Sesuaikan padding top karena ada navbar fixed */}
        {/* 1. NEWS TICKER (Elemen Portal Berita) */}
        <NewsTicker />
        {/* 2. HEADLINE SECTION (Gaya Portal Berita) */}
        <section className="container mx-auto px-4 py-8">
          <div className="grid grid-cols-1 lg:grid-cols-3 gap-6 h-auto lg:h-[500px]">
            {/* Berita Utama (Kiri - Besar) */}
            <div className="lg:col-span-2 relative rounded-2xl overflow-hidden group cursor-pointer shadow-lg">
              <img
                src={headlineNews.image}
                alt={headlineNews.title}
                className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent flex flex-col justify-end p-6 md:p-8">
                <span className="bg-primary text-white text-xs font-bold px-3 py-1 rounded-full w-fit mb-3">
                  HEADLINE
                </span>
                <h2 className="text-2xl md:text-4xl font-extrabold text-white mb-2 leading-tight group-hover:text-blue-300 transition-colors">
                  {headlineNews.title}
                </h2>
                <p className="text-gray-300 line-clamp-2 mb-4 md:text-lg max-w-2xl">
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
            </div>

            {/* Berita Samping (Kanan - Stack) */}
            <div className="flex flex-col gap-6">
              {sideNews.map((news) => (
                <div
                  key={news.id}
                  className="flex-1 relative rounded-2xl overflow-hidden group cursor-pointer shadow-md"
                >
                  <img
                    src={news.image}
                    alt={news.title}
                    className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                  />
                  <div className="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent flex flex-col justify-end p-5">
                    <span className="text-accent text-xs font-bold uppercase mb-1">
                      {news.category}
                    </span>
                    <h3 className="text-lg font-bold text-white leading-snug group-hover:underline">
                      {news.title}
                    </h3>
                    <span className="text-gray-400 text-xs mt-2 flex items-center gap-1">
                      <Clock size={12} /> {news.date}
                    </span>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </section>
        {/* 3. LATEST NEWS (Grid Artikel biasa) */}
        <section className="container mx-auto px-4 mb-24 mt-12">
          <div className="flex flex-col md:flex-row justify-between items-end mb-8 gap-6 border-b border-gray-100 dark:border-gray-800 pb-4">
            <div>
              <h2 className="text-3xl font-bold mb-2">Berita Terkini</h2>
              <p className="text-gray-500">
                Update seputar pariwisata dan gaya hidup.
              </p>
            </div>

            {/* Filter Pills */}
            <div className="flex gap-2 overflow-x-auto pb-2 w-full md:w-auto no-scrollbar">
              {categories.map((cat) => (
                <button
                  key={cat}
                  onClick={() => setActiveCategory(cat)}
                  className={`
                    whitespace-nowrap px-4 py-2 rounded-full text-sm font-medium transition-all border
                    ${
                      activeCategory === cat
                        ? "bg-gray-900 text-white border-gray-900 dark:bg-white dark:text-gray-900"
                        : "bg-white text-gray-600 border-gray-200 hover:border-gray-400 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700"
                    }
                  `}
                >
                  {cat}
                </button>
              ))}
            </div>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {filteredArticles.map((item) => (
              <Card
                key={item.id}
                id={item.id}
                title={item.title}
                subtitle={item.summary}
                image={item.image}
                category={item.category}
                date={item.date}
                type="article"
              />
            ))}
          </div>
        </section>
        {/* 4. REKOMENDASI DESTINASI (Sebagai "Editor's Choice") */}
        <section className="bg-gray-50 dark:bg-gray-800/50 py-20">
          <div className="container mx-auto px-4">
            <div className="flex justify-between items-center mb-10">
              <div>
                <span className="text-accent font-bold tracking-wider text-sm uppercase">
                  Pilihan Redaksi
                </span>
                <h2 className="text-3xl font-bold mt-1">
                  Destinasi Wajib Minggu Ini
                </h2>
              </div>
              <Button variant="outline">Lihat Semua Wisata</Button>
            </div>

            <div className="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
              {destinations.slice(0, 4).map((item) => (
                <div
                  key={item.id}
                  className="group relative aspect-[3/4] rounded-xl overflow-hidden cursor-pointer"
                >
                  <img
                    src={item.image}
                    alt={item.name}
                    className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                  />
                  <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent flex flex-col justify-end p-4">
                    <h3 className="text-white font-bold text-lg">
                      {item.name}
                    </h3>
                    <div className="flex items-center gap-1 text-gray-300 text-xs mt-1">
                      <MapPin size={12} /> Tangerang Kota
                    </div>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </section>
      </main>
      <Footer />
    </div>
  );
};

export default Home;
