import React, { useState, useEffect } from "react";
import { useParams, Link } from "react-router-dom";
import Navbar from "../components/Navbar";
import Footer from "../components/Footer";
import InteractiveMap from "../components/InteractiveMap";
// PERBAIKAN: Import Tag
import {
  MapPin,
  Clock,
  Star,
  ArrowLeft,
  Navigation,
  Loader2,
  Tag,
} from "lucide-react";
import api from "../api";

const DestinationDetail = () => {
  const { slug } = useParams(); // Ambil SLUG
  const [destination, setDestination] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    window.scrollTo(0, 0);
  }, [slug]);

  useEffect(() => {
    const fetchDetail = async () => {
      try {
        setLoading(true);
        // Fetch pakai slug
        const res = await api.get(`/destinations/${slug}`);
        setDestination(res.data);
      } catch (err) {
        console.error("Gagal load destinasi", err);
      } finally {
        setLoading(false);
      }
    };
    fetchDetail();
  }, [slug]);

  if (loading) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-white dark:bg-gray-900">
        <Loader2 className="animate-spin text-primary" size={40} />
      </div>
    );
  }

  if (!destination)
    return (
      <div className="min-h-screen flex items-center justify-center dark:bg-gray-900 dark:text-white">
        <h2>Destinasi Tidak Ditemukan</h2>
      </div>
    );

  return (
    <div className="min-h-screen bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-sans">
      <Navbar toggleSidebar={() => {}} />

      {/* FIX TAMPILAN: Tambahkan pt-20 agar konten tidak nabrak navbar */}
      <div className="pt-20">
        {/* HEADER IMAGE FULL WIDTH */}
        <div className="relative h-[50vh] w-full">
          <img
            src={destination.image}
            alt={destination.name}
            className="w-full h-full object-cover"
            onError={(e) => {
              e.target.src = "https://placehold.co/800x600?text=No+Image";
            }}
          />
          <div className="absolute inset-0 bg-black/40 flex flex-col justify-end pb-12 px-4">
            <div className="container mx-auto">
              <Link
                to="/destinasi"
                className="inline-flex items-center gap-2 text-white/80 hover:text-white mb-6 backdrop-blur-sm bg-black/20 px-4 py-2 rounded-full w-fit text-sm"
              >
                <ArrowLeft size={16} /> Kembali ke Daftar
              </Link>
              <span className="bg-primary text-white text-xs font-bold px-3 py-1 rounded-full mb-3 inline-block">
                {destination.category}
              </span>
              <h1 className="text-4xl md:text-6xl font-extrabold text-white mb-2">
                {destination.name}
              </h1>
              <div className="flex items-center gap-4 text-white/90">
                <div className="flex items-center gap-1">
                  <MapPin size={18} className="text-accent" />
                  <span>{destination.address}</span>
                </div>
                <div className="flex items-center gap-1">
                  <Star size={18} className="text-yellow-400 fill-yellow-400" />
                  <span>
                    {destination.rating} (
                    {destination.reviews ? destination.reviews.length : 0}{" "}
                    Ulasan)
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <main className="container mx-auto px-4 py-12">
          <div className="grid grid-cols-1 lg:grid-cols-3 gap-12">
            {/* KOLOM KIRI: INFO & PETA */}
            <div className="lg:col-span-2 space-y-8">
              <section className="prose dark:prose-invert max-w-none">
                <h3 className="text-2xl font-bold mb-4">Tentang Destinasi</h3>
                <p className="text-lg leading-relaxed text-gray-600 dark:text-gray-300">
                  {destination.description}
                </p>
              </section>

              <section>
                <h3 className="text-2xl font-bold mb-4">Lokasi</h3>
                <div className="h-[400px] rounded-2xl overflow-hidden shadow-lg border border-gray-200 dark:border-gray-700">
                  <InteractiveMap destinations={[destination]} />
                </div>
                <a
                  href={`https://www.google.com/maps/dir/?api=1&destination=${destination.lat},${destination.lng}`}
                  target="_blank"
                  rel="noreferrer"
                  className="mt-4 inline-flex items-center gap-2 bg-gray-100 dark:bg-gray-800 px-6 py-3 rounded-xl font-bold hover:bg-gray-200 dark:hover:bg-gray-700 transition w-full justify-center"
                >
                  <Navigation size={18} /> Buka di Google Maps
                </a>
              </section>

              <section className="pt-8 border-t border-gray-100 dark:border-gray-800">
                <h3 className="text-2xl font-bold mb-6">Ulasan Pengunjung</h3>
                {destination.reviews && destination.reviews.length > 0 ? (
                  <div className="space-y-6">
                    {destination.reviews.map((review) => (
                      <div
                        key={review.id}
                        className="bg-gray-50 dark:bg-gray-800/50 p-6 rounded-2xl"
                      >
                        <div className="flex items-center justify-between mb-3">
                          <div className="flex items-center gap-3">
                            <div className="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center font-bold text-primary">
                              {review.user.charAt(0)}
                            </div>
                            <div>
                              <h5 className="font-bold text-gray-900 dark:text-white">
                                {review.user}
                              </h5>
                              <span className="text-xs text-gray-500">
                                {review.date}
                              </span>
                            </div>
                          </div>
                          <div className="flex text-yellow-400 text-sm">
                            {[...Array(5)].map((_, i) => (
                              <Star
                                key={i}
                                size={14}
                                className={
                                  i < review.rating
                                    ? "fill-yellow-400"
                                    : "text-gray-300"
                                }
                              />
                            ))}
                          </div>
                        </div>
                        <p className="text-gray-600 dark:text-gray-300">
                          {review.comment}
                        </p>
                      </div>
                    ))}
                  </div>
                ) : (
                  <p className="text-gray-500 italic">
                    Belum ada ulasan untuk tempat ini.
                  </p>
                )}
              </section>
            </div>

            {/* KOLOM KANAN: DETAIL & FASILITAS */}
            <aside className="space-y-6">
              <div className="p-6 rounded-2xl border border-gray-100 dark:border-gray-700 sticky top-24 bg-white dark:bg-gray-900 shadow-sm">
                <h4 className="font-bold text-lg mb-6">Informasi Praktis</h4>
                <div className="space-y-4">
                  <div className="flex items-start gap-4">
                    <div className="p-2 bg-blue-50 dark:bg-blue-900/20 text-primary rounded-lg">
                      <Clock size={20} />
                    </div>
                    <div>
                      <span className="block text-xs text-gray-400 uppercase font-bold">
                        Jam Buka
                      </span>
                      <span className="font-medium">
                        {destination.openTime}
                      </span>
                    </div>
                  </div>
                  <div className="flex items-start gap-4">
                    <div className="p-2 bg-green-50 dark:bg-green-900/20 text-green-600 rounded-lg">
                      <Tag size={20} />
                    </div>
                    <div>
                      <span className="block text-xs text-gray-400 uppercase font-bold">
                        Tiket Masuk
                      </span>
                      <span className="font-medium">{destination.price}</span>
                    </div>
                  </div>
                </div>
                <div className="mt-8">
                  <h5 className="font-bold text-sm mb-3 text-gray-900 dark:text-white">
                    Fasilitas
                  </h5>
                  <div className="flex flex-wrap gap-2">
                    {destination.facilities.map((fasilitas, index) => (
                      <span
                        key={index}
                        className="px-3 py-1 bg-gray-100 dark:bg-gray-800 text-xs rounded-full text-gray-600 dark:text-gray-300"
                      >
                        {fasilitas}
                      </span>
                    ))}
                  </div>
                </div>
              </div>
            </aside>
          </div>
        </main>
      </div>
      <Footer />
    </div>
  );
};

export default DestinationDetail;
