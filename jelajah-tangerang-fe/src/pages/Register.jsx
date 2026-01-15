import React, { useState, useContext, useEffect } from "react";
import { AuthContext } from "../context/AuthContext";
import { useNavigate, Link } from "react-router-dom";
import Navbar from "../components/Navbar";
import {
  User,
  Mail,
  Lock,
  CheckCircle,
  Loader2,
  AlertCircle,
} from "lucide-react";

const Register = () => {
  const { register } = useContext(AuthContext);
  const navigate = useNavigate();

  const [formData, setFormData] = useState({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
  });

  const [errors, setErrors] = useState({});
  const [isLoading, setIsLoading] = useState(false);
  const [successMessage, setSuccessMessage] = useState("");

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
    // Hapus error spesifik saat user mulai ngetik ulang
    if (errors[e.target.name]) {
      setErrors({ ...errors, [e.target.name]: null });
    }
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setIsLoading(true);
    setErrors({});
    setSuccessMessage("");

    const result = await register(
      formData.name,
      formData.email,
      formData.password,
      formData.password_confirmation
    );

    if (result.success) {
      setSuccessMessage(
        "Registrasi berhasil! Silakan cek inbox email Anda untuk verifikasi."
      );

      // Reset form
      setFormData({
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
      });

      // Redirect otomatis ke Login setelah 3 detik
      setTimeout(() => {
        navigate("/login");
      }, 3000);
    } else {
      setErrors(result.errors || {});
    }

    setIsLoading(false);
  };

  // Scroll ke atas saat ada pesan sukses (biar kelihatan di HP)
  useEffect(() => {
    if (successMessage) window.scrollTo(0, 0);
  }, [successMessage]);

  return (
    <div className="min-h-screen bg-gray-50 dark:bg-gray-900 font-sans transition-colors duration-300">
      <Navbar toggleSidebar={() => {}} />

      <div className="flex items-center justify-center min-h-screen pt-24 px-4 pb-12">
        <div className="w-full max-w-md bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 border border-gray-100 dark:border-gray-700">
          <div className="text-center mb-8">
            <h1 className="text-3xl font-extrabold text-gray-900 dark:text-white mb-2">
              Buat Akun Baru
            </h1>
            <p className="text-gray-500 dark:text-gray-400">
              Gabung komunitas Jelajah Tangerang sekarang.
            </p>
          </div>

          {/* ALERT SUKSES (HIJAU) */}
          {successMessage && (
            <div className="mb-6 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-5 py-4 rounded-2xl flex items-start gap-3 shadow-sm animate-in fade-in slide-in-from-top-4">
              <CheckCircle
                className="shrink-0 mt-0.5 text-green-600 dark:text-green-400"
                size={24}
              />
              <div>
                <strong className="font-bold text-lg block mb-1">
                  Sukses!
                </strong>
                <p className="text-sm leading-relaxed">{successMessage}</p>
                <p className="text-xs mt-2 opacity-75 font-medium">
                  Mengalihkan ke halaman login...
                </p>
              </div>
            </div>
          )}

          {/* ALERT ERROR UMUM (JIKA ADA) */}
          {errors.general && (
            <div className="mb-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-300 px-4 py-3 rounded-xl flex items-center gap-2 text-sm">
              <AlertCircle size={18} />
              <span>{errors.general}</span>
            </div>
          )}

          <form onSubmit={handleSubmit} className="space-y-5">
            {/* INPUT NAMA */}
            <div>
              <label className="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                Nama Lengkap
              </label>
              <div className="relative">
                <User
                  className="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"
                  size={20}
                />
                <input
                  type="text"
                  name="name"
                  value={formData.name}
                  onChange={handleChange}
                  className={`w-full pl-12 pr-4 py-3 rounded-xl border bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:outline-none transition-all ${
                    errors.name
                      ? "border-red-500 focus:ring-red-200 focus:border-red-500"
                      : "border-gray-200 dark:border-gray-700 focus:ring-primary/50 focus:border-primary"
                  }`}
                  placeholder="John Doe"
                  required
                />
              </div>
              {errors.name && (
                <p className="text-red-500 text-xs mt-1 ml-1 font-medium">
                  {errors.name[0]}
                </p>
              )}
            </div>

            {/* INPUT EMAIL */}
            <div>
              <label className="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                Email
              </label>
              <div className="relative">
                <Mail
                  className="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"
                  size={20}
                />
                <input
                  type="email"
                  name="email"
                  value={formData.email}
                  onChange={handleChange}
                  className={`w-full pl-12 pr-4 py-3 rounded-xl border bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:outline-none transition-all ${
                    errors.email
                      ? "border-red-500 focus:ring-red-200 focus:border-red-500"
                      : "border-gray-200 dark:border-gray-700 focus:ring-primary/50 focus:border-primary"
                  }`}
                  placeholder="nama@email.com"
                  required
                />
              </div>
              {errors.email && (
                <p className="text-red-500 text-xs mt-1 ml-1 font-medium">
                  {errors.email[0]}
                </p>
              )}
            </div>

            {/* INPUT PASSWORD */}
            <div>
              <label className="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                Password
              </label>
              <div className="relative">
                <Lock
                  className="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"
                  size={20}
                />
                <input
                  type="password"
                  name="password"
                  value={formData.password}
                  onChange={handleChange}
                  className={`w-full pl-12 pr-4 py-3 rounded-xl border bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:outline-none transition-all ${
                    errors.password
                      ? "border-red-500 focus:ring-red-200 focus:border-red-500"
                      : "border-gray-200 dark:border-gray-700 focus:ring-primary/50 focus:border-primary"
                  }`}
                  placeholder="Minimal 8 karakter"
                  required
                />
              </div>
              {errors.password && (
                <p className="text-red-500 text-xs mt-1 ml-1 font-medium">
                  {errors.password[0]}
                </p>
              )}
            </div>

            {/* INPUT KONFIRMASI PASSWORD */}
            <div>
              <label className="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                Konfirmasi Password
              </label>
              <div className="relative">
                <CheckCircle
                  className="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"
                  size={20}
                />
                <input
                  type="password"
                  name="password_confirmation"
                  value={formData.password_confirmation}
                  onChange={handleChange}
                  className="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary/50 focus:border-primary focus:outline-none transition-all"
                  placeholder="Ulangi password"
                  required
                />
              </div>
            </div>

            <button
              type="submit"
              disabled={isLoading || successMessage} // Disable jika loading atau sudah sukses
              className="w-full bg-primary hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl transition-all shadow-lg hover:shadow-blue-500/30 active:scale-95 disabled:opacity-70 disabled:cursor-not-allowed mt-6 flex items-center justify-center gap-2"
            >
              {isLoading ? (
                <>
                  <Loader2 className="animate-spin" size={20} />
                  <span>Mendaftarkan...</span>
                </>
              ) : successMessage ? (
                <span>Berhasil Mendaftar</span>
              ) : (
                <span>Daftar Sekarang</span>
              )}
            </button>
          </form>

          <p className="mt-8 text-center text-sm text-gray-500 dark:text-gray-400">
            Sudah punya akun?{" "}
            <Link
              to="/login"
              className="text-primary font-bold hover:underline transition-colors"
            >
              Masuk di sini
            </Link>
          </p>
        </div>
      </div>
    </div>
  );
};

export default Register;
