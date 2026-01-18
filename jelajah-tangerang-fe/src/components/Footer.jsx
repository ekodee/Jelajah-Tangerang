import React from "react";
import Button from "./Button";
import {
  Facebook,
  Instagram,
  Twitter,
  Youtube,
  Mail,
  MapPin,
} from "lucide-react";

const Footer = () => {
  return (
    <footer className="bg-gray-950 text-white pt-20 pb-10 border-t border-gray-900">
      <div className="container mx-auto px-4">
        <div className="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-10 mb-16">
          <div className="max-w-md">
            <h2 className="text-2xl font-bold mb-4 tracking-tight">
              Jelajah<span className="text-primary">Tangerang</span>.
            </h2>
            <p className="text-gray-400 leading-relaxed">
              Platform panduan wisata nomor satu di Tangerang. Temukan keindahan
              tersembunyi dan cerita menarik dari setiap sudut kota.
            </p>
          </div>

          <div className="w-full lg:w-auto">
            <h3 className="font-semibold mb-3 text-sm uppercase tracking-wider text-gray-500">
              Berlangganan Info Terbaru
            </h3>
            <div className="flex gap-2">
              <input
                type="email"
                placeholder="Alamat email anda..."
                className="bg-gray-900 border border-gray-800 text-white px-4 py-3 rounded-lg focus:outline-none focus:border-primary w-full lg:w-80 transition-colors"
              />
              <Button variant="primary" className="rounded-lg">
                Kirim
              </Button>
            </div>
          </div>
        </div>

        <hr className="border-gray-800 mb-12" />

        <div className="grid grid-cols-2 md:grid-cols-4 gap-8 mb-16">
          <div>
            <h4 className="text-white font-bold mb-6">Eksplorasi</h4>
            <ul className="space-y-4 text-gray-400">
              <li>
                <a href="#" className="hover:text-primary transition-colors">
                  Destinasi Wisata
                </a>
              </li>
              <li>
                <a href="#" className="hover:text-primary transition-colors">
                  Kuliner Legendaris
                </a>
              </li>
              <li>
                <a href="#" className="hover:text-primary transition-colors">
                  Event & Festival
                </a>
              </li>
              <li>
                <a href="#" className="hover:text-primary transition-colors">
                  Hotel & Penginapan
                </a>
              </li>
            </ul>
          </div>

          <div>
            <h4 className="text-white font-bold mb-6">Perusahaan</h4>
            <ul className="space-y-4 text-gray-400">
              <li>
                <a href="#" className="hover:text-primary transition-colors">
                  Tentang Kami
                </a>
              </li>
              <li>
                <a href="#" className="hover:text-primary transition-colors">
                  Karir
                </a>
              </li>
              <li>
                <a href="#" className="hover:text-primary transition-colors">
                  Partner
                </a>
              </li>
              <li>
                <a href="#" className="hover:text-primary transition-colors">
                  Kontak
                </a>
              </li>
            </ul>
          </div>

          <div>
            <h4 className="text-white font-bold mb-6">Bantuan</h4>
            <ul className="space-y-4 text-gray-400">
              <li>
                <a href="#" className="hover:text-primary transition-colors">
                  FAQ
                </a>
              </li>
              <li>
                <a href="#" className="hover:text-primary transition-colors">
                  Syarat & Ketentuan
                </a>
              </li>
              <li>
                <a href="#" className="hover:text-primary transition-colors">
                  Kebijakan Privasi
                </a>
              </li>
              <li>
                <a href="#" className="hover:text-primary transition-colors">
                  Peta Situs
                </a>
              </li>
            </ul>
          </div>

          <div>
            <h4 className="text-white font-bold mb-6">Kantor</h4>
            <ul className="space-y-4 text-gray-400">
              <li className="flex items-start gap-3">
                <MapPin className="shrink-0 text-primary" size={20} />
                <span className="text-sm">
                  Perum 2, Kec. Kelapa Dua,
                  Tangerang, Banten
                </span>
              </li>
              <li className="flex items-center gap-3">
                <Mail className="shrink-0 text-primary" size={20} />
                <span className="text-sm">hello@jelajahtangerang.id</span>
              </li>
            </ul>
          </div>
        </div>

        <div className="flex flex-col md:flex-row justify-between items-center pt-8 border-t border-gray-800">
          <p className="text-gray-500 text-sm mb-4 md:mb-0">
            © 2025 Jelajah Tangerang. All rights reserved.
          </p>

          <div className="flex gap-6">
            <a
              href="#"
              className="text-gray-400 hover:text-white transition-colors p-2 hover:bg-gray-800 rounded-full"
            >
              <Instagram size={20} />
            </a>
            <a
              href="#"
              className="text-gray-400 hover:text-white transition-colors p-2 hover:bg-gray-800 rounded-full"
            >
              <Twitter size={20} />
            </a>
            <a
              href="#"
              className="text-gray-400 hover:text-white transition-colors p-2 hover:bg-gray-800 rounded-full"
            >
              <Facebook size={20} />
            </a>
            <a
              href="#"
              className="text-gray-400 hover:text-white transition-colors p-2 hover:bg-gray-800 rounded-full"
            >
              <Youtube size={20} />
            </a>
          </div>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
