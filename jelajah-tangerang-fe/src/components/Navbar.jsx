import React, { useState, useEffect, useContext } from "react";
import { Link, useLocation } from "react-router-dom";
import { Menu, X, Moon, Sun } from "lucide-react"; // Import Icon X untuk tutup menu
import Button from "./Button";
import { AuthContext } from "../context/AuthContext";

const Navbar = () => {
  const [isScrolled, setIsScrolled] = useState(false);
  const [isDarkMode, setIsDarkMode] = useState(false);

  // STATE BARU: Untuk mengatur buka/tutup menu mobile
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);

  const location = useLocation();
  const { user, logout } = useContext(AuthContext);

  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 20);
    };
    window.addEventListener("scroll", handleScroll);
    return () => window.removeEventListener("scroll", handleScroll);
  }, []);

  useEffect(() => {
    if (isDarkMode) {
      document.documentElement.classList.add("dark");
    } else {
      document.documentElement.classList.remove("dark");
    }
  }, [isDarkMode]);

  // Tutup menu mobile setiap kali pindah halaman (klik link)
  useEffect(() => {
    setIsMobileMenuOpen(false);
  }, [location]);

  const navLinks = [
    { name: "Beranda", path: "/" },
    { name: "Berita & Artikel", path: "/artikel" },
    { name: "Destinasi", path: "/destinasi" },
    { name: "Tentang Kami", path: "/about" },
  ];

  const isActive = (path) => location.pathname === path;

  return (
    <nav
      className={`fixed top-0 left-0 right-0 z-50 transition-all duration-300 ${
        isScrolled
          ? "bg-white/80 dark:bg-gray-900/80 backdrop-blur-md shadow-md py-3"
          : "bg-white dark:bg-gray-900 py-5"
      }`}
    >
      <div className="container mx-auto px-4 flex justify-between items-center">
        {/* LOGO */}
        <Link
          to="/"
          className="text-2xl font-black tracking-tighter text-gray-900 dark:text-white flex items-center gap-1"
        >
          Jelajah<span className="text-primary">Tangerang</span>.
        </Link>

        {/* DESKTOP MENU (Hidden on Mobile) */}
        <div className="hidden md:flex items-center gap-8">
          {navLinks.map((link) => (
            <Link
              key={link.name}
              to={link.path}
              className={`text-sm font-medium transition-colors hover:text-primary ${
                isActive(link.path)
                  ? "text-primary font-bold"
                  : "text-gray-600 dark:text-gray-300"
              }`}
            >
              {link.name}
            </Link>
          ))}
        </div>

        {/* DESKTOP ACTION BUTTONS (Hidden on Mobile) */}
        <div className="hidden md:flex items-center gap-4">
          <button
            onClick={() => setIsDarkMode(!isDarkMode)}
            className="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300 transition-colors"
          >
            {isDarkMode ? <Sun size={20} /> : <Moon size={20} />}
          </button>

          {user ? (
            <div className="flex items-center gap-3 border-l pl-4 border-gray-200 dark:border-gray-700">
              <div className="text-right hidden lg:block">
                <p className="text-xs text-gray-500">Halo,</p>
                <p className="text-sm font-bold text-gray-900 dark:text-white leading-none">
                  {user.name}
                </p>
              </div>
              <button
                onClick={logout}
                className="text-red-500 hover:text-red-700 text-sm font-bold bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-lg transition"
              >
                Logout
              </button>
            </div>
          ) : (
            <Link to="/login">
              <Button>Masuk</Button>
            </Link>
          )}
        </div>

        {/* MOBILE MENU TOGGLE BUTTON */}
        <button
          className="md:hidden text-gray-900 dark:text-white p-2"
          onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)}
        >
          {isMobileMenuOpen ? <X size={28} /> : <Menu size={28} />}
        </button>
      </div>

      {/* -------------------------------------------------- */}
      {/* MOBILE MENU DROPDOWN (TAMPILAN MENU HP)            */}
      {/* -------------------------------------------------- */}
      {isMobileMenuOpen && (
        <div className="md:hidden absolute top-full left-0 right-0 bg-white dark:bg-gray-900 shadow-lg border-t border-gray-100 dark:border-gray-800 p-4 flex flex-col gap-4 animate-fadeIn">
          {/* List Menu Mobile */}
          {navLinks.map((link) => (
            <Link
              key={link.name}
              to={link.path}
              className={`text-base font-medium py-2 px-4 rounded-lg transition-colors ${
                isActive(link.path)
                  ? "bg-primary/10 text-primary"
                  : "text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800"
              }`}
            >
              {link.name}
            </Link>
          ))}

          <hr className="border-gray-100 dark:border-gray-800" />

          {/* Action Buttons Mobile (Dark Mode & Auth) */}
          <div className="flex justify-between items-center px-4">
            <span className="text-sm text-gray-500">Mode Gelap</span>
            <button
              onClick={() => setIsDarkMode(!isDarkMode)}
              className="p-2 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300"
            >
              {isDarkMode ? <Sun size={20} /> : <Moon size={20} />}
            </button>
          </div>

          {user ? (
            <div className="flex flex-col gap-3 px-4">
              <div className="flex items-center gap-3">
                <div className="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center font-bold text-primary">
                  {user.name.charAt(0)}
                </div>
                <div>
                  <p className="text-sm font-bold text-gray-900 dark:text-white">
                    {user.name}
                  </p>
                  <p className="text-xs text-gray-500">Sedang Login</p>
                </div>
              </div>
              <button
                onClick={logout}
                className="w-full text-center text-red-500 hover:text-red-700 font-bold bg-red-50 dark:bg-red-900/20 px-4 py-3 rounded-lg transition"
              >
                Logout
              </button>
            </div>
          ) : (
            <div className="px-4">
              <Link to="/login" className="block w-full">
                <Button className="w-full justify-center">
                  Masuk / Daftar
                </Button>
              </Link>
            </div>
          )}
        </div>
      )}
    </nav>
  );
};

export default Navbar;
