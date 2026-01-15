import React, { useState, useEffect, useContext } from "react";
import { useParams, Link } from "react-router-dom";
import Navbar from "../components/Navbar";
import Footer from "../components/Footer";
import { Calendar, ArrowLeft, Share2, Tag, Loader2, Star } from "lucide-react";
import api from "../api";
import { AuthContext } from "../context/AuthContext";

const ArticleDetail = () => {
  const { slug } = useParams();
  const { user } = useContext(AuthContext);

  const [article, setArticle] = useState(null);
  const [trendingArticles, setTrendingArticles] = useState([]);
  const [loading, setLoading] = useState(true);

  // State untuk Komentar
  const [newComment, setNewComment] = useState("");
  const [newRating, setNewRating] = useState(5);
  const [isSubmitting, setIsSubmitting] = useState(false);

  useEffect(() => {
    window.scrollTo(0, 0);
  }, [slug]);

  useEffect(() => {
    const fetchData = async () => {
      try {
        setLoading(true);
        const detailRes = await api.get(`/articles/${slug}`);
        setArticle(detailRes.data);

        const listRes = await api.get("/articles");
        const otherArticles = listRes.data.filter((item) => item.slug !== slug);
        setTrendingArticles(otherArticles.slice(0, 4));
      } catch (err) {
        console.error("Gagal memuat artikel:", err);
      } finally {
        setLoading(false);
      }
    };
    fetchData();
  }, [slug]);

  // --- PERBAIKAN FUNGSI SUBMIT ---
  const handleSubmitComment = async (e) => {
    e.preventDefault();
    if (!user) return alert("Silakan login dulu!");

    setIsSubmitting(true);
    try {
      const payload = {
        article_id: article.id,
        rating: newRating,
        comment: newComment,
      };

      const res = await api.post("/reviews", payload);

      // Ambil data respons (sesuaikan dengan struktur API Laravel Anda)
      const savedId = res.data.data?.id || res.data.id || Date.now();

      const newReviewData = {
        id: savedId,
        user: user.name,
        rating: newRating,
        comment: newComment,
        date: "Baru saja",
      };

      // FIX: Handle jika prev.reviews null/undefined agar tidak crash
      setArticle((prev) => {
        const existingReviews = Array.isArray(prev.reviews) ? prev.reviews : [];
        return {
          ...prev,
          reviews: [newReviewData, ...existingReviews],
        };
      });

      setNewComment("");
      setNewRating(5);
      // Opsional: Hapus alert jika ingin UX lebih mulus
      // alert("Komentar berhasil dikirim!");
    } catch (err) {
      console.error(err);
      alert("Gagal mengirim komentar.");
    } finally {
      setIsSubmitting(false);
    }
  };

  if (loading) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-white dark:bg-gray-900">
        <Loader2 className="animate-spin text-primary" size={40} />
      </div>
    );
  }

  if (!article)
    return <div className="text-center py-20">Artikel Tidak Ditemukan</div>;

  return (
    <div className="min-h-screen bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-sans transition-colors duration-300">
      <Navbar toggleSidebar={() => {}} />

      <main className="pt-24 pb-12">
        {/* BREADCRUMB */}
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
            <span className="text-gray-900 dark:text-white font-medium truncate max-w-xs">
              {article.title}
            </span>
          </div>
        </div>

        <div className="container mx-auto px-4">
          <div className="grid grid-cols-1 lg:grid-cols-12 gap-12">
            {/* KOLOM KONTEN UTAMA */}
            <div className="lg:col-span-8">
              {/* HEADER ARTIKEL */}
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
                      {article.author}
                    </span>
                  </div>
                  <div className="flex items-center gap-2">
                    <Calendar size={16} />
                    <span>{article.date}</span>
                  </div>
                </div>
              </div>

              {/* IMAGE UTAMA */}
              <div className="mb-10 rounded-2xl overflow-hidden shadow-xl aspect-video">
                <img
                  src={article.image}
                  alt={article.title}
                  className="w-full h-full object-cover"
                  onError={(e) => {
                    e.target.src = "https://placehold.co/800x600?text=No+Image";
                  }}
                />
              </div>

              {/* ISI KONTEN */}
              <article
                className="prose prose-lg prose-blue dark:prose-invert max-w-none leading-relaxed text-gray-700 dark:text-gray-300"
                dangerouslySetInnerHTML={{
                  __html: article.fullContent || `<p>${article.summary}</p>`,
                }}
              />

              {/* TAGS & SHARE */}
              <div className="mt-12 pt-8 border-t border-gray-100 dark:border-gray-800 flex flex-col sm:flex-row justify-between items-center gap-6">
                <div className="flex items-center gap-2">
                  <Tag size={18} className="text-gray-400" />
                  <span className="text-sm font-semibold text-gray-900 dark:text-white">
                    Tags:
                  </span>
                  <div className="flex gap-2">
                    <span className="text-xs bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded-full text-gray-600 dark:text-gray-300 hover:bg-gray-200 cursor-pointer transition">
                      {article.category}
                    </span>
                  </div>
                </div>
                <button className="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-primary transition font-medium">
                  <Share2 size={18} /> Bagikan
                </button>
              </div>

              {/* BAGIAN KOMENTAR */}
              <div className="mt-16 pt-10 border-t-2 border-gray-100 dark:border-gray-800">
                <h3 className="text-2xl font-bold mb-8 text-gray-900 dark:text-white">
                  Diskusi & Komentar (
                  {article.reviews ? article.reviews.length : 0})
                </h3>

                {/* FORM INPUT KOMENTAR */}
                {user ? (
                  <div className="bg-gray-50 dark:bg-gray-800/50 p-6 rounded-2xl mb-10 border border-blue-100 dark:border-gray-700">
                    <h4 className="font-bold mb-4 flex items-center gap-2 text-gray-900 dark:text-white">
                      <span className="bg-primary text-white text-xs px-2 py-1 rounded">
                        Hai, {user.name}
                      </span>
                      Tulis pendapatmu
                    </h4>
                    <form onSubmit={handleSubmitComment}>
                      <div className="mb-3">
                        <label className="text-xs uppercase font-bold text-gray-500 mb-1 block">
                          Rating Artikel
                        </label>
                        <div className="flex gap-2">
                          {[1, 2, 3, 4, 5].map((star) => (
                            <button
                              type="button"
                              key={star}
                              onClick={() => setNewRating(star)}
                              className={`text-2xl transition ${
                                star <= newRating
                                  ? "text-yellow-400 scale-110"
                                  : "text-gray-300"
                              }`}
                            >
                              ★
                            </button>
                          ))}
                        </div>
                      </div>

                      <div className="mb-3">
                        <textarea
                          className="w-full p-3 rounded-xl border dark:bg-gray-700 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-primary text-gray-900 dark:text-white"
                          rows="3"
                          placeholder="Apa pendapatmu tentang artikel ini?"
                          value={newComment}
                          onChange={(e) => setNewComment(e.target.value)}
                          required
                        ></textarea>
                      </div>
                      <button
                        disabled={isSubmitting}
                        className="bg-primary text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition disabled:opacity-50"
                      >
                        {isSubmitting ? "Mengirim..." : "Kirim Komentar"}
                      </button>
                    </form>
                  </div>
                ) : (
                  <div className="bg-orange-50 dark:bg-orange-900/20 p-6 rounded-2xl mb-10 text-center border border-orange-100 dark:border-orange-800">
                    <p className="text-gray-600 dark:text-gray-300 mb-3">
                      Ingin ikut berdiskusi?
                    </p>
                    <Link
                      to="/login"
                      className="inline-block bg-white text-gray-900 border border-gray-200 px-6 py-2 rounded-full font-bold shadow-sm hover:bg-gray-50 transition"
                    >
                      Login untuk Berkomentar
                    </Link>
                  </div>
                )}

                {/* LIST KOMENTAR */}
                {article.reviews && article.reviews.length > 0 ? (
                  <div className="space-y-6">
                    {article.reviews.map((review) => (
                      <div
                        key={review.id}
                        className="bg-white border border-gray-100 dark:bg-gray-800/30 dark:border-gray-700 p-6 rounded-2xl shadow-sm"
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
                        <p className="text-gray-600 dark:text-gray-300 pl-14">
                          {review.comment}
                        </p>
                      </div>
                    ))}
                  </div>
                ) : (
                  <p className="text-gray-500 italic text-center py-8">
                    Belum ada komentar. Jadilah yang pertama!
                  </p>
                )}
              </div>
            </div>

            {/* SIDEBAR (TRENDING) */}
            <aside className="lg:col-span-4 space-y-8">
              <div className="bg-gray-50 dark:bg-gray-800/50 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 sticky top-28">
                <h3 className="text-lg font-bold mb-6 flex items-center gap-2 border-b border-gray-200 dark:border-gray-700 pb-2">
                  <span className="w-1 h-5 bg-accent rounded-full"></span>{" "}
                  Sedang Hangat
                </h3>
                <div className="space-y-6">
                  {trendingArticles.map((item, idx) => (
                    <Link
                      key={item.id}
                      to={`/artikel/${item.slug}`}
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
