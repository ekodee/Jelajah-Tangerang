import React, { useEffect } from "react";
import { useParams, Link } from "react-router-dom";
import Navbar from "../components/Navbar";
import Footer from "../components/Footer";
import InteractiveMap from "../components/InteractiveMap"; // Reuse komponen peta
import { destinations } from "../data/mockData";
import {
  MapPin,
  Clock,
  DollarSign,
  Star,
  CheckCircle,
  ArrowLeft,
  Share2,
} from "lucide-react";

const DestinationDetail = () => {
  const { id } = useParams();
  const destination = destinations.find((item) => item.id === parseInt(id));

  // Destinasi Serupa (Mock: ambil 3 destinasi lain dengan kategori sama)
  const relatedDestinations = destinations
    .filter(
      (item) =>
        item.category === destination?.category && item.id !== destination?.id
    )
    .slice(0, 3);

  useEffect(() => {
    window.scrollTo(0, 0);
  }, [id]);

  if (!destination)
    return <div className="text-center py-20">Destinasi tidak ditemukan.</div>;

  return (
    <div className="min-h-screen bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-sans">
      <Navbar toggleSidebar={() => {}} />

      <main className="pt-24 pb-12">
        {/* BREADCRUMB */}
        <div className="container mx-auto px-4 mb-6">
          <Link
            to="/destinasi"
            className="inline-flex items-center gap-2 text-gray-500 hover:text-primary mb-4 text-sm font-medium"
          >
            <ArrowLeft size={16} /> Kembali ke Peta
          </Link>
          <h1 className="text-3xl md:text-5xl font-extrabold mb-4">
            {destination.name}
          </h1>
          <div className="flex flex-wrap gap-4 text-sm text-gray-500 items-center">
            <span className="px-3 py-1 bg-accent/10 text-accent rounded-full font-bold text-xs uppercase tracking-wider">
              {destination.category}
            </span>
            <span className="flex items-center gap-1">
              <Star size={16} className="text-yellow-400 fill-yellow-400" />{" "}
              {destination.rating || "4.5"} (Ulasan Redaksi)
            </span>
            <span className="flex items-center gap-1">
              <MapPin size={16} /> {destination.address}
            </span>
          </div>
        </div>

        {/* HERO IMAGE */}
        <div className="container mx-auto px-4 mb-12">
          <div className="w-full h-[300px] md:h-[500px] rounded-3xl overflow-hidden shadow-2xl relative">
            <img
              src={destination.image}
              alt={destination.name}
              className="w-full h-full object-cover"
            />
            <div className="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
          </div>
        </div>

        <div className="container mx-auto px-4">
          <div className="grid grid-cols-1 lg:grid-cols-3 gap-12">
            {/* KOLOM KIRI: Review & Peta */}
            <div className="lg:col-span-2 space-y-10">
              {/* Deskripsi / Review */}
              <section>
                <h2 className="text-2xl font-bold mb-4">Ulasan Redaksi</h2>
                <p className="text-lg text-gray-600 dark:text-gray-300 leading-relaxed">
                  {destination.description}
                </p>
                <p className="mt-4 text-gray-600 dark:text-gray-300 leading-relaxed">
                  Destinasi ini sangat cocok untuk Anda yang mencari pengalaman{" "}
                  {destination.category.toLowerCase()} yang otentik di
                  Tangerang. Jangan lupa membawa kamera karena banyak sudut
                  menarik untuk diabadikan.
                </p>
              </section>

              {/* Fasilitas */}
              <section>
                <h3 className="text-xl font-bold mb-4">Fasilitas Tersedia</h3>
                <div className="grid grid-cols-2 md:grid-cols-3 gap-4">
                  {destination.facilities?.map((fas, idx) => (
                    <div
                      key={idx}
                      className="flex items-center gap-2 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg"
                    >
                      <CheckCircle size={18} className="text-green-500" />
                      <span className="text-sm font-medium">{fas}</span>
                    </div>
                  )) || (
                    <p className="text-gray-500">
                      Info fasilitas belum tersedia.
                    </p>
                  )}
                </div>
              </section>

              {/* Peta Lokasi (Focused Map) */}
              <section>
                <h3 className="text-xl font-bold mb-4">Lokasi & Rute</h3>
                <div className="rounded-2xl overflow-hidden shadow-lg border border-gray-100 dark:border-gray-700">
                  <InteractiveMap destinations={[destination]} />
                </div>
                <div className="mt-4 text-center">
                  <a
                    href={`https://www.google.com/maps/search/?api=1&query=${destination.lat},${destination.lng}`}
                    target="_blank"
                    rel="noreferrer"
                    className="inline-flex items-center gap-2 text-primary font-bold hover:underline"
                  >
                    <MapPin size={18} /> Buka di Google Maps
                  </a>
                </div>
              </section>
            </div>

            {/* KOLOM KANAN: Info Praktis Sidebar */}
            <aside className="space-y-8">
              {/* Info Box */}
              <div className="p-6 rounded-2xl bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 shadow-xl sticky top-24">
                <h3 className="text-lg font-bold mb-6 border-b border-gray-100 dark:border-gray-700 pb-2">
                  Info Praktis
                </h3>

                <div className="space-y-5">
                  <div className="flex items-start gap-4">
                    <div className="w-10 h-10 rounded-full bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-primary shrink-0">
                      <Clock size={20} />
                    </div>
                    <div>
                      <p className="text-xs text-gray-500 uppercase font-bold">
                        Jam Operasional
                      </p>
                      <p className="font-semibold">
                        {destination.openTime || "TBA"}
                      </p>
                    </div>
                  </div>

                  <div className="flex items-start gap-4">
                    <div className="w-10 h-10 rounded-full bg-green-50 dark:bg-green-900/30 flex items-center justify-center text-green-600 shrink-0">
                      <DollarSign size={20} />
                    </div>
                    <div>
                      <p className="text-xs text-gray-500 uppercase font-bold">
                        Harga Tiket
                      </p>
                      <p className="font-semibold">
                        {destination.price || "TBA"}
                      </p>
                    </div>
                  </div>

                  <button className="w-full py-3 bg-primary hover:bg-blue-700 text-white rounded-xl font-bold transition shadow-lg shadow-blue-500/30 mt-2">
                    Reservasi Tiket / Info
                  </button>

                  <button className="w-full py-3 border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-xl font-semibold transition flex items-center justify-center gap-2">
                    <Share2 size={18} /> Bagikan
                  </button>
                </div>
              </div>

              {/* Rekomendasi Lain */}
              <div>
                <h3 className="text-lg font-bold mb-4">Destinasi Serupa</h3>
                <div className="space-y-4">
                  {relatedDestinations.map((item) => (
                    <Link
                      key={item.id}
                      to={`/destinasi/${item.id}`}
                      className="flex gap-3 group"
                    >
                      <img
                        src={item.image}
                        alt={item.name}
                        className="w-20 h-20 rounded-lg object-cover"
                      />
                      <div>
                        <h4 className="font-bold text-sm group-hover:text-primary transition-colors">
                          {item.name}
                        </h4>
                        <span className="text-xs text-gray-500">
                          {item.category}
                        </span>
                      </div>
                    </Link>
                  ))}
                </div>
              </div>
            </aside>
          </div>
          {/* KOMENTAR SECTION */}
          <div className="mt-12 pt-10 border-t border-gray-100 dark:border-gray-800">
            <h3 className="text-xl font-bold mb-6">Diskusi Pembaca (3)</h3>

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
                  className="w-full p-4 rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-primary/50 min-h-[100px]"
                ></textarea>
                <div className="mt-2 flex justify-end">
                  <button className="px-6 py-2 bg-primary text-white font-bold rounded-lg hover:bg-blue-700 transition">
                    Kirim Komentar
                  </button>
                </div>
              </div>
            </div>

            {/* List Komentar Dummy */}
            <div className="space-y-6">
              {[1, 2].map((i) => (
                <div key={i} className="flex gap-4">
                  <div className="w-10 h-10 rounded-full bg-gray-200 overflow-hidden shrink-0">
                    <img
                      src={`https://ui-avatars.com/api/?name=User+${i}&background=random`}
                      alt="User"
                    />
                  </div>
                  <div>
                    <div className="flex items-center gap-2 mb-1">
                      <span className="font-bold text-gray-900 dark:text-white">
                        Warga Tangerang
                      </span>
                      <span className="text-xs text-gray-400">
                        • 2 jam yang lalu
                      </span>
                    </div>
                    <p className="text-gray-600 dark:text-gray-300 text-sm leading-relaxed">
                      Artikel yang sangat informatif! Saya baru tahu kalau ada
                      tempat sekeren ini di Tangerang. Wajib dikunjungi weekend
                      nanti.
                    </p>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </main>
      <Footer />
    </div>
  );
};

export default DestinationDetail;
