import React, { useState } from "react";
import Navbar from "../components/Navbar";
import Footer from "../components/Footer";
import InteractiveMap from "../components/InteractiveMap"; // Import Peta
import { destinations } from "../data/mockData";
import { MapPin, Search, Compass, Map as MapIcon, Grid } from "lucide-react";
import { Link } from "react-router-dom";

const Destinations = () => {
  const [searchQuery, setSearchQuery] = useState("");
  const [selectedCategory, setSelectedCategory] = useState("Semua");
  const [showMap, setShowMap] = useState(true); // Toggle untuk menampilkan peta

  const categories = [
    "Semua",
    "Alam",
    "Rekreasi",
    "Religi",
    "Sejarah",
    "Kuliner",
  ];

  // Logic Filter
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
        {/* HERO HEADER */}
        <div className="container mx-auto px-4 mb-12 text-center">
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
            Eksplorasi sudut kota Tangerang melalui peta interaktif kami atau
            telusuri daftar rekomendasi di bawah ini.
          </p>
        </div>

        {/* SEARCH & FILTER SECTION */}
        <div className="container mx-auto px-4 mb-8 sticky top-20 z-40 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md py-4 rounded-b-2xl">
          <div className="flex flex-col md:flex-row justify-between items-center gap-4">
            {/* Filter Categories */}
            <div className="flex gap-2 overflow-x-auto w-full md:w-auto pb-1 no-scrollbar order-2 md:order-1">
              {categories.map((cat) => (
                <button
                  key={cat}
                  onClick={() => setSelectedCategory(cat)}
                  className={`
                    whitespace-nowrap px-4 py-2 rounded-full text-sm font-bold transition-all border
                    ${
                      selectedCategory === cat
                        ? "bg-gray-900 text-white border-gray-900 dark:bg-white dark:text-gray-900"
                        : "bg-white text-gray-500 border-gray-200 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50"
                    }
                  `}
                >
                  {cat}
                </button>
              ))}
            </div>

            {/* Search Bar */}
            <div className="relative w-full md:w-80 order-1 md:order-2">
              <Search
                className="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"
                size={18}
              />
              <input
                type="text"
                placeholder="Cari lokasi..."
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                className="w-full pl-10 pr-4 py-2 rounded-full bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-accent/50 transition-all shadow-sm"
              />
            </div>
          </div>
        </div>

        {/* MAP SECTION (Tampil jika showMap true) */}
        <div className="container mx-auto px-4 mb-12">
          <div className="flex justify-end mb-4">
            <button
              onClick={() => setShowMap(!showMap)}
              className="flex items-center gap-2 text-sm font-semibold text-primary hover:underline"
            >
              {showMap ? (
                <>
                  <Grid size={16} /> Sembunyikan Peta
                </>
              ) : (
                <>
                  <MapIcon size={16} /> Tampilkan Peta
                </>
              )}
            </button>
          </div>

          {showMap && (
            <div className="mb-12 animate-in fade-in slide-in-from-top-4 duration-500">
              {/* Kirim data yang SUDAH DIFILTER ke peta */}
              <InteractiveMap destinations={filteredDestinations} />
              <p className="text-center text-xs text-gray-400 mt-2">
                Menampilkan {filteredDestinations.length} lokasi di peta
                berdasarkan filter aktif.
              </p>
            </div>
          )}
        </div>

        {/* GRID DESTINASI */}
        <div className="container mx-auto px-4">
          {filteredDestinations.length > 0 ? (
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
              {filteredDestinations.map((item) => (
                /* UBAH DARI DIV KE LINK */
                <Link
                  to={`/destinasi/${item.id}`} // Arahkan ke URL detail berdasarkan ID
                  key={item.id}
                  className="group relative h-[350px] rounded-3xl overflow-hidden cursor-pointer shadow-sm border border-gray-100 dark:border-gray-800 block" // Tambahkan 'block' agar layout aman
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
                      <h3 className="text-xl font-bold text-white mb-1 leading-tight">
                        {item.name}
                      </h3>
                      <div className="flex items-center gap-1 text-gray-300 text-xs mb-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-100">
                        <MapPin size={12} className="text-accent" />
                        <span>Kota Tangerang</span>
                      </div>
                    </div>
                  </div>
                </Link>
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
