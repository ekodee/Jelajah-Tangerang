import React, { useState, useEffect } from "react";
import Navbar from "../components/Navbar";
import Footer from "../components/Footer";
import Card from "../components/Card";
import Pagination from "../components/Pagination";
import { articles } from "../data/mockData";
import { Search, Filter } from "lucide-react";
import { Link } from "react-router-dom";

const Articles = () => {
  const [searchQuery, setSearchQuery] = useState("");
  const [selectedCategory, setSelectedCategory] = useState("Semua");
  const [currentPage, setCurrentPage] = useState(1);
  const itemsPerPage = 6;
  const categories = [
    "Semua",
    "Kuliner",
    "Sejarah",
    "Budaya",
    "Rekreasi",
    "Event",
  ];

  useEffect(() => {
    setCurrentPage(1);
  }, [searchQuery, selectedCategory]);

  const filteredArticles = articles.filter((item) => {
    const matchesCategory =
      selectedCategory === "Semua" || item.category === selectedCategory;
    const matchesSearch = item.title
      .toLowerCase()
      .includes(searchQuery.toLowerCase());
    return matchesCategory && matchesSearch;
  });

  const indexOfLastItem = currentPage * itemsPerPage;
  const indexOfFirstItem = indexOfLastItem - itemsPerPage;
  const currentArticles = filteredArticles.slice(
    indexOfFirstItem,
    indexOfLastItem
  );
  const totalPages = Math.ceil(filteredArticles.length / itemsPerPage);

  // Ambil artikel pertama sebagai Featured (jika tidak sedang search/filter)
  const featuredArticle = articles[0];
  const showFeatured =
    !searchQuery && selectedCategory === "Semua" && currentPage === 1;

  return (
    <div className="min-h-screen bg-white dark:bg-gray-900 font-sans text-gray-900 dark:text-gray-100 flex flex-col">
      <Navbar toggleSidebar={() => {}} />

      <main className="flex-grow pt-24 pb-12">
        <div className="container mx-auto px-4">
          <div className="mb-8">
            <h1 className="text-4xl font-extrabold text-gray-900 dark:text-white">
              <span className="text-primary">Berita & Artikel</span>
            </h1>
            <p className="text-gray-500 mt-2">
              Laporan terkini seputar pariwisata dan gaya hidup Tangerang.
            </p>
          </div>

          {/* === FEATURED STORY (EDITOR'S PICK) === */}
          {showFeatured && (
            <div className="mb-16 relative rounded-3xl overflow-hidden group cursor-pointer shadow-2xl h-[450px]">
              <img
                src={featuredArticle.image}
                alt={featuredArticle.title}
                className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent flex flex-col justify-end p-8 md:p-12">
                <span className="bg-accent text-white text-xs font-bold px-3 py-1 rounded-full w-fit mb-4 tracking-widest uppercase">
                  Editor's Pick
                </span>
                <h2 className="text-3xl md:text-5xl font-extrabold text-white mb-4 leading-tight max-w-4xl group-hover:text-blue-200 transition-colors">
                  {featuredArticle.title}
                </h2>
                <p className="text-gray-300 line-clamp-2 max-w-2xl mb-6 text-lg md:text-xl font-light">
                  {featuredArticle.summary}
                </p>
                <Link
                  to={`/artikel/${featuredArticle.id}`}
                  className="bg-white/10 hover:bg-white text-white hover:text-black backdrop-blur-md border border-white/30 px-8 py-3 rounded-full font-bold transition-all w-fit"
                >
                  Baca Laporan Lengkap
                </Link>
              </div>
            </div>
          )}

          {/* CONTROLS */}
          <div className="flex flex-col md:flex-row justify-between items-center gap-6 mb-10 sticky top-20 z-30 bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg p-4 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm">
            <div className="relative w-full md:w-96">
              <Search
                className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"
                size={20}
              />
              <input
                type="text"
                placeholder="Cari topik..."
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                className="w-full pl-10 pr-4 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50"
              />
            </div>
            <div className="flex gap-2 overflow-x-auto w-full md:w-auto pb-1 no-scrollbar">
              {categories.map((cat) => (
                <button
                  key={cat}
                  onClick={() => setSelectedCategory(cat)}
                  className={`
                    whitespace-nowrap px-4 py-2 rounded-full text-sm font-medium transition-all
                    ${
                      selectedCategory === cat
                        ? "bg-gray-900 text-white dark:bg-white dark:text-gray-900"
                        : "bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-700"
                    }
                  `}
                >
                  {cat}
                </button>
              ))}
            </div>
          </div>

          {/* GRID */}
          {currentArticles.length > 0 ? (
            <>
              <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {currentArticles.map((item) => (
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
              <Pagination
                currentPage={currentPage}
                totalPages={totalPages}
                onPageChange={setCurrentPage}
              />
            </>
          ) : (
            <div className="text-center py-20 bg-gray-50 dark:bg-gray-800/50 rounded-2xl">
              <Filter className="mx-auto text-gray-400 mb-4" size={40} />
              <h3 className="text-xl font-bold mb-2">Tidak ditemukan</h3>
              <p className="text-gray-500">Coba kata kunci lain.</p>
            </div>
          )}
        </div>
      </main>
      <Footer />
    </div>
  );
};

export default Articles;
