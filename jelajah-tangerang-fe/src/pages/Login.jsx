import React, { useState, useContext } from 'react';
import { AuthContext } from '../context/AuthContext';
import { useNavigate, Link, useSearchParams } from 'react-router-dom';
import Navbar from '../components/Navbar';
import { Mail, Lock, AlertCircle, CheckCircle, RefreshCw } from 'lucide-react';
import api from '../api'; // Import API untuk request resend

const Login = () => {
  const { login } = useContext(AuthContext);
  const navigate = useNavigate();
  const [searchParams] = useSearchParams();

  // State Form
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  
  // State Status
  const [error, setError] = useState('');
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [resendStatus, setResendStatus] = useState(''); // Untuk pesan sukses resend
  const [needsVerification, setNeedsVerification] = useState(false); // Trigger tombol resend

  const isVerified = searchParams.get('verified') === '1';
  const verifyError = searchParams.get('error');

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');
    setResendStatus('');
    setNeedsVerification(false);
    setIsSubmitting(true);

    const result = await login(email, password);

    if (result.success) {
      navigate('/');
    } else {
      setError(result.message || 'Email atau password salah.');
      
      // Deteksi jika pesan error mengandung kata "verifikasi" (dari Controller Auth kita tadi)
      // Pastikan pesan error di Controller mengandung kata "verifikasi" atau cek status code 403
      if (result.message && result.message.toLowerCase().includes('verifikasi')) {
        setNeedsVerification(true);
      }
    }
    setIsSubmitting(false);
  };

  // Fungsi Kirim Ulang Email
  const handleResendEmail = async () => {
    try {
      setResendStatus('Mengirim ulang...');
      await api.post('/email/verification-notification', { email });
      setResendStatus('Link verifikasi baru telah dikirim! Cek inbox/spam.');
      setNeedsVerification(false); // Hilangkan tombol setelah kirim
    } catch (err) {
      setResendStatus('Gagal mengirim ulang. Coba sesaat lagi.');
    }
  };

  return (
    <div className="min-h-screen bg-gray-50 dark:bg-gray-900 font-sans transition-colors duration-300">
      <Navbar toggleSidebar={() => {}} />

      <div className="flex items-center justify-center min-h-screen pt-20 px-4">
        <div className="w-full max-w-md bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 border border-gray-100 dark:border-gray-700">
          
          <div className="text-center mb-8">
            <h1 className="text-3xl font-extrabold text-gray-900 dark:text-white mb-2">Selamat Datang</h1>
            <p className="text-gray-500 dark:text-gray-400">Masuk untuk mulai berbagi pengalaman.</p>
          </div>

          {/* ALERT SUKSES VERIFIKASI (Redirect dari Email) */}
          {isVerified && (
            <div className="mb-6 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded-xl flex items-start gap-3 text-sm animate-in fade-in slide-in-from-top-2">
              <CheckCircle className="shrink-0 mt-0.5" size={18} />
              <div><strong className="font-bold block">Akun Terverifikasi!</strong> Email Anda telah berhasil diverifikasi. Silakan login sekarang.</div>
            </div>
          )}

          {/* ALERT ERROR DARI URL */}
          {verifyError && (
             <div className="mb-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-300 px-4 py-3 rounded-xl flex items-start gap-3 text-sm">
               <AlertCircle className="shrink-0 mt-0.5" size={18} />
               <div>Link verifikasi tidak valid atau sudah kedaluwarsa.</div>
             </div>
          )}

          {/* ALERT ERROR LOGIN UTAMA */}
          {error && (
            <div className="mb-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-300 px-4 py-3 rounded-xl flex flex-col gap-2 text-sm animate-shake">
              <div className="flex items-center gap-2">
                <AlertCircle size={18} />
                <span>{error}</span>
              </div>
              
              {/* TOMBOL RESEND MUNCUL DISINI */}
              {needsVerification && (
                <button 
                  onClick={handleResendEmail}
                  className="mt-1 text-sm font-bold underline hover:text-red-800 dark:hover:text-red-200 text-left flex items-center gap-1 w-fit"
                >
                  <RefreshCw size={14} /> Kirim ulang link verifikasi?
                </button>
              )}
            </div>
          )}

          {/* ALERT SUKSES RESEND */}
          {resendStatus && (
             <div className="mb-6 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 text-blue-700 dark:text-blue-300 px-4 py-3 rounded-xl flex items-center gap-2 text-sm">
               <Mail size={18} />
               <span>{resendStatus}</span>
             </div>
          )}

          <form onSubmit={handleSubmit} className="space-y-5">
            <div>
              <label className="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Email</label>
              <div className="relative">
                <Mail className="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" size={20} />
                <input 
                  type="email" 
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  className="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary/50 focus:border-primary focus:outline-none transition-all"
                  placeholder="nama@email.com"
                  required 
                />
              </div>
            </div>

            <div>
              <label className="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Password</label>
              <div className="relative">
                <Lock className="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" size={20} />
                <input 
                  type="password" 
                  value={password}
                  onChange={(e) => setPassword(e.target.value)}
                  className="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary/50 focus:border-primary focus:outline-none transition-all"
                  placeholder="••••••••"
                  required 
                />
              </div>
            </div>

            <button 
              type="submit" 
              disabled={isSubmitting}
              className="w-full bg-primary hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl transition-all shadow-lg hover:shadow-blue-500/30 active:scale-95 disabled:opacity-70 disabled:cursor-not-allowed mt-2"
            >
              {isSubmitting ? 'Memproses...' : 'Masuk Sekarang'}
            </button>
          </form>

          <div className="mt-8 text-center">
            <p className="text-sm text-gray-500 dark:text-gray-400">
              Belum punya akun?{' '}
              <Link to="/register" className="text-primary font-bold hover:underline transition-colors">
                Daftar Gratis di sini
              </Link>
            </p>
          </div>

        </div>
      </div>
    </div>
  );
};

export default Login;