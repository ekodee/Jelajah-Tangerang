import React, { useState, useEffect, useContext } from "react"; // Tambah useContext
import { Link, useLocation } from "react-router-dom";
import { Menu, X, Moon, Sun } from "lucide-react";
import Button from "./Button";
import { AuthContext } from "../context/AuthContext"; // Import AuthContext

const Navbar = ({ toggleSidebar }) => {
  const [isScrolled, setIsScrolled] = useState(false);
  const [isDarkMode, setIsDarkMode] = useState(false);
  const location = useLocation();

  // Ambil state user dan fungsi logout dari Context
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

        {/* DESKTOP MENU */}
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

        {/* ACTION BUTTONS (Login/Logout & Dark Mode) */}
        <div className="hidden md:flex items-center gap-4">
          <button
            onClick={() => setIsDarkMode(!isDarkMode)}
            className="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300 transition-colors"
          >
            {isDarkMode ? <Sun size={20} /> : <Moon size={20} />}
          </button>

          {/* LOGIC LOGIN/LOGOUT */}
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

        {/* MOBILE MENU TOGGLE */}
        <button
          className="md:hidden text-gray-900 dark:text-white"
          onClick={toggleSidebar}
        >
          <Menu size={28} />
        </button>
      </div>
    </nav>
  );
};

export default Navbar;
