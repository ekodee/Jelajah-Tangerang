import React, { useState, useEffect } from "react";
import { useParams, Link } from "react-router-dom";
import Navbar from "../components/Navbar";
import Footer from "../components/Footer";
import {
  Calendar,
  ArrowLeft,
  Share2,
  Tag,
  ArrowRight,
  Loader2,
} from "lucide-react";
import api from "../api";

const ArticleDetail = () => {
  const { slug } = useParams(); // Ambil SLUG dari URL
  const [article, setArticle] = useState(null);
  const [trendingArticles, setTrendingArticles] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    window.scrollTo(0, 0);
  }, [slug]);

  useEffect(() => {
    const fetchData = async () => {
      try {
        setLoading(true);
        // Fetch pakai slug
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

      {/* FIX TAMPILAN: pt-24 agar tidak ketabrak Navbar */}
      <main className="pt-24 pb-12">
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
            <div className="lg:col-span-8">
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

              <article
                className="prose prose-lg prose-blue dark:prose-invert max-w-none leading-relaxed text-gray-700 dark:text-gray-300"
                dangerouslySetInnerHTML={{
                  __html: article.fullContent || `<p>${article.summary}</p>`,
                }}
              />

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
            </div>

            <aside className="lg:col-span-4 space-y-8">
              <div className="bg-gray-50 dark:bg-gray-800/50 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 sticky top-28">
                <h3 className="text-lg font-bold mb-6 flex items-center gap-2 border-b border-gray-200 dark:border-gray-700 pb-2">
                  <span className="w-1 h-5 bg-accent rounded-full"></span>{" "}
                  Sedang Hangat
                </h3>
                <div className="space-y-6">
                  {trendingArticles.map((item, idx) => (
                    // UPDATE: Link ke Slug
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
