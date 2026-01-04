import React from "react";
import { X } from "lucide-react";

const Sidebar = ({ isOpen, onClose, categories }) => {
  return (
    <>
      {/* Overlay Hitam (Hanya Mobile) */}
      <div
        className={`fixed inset-0 bg-black/50 z-40 lg:hidden transition-opacity duration-300 ${
          isOpen ? "opacity-100 visible" : "opacity-0 invisible"
        }`}
        onClick={onClose}
      />

      {/* Sidebar Container */}
      <aside
        className={`
        fixed lg:sticky top-0 lg:top-24 left-0 h-full lg:h-[calc(100vh-8rem)] 
        w-64 bg-white dark:bg-gray-800 shadow-2xl lg:shadow-none lg:border-r border-gray-100 dark:border-gray-700
        transform transition-transform duration-300 ease-in-out z-50 lg:z-0
        p-6 overflow-y-auto
        ${isOpen ? "translate-x-0" : "-translate-x-full lg:translate-x-0"}
      `}
      >
        {/* Header Mobile */}
        <div className="flex justify-between items-center lg:hidden mb-8">
          <span className="text-lg font-bold">Menu</span>
          <button onClick={onClose} className="p-1 hover:bg-gray-100 rounded">
            <X size={20} />
          </button>
        </div>

        {/* Isi Sidebar */}
        <div>
          <h3 className="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">
            Kategori
          </h3>
          <ul className="space-y-2">
            {categories.map((cat, index) => (
              <li key={index}>
                <a
                  href="#"
                  className="block px-3 py-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-blue-50 hover:text-primary dark:hover:bg-gray-700 transition-colors text-sm font-medium"
                >
                  {cat}
                </a>
              </li>
            ))}
          </ul>
        </div>

        {/* Banner Promo Kecil di Sidebar (Opsional) */}
        <div className="mt-10 p-4 bg-blue-50 dark:bg-gray-700 rounded-xl">
          <p className="text-xs text-primary dark:text-blue-300 font-bold mb-1">
            Event Minggu Ini
          </p>
          <p className="text-xs text-gray-600 dark:text-gray-300">
            Jangan lewatkan Car Free Day di Tugu Adipura.
          </p>
        </div>
      </aside>
    </>
  );
};

export default Sidebar;
