import React from "react";
import { ArrowRight, Calendar, MapPin } from "lucide-react"; // Tambahkan MapPin jika ingin ikon lokasi
import { Link } from "react-router-dom";

const Card = ({
  id,
  image,
  title,
  subtitle,
  category,
  date,
  type = "article",
}) => {
  return (
    <div className="group flex flex-col h-full bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 hover:border-gray-200 dark:hover:border-gray-600 rounded-2xl overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
      <div className="relative h-56 overflow-hidden bg-gray-100">
        <img
          src={image}
          alt={title}
          className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
        />
        <div className="absolute top-4 left-4">
          <span className="bg-white/90 backdrop-blur-sm text-gray-900 text-xs font-semibold px-3 py-1 rounded-full shadow-sm">
            {category}
          </span>
        </div>
      </div>

      <div className="p-6 flex flex-col grow">
        {date && (
          <div className="flex items-center gap-2 text-gray-400 text-xs font-medium mb-3">
            <Calendar size={14} />
            <span>{date}</span>
          </div>
        )}

        <h3 className="text-lg font-bold text-gray-900 dark:text-white mb-3 leading-snug group-hover:text-primary transition-colors">
          {title}
        </h3>

        {type === "article" ? (
          <p className="text-gray-500 dark:text-gray-400 text-sm line-clamp-2 leading-relaxed mb-6 grow">
            {subtitle}
          </p>
        ) : (
          <div className="text-primary font-medium text-sm mb-4 grow flex items-center gap-1">
            {/* Opsional: Tambah ikon lokasi biar lebih cantik */}
            <MapPin size={14} />
            {subtitle || "Kota Tangerang"}
          </div>
        )}

        <div className="pt-4 border-t border-gray-50 dark:border-gray-700 mt-auto">
          {/* UBAH DISINI: Menggunakan Link untuk KEDUA tipe */}
          <Link
            to={type === "article" ? `/artikel/${id}` : `/destinasi/${id}`}
            className="flex items-center gap-2 text-sm font-semibold text-gray-900 dark:text-white group-hover:text-primary transition-colors"
          >
            {type === "article" ? "Baca Artikel" : "Lihat Detail"}
            <ArrowRight
              size={16}
              className="transition-transform group-hover:translate-x-1"
            />
          </Link>
        </div>
      </div>
    </div>
  );
};

export default Card;
