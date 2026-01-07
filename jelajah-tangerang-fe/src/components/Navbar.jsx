import React, { useState, useEffect } from "react";
import { Link, NavLink, useLocation } from "react-router-dom";
import { Menu, Moon, Sun, Search, Bell } from "lucide-react";
import Button from "./Button";

const Navbar = ({ toggleSidebar }) => {
  const [isDark, setIsDark] = useState(false);
  const [scrolled, setScrolled] = useState(false);
  const location = useLocation();

  useEffect(() => {
    const handleScroll = () => setScrolled(window.scrollY > 20);
    window.addEventListener("scroll", handleScroll);
    return () => window.removeEventListener("scroll", handleScroll);
  }, []);

  useEffect(() => {
    document.documentElement.classList.toggle("dark", isDark);
  }, [isDark]);

  const navLinkClass = ({ isActive }) =>
    `text-sm font-semibold transition-all duration-300 relative group ${
      isActive
        ? "text-primary"
        : "text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-primary"
    }`;

  return (
    <nav
      className={`fixed top-0 w-full z-50 transition-all duration-300 ${
        scrolled
          ? "bg-white/90 backdrop-blur-lg border-b border-gray-100 dark:border-gray-800 py-3 shadow-sm"
          : "bg-white/50 backdrop-blur-sm py-5 border-b border-transparent dark:bg-gray-900/50"
      } dark:text-white`}
    >
      <div className="container mx-auto px-4 flex justify-between items-center">
        <div className="flex items-center gap-3">
          <button
            onClick={toggleSidebar}
            className="lg:hidden p-2 -ml-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
            aria-label="Menu"
          >
            <Menu size={22} className="text-gray-700 dark:text-white" />
          </button>

          <Link to="/" className="group flex items-center gap-2">
            <span className="text-4xl font-bold tracking-tight text-gray-900 dark:text-white">
              Jelajah<span className="text-primary">Tangerang</span>.
            </span>
          </Link>
        </div>

        <div className="hidden lg:flex items-center gap-8">
          {[
            { path: "/", label: "Beranda" },
            { path: "/artikel", label: "Berita & Artikel" },
            { path: "/destinasi", label: "Destinasi" },
            { path: "/tentang", label: "Tentang Kami" },
          ].map((link) => (
            <NavLink key={link.path} to={link.path} className={navLinkClass}>
              {({ isActive }) => (
                <>
                  {link.label}
                  <span
                    className={`absolute -bottom-1 left-1/2 w-1 h-1 bg-primary rounded-full transform -translate-x-1/2 transition-all duration-300 ${
                      isActive
                        ? "opacity-100 scale-100"
                        : "opacity-0 scale-0 group-hover:opacity-50"
                    }`}
                  ></span>
                </>
              )}
            </NavLink>
          ))}
        </div>

        <div className="flex items-center gap-1 sm:gap-3">
          <button className="p-2 rounded-full text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors">
            <Search size={20} />
          </button>

          <div className="h-6 w-px bg-gray-200 dark:bg-gray-700 mx-1 hidden sm:block"></div>

          <button
            onClick={() => setIsDark(!isDark)}
            className="p-2 rounded-full text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors"
            aria-label="Toggle Theme"
          >
            {isDark ? (
              <Sun size={20} className="text-yellow-400" />
            ) : (
              <Moon size={20} />
            )}
          </button>

          <div className="hidden sm:block ml-2">
            <Button
              variant="primary"
              className="rounded-full px-6 py-2.5 text-sm font-semibold shadow-lg shadow-blue-500/20 hover:shadow-blue-500/40 transition-all transform hover:-translate-y-0.5"
            >
              Masuk
            </Button>
          </div>
        </div>
      </div>
    </nav>
  );
};

export default Navbar;
