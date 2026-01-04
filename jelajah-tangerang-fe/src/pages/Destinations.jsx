import React, { useState } from "react";
import Navbar from "../components/Navbar";
import Footer from "../components/Footer";
import { destinations } from "../data/mockData";
import { MapPin, Search, Compass } from "lucide-react";

const Destinations = () => {
  const [searchQuery, setSearchQuery] = useState("");
  const [selectedCategory, setSelectedCategory] = useState("Semua");
  const categories = [
    "Semua",
    "Alam",
    "Rekreasi",
    "Religi",
    "Sejarah",
    "Kuliner",
  ];

  const filteredDestinations = destinations.filter((item) => {
    const matchesCategory =
      selectedCategory === "Semua" || item.category === selectedCategory;
    const matchesSearch = item.name
      .toLowerCase()
      .includes(searchQuery.toLowerCase());
    return matchesCategory && matchesSearch;
  });

  return (
    <div className="min-h-screen bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-sans">
      <Navbar toggleSidebar={() => {}} />

      <main className="pt-24 pb-12">
        {/* HERO HEADER (Narrative Style) */}
        <div className="container mx-auto px-4 mb-16 text-center">
          <div className="inline-flex items-center gap-2 px-4 py-2 bg-orange-50 dark:bg-orange-900/20 text-accent rounded-full text-sm font-bold mb-6">
            <Compass size={16} /> Travel & Lifestyle Guide
          </div>
          <h1 className="text-4xl md:text-6xl font-extrabold mb-6 tracking-tight">
            Panduan Wisata{" "}
            <span className="text-transparent bg-clip-text bg-gradient-to-r from-accent to-yellow-400">
              Terkurasi
            </span>
          </h1>
          <p className="text-gray-500 dark:text-gray-400 text-lg md:text-xl max-w-3xl mx-auto leading-relaxed">
            Kami memilihkan pengalaman terbaik di Tangerang untuk Anda. Mulai
            dari <i>hidden gems</i> kuliner hingga spot foto paling estetik yang
            wajib dikunjungi akhir pekan ini.
          </p>
        </div>

        {/* SEARCH & FILTER */}
        <div className="container mx-auto px-4 mb-12">
          <div className="flex flex-col md:flex-row justify-center items-center gap-4">
            <div className="relative w-full md:w-96">
              <Search
                className="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"
                size={20}
              />
              <input
                type="text"
                placeholder="Cari destinasi atau lokasi..."
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                className="w-full pl-12 pr-4 py-3 rounded-full bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-accent/50 transition-all shadow-sm"
              />
            </div>
            <div className="flex gap-2 overflow-x-auto w-full md:w-auto pb-1 no-scrollbar justify-start">
              {categories.map((cat) => (
                <button
                  key={cat}
                  onClick={() => setSelectedCategory(cat)}
                  className={`
                    whitespace-nowrap px-6 py-3 rounded-full text-sm font-bold transition-all
                    ${
                      selectedCategory === cat
                        ? "bg-accent text-white shadow-lg shadow-orange-500/30 transform scale-105"
                        : "bg-white dark:bg-gray-800 text-gray-500 border border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700"
                    }
                  `}
                >
                  {cat}
                </button>
              ))}
            </div>
          </div>
        </div>

        {/* GRID DESTINASI */}
        <div className="container mx-auto px-4">
          {filteredDestinations.length > 0 ? (
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
              {filteredDestinations.map((item) => (
                <div
                  key={item.id}
                  className="group relative h-[400px] rounded-3xl overflow-hidden cursor-pointer"
                >
                  {/* Gambar */}
                  <img
                    src={item.image}
                    alt={item.name}
                    className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                  />

                  {/* Gradient Overlay */}
                  <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end p-6">
                    <div className="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                      <span className="inline-block px-2 py-1 mb-2 bg-white/20 backdrop-blur-sm border border-white/30 text-white text-[10px] font-bold uppercase tracking-wider rounded">
                        {item.category}
                      </span>
                      <h3 className="text-2xl font-bold text-white mb-2 leading-tight">
                        {item.name}
                      </h3>
                      <div className="flex items-center gap-1 text-gray-300 text-sm mb-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-100">
                        <MapPin size={14} className="text-accent" />
                        <span>Kota Tangerang</span>
                      </div>
                    </div>
                  </div>
                </div>
              ))}
            </div>
          ) : (
            <div className="text-center py-20 bg-gray-50 dark:bg-gray-800/50 rounded-3xl border border-dashed border-gray-300">
              <p className="text-gray-500">
                Lokasi belum tersedia dalam panduan kami.
              </p>
            </div>
          )}
        </div>
      </main>
      <Footer />
    </div>
  );
};

export default Destinations;
