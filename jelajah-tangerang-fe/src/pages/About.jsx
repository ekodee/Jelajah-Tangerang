import React from "react";
import Navbar from "../components/Navbar";
import Footer from "../components/Footer";

const About = () => {
  return (
    <div className="min-h-screen bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-sans">
      <Navbar toggleSidebar={() => {}} />

      <main className="pt-24 pb-12">
        {/* SECTION 1: Intro */}
        <section className="container mx-auto px-4 mb-20">
          <div className="max-w-3xl mx-auto text-center">
            <h1 className="text-4xl md:text-5xl font-extrabold mb-6">
              Mengenal <span className="text-primary">Jelajah Tangerang</span>
            </h1>
            <p className="text-lg text-gray-500 leading-relaxed">
              Jelajah Tangerang adalah inisiatif digital yang bertujuan untuk
              memperkenalkan potensi pariwisata, kekayaan budaya, dan dinamika
              kota Tangerang kepada dunia luar. Kami percaya setiap sudut kota
              punya cerita.
            </p>
          </div>
        </section>

        {/* SECTION 2: Visi & Misi (Grid) */}
        <section className="bg-gray-50 dark:bg-gray-800/50 py-16 mb-20">
          <div className="container mx-auto px-4">
            <div className="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
              <div className="rounded-2xl overflow-hidden shadow-2xl rotate-2 hover:rotate-0 transition-transform duration-500">
                <img
                  src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80&w=800"
                  alt="Team working"
                  className="w-full h-full object-cover"
                />
              </div>
              <div>
                <h3 className="text-2xl font-bold mb-4 flex items-center gap-3">
                  <span className="w-8 h-1 bg-primary block rounded-full"></span>
                  Visi Kami
                </h3>
                <p className="text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                  Menjadi portal informasi wisata terdepan yang berkontribusi
                  nyata dalam meningkatkan ekonomi kreatif dan kunjungan
                  wisatawan di Tangerang Raya pada tahun 2030.
                </p>

                <h3 className="text-2xl font-bold mb-4 flex items-center gap-3">
                  <span className="w-8 h-1 bg-accent block rounded-full"></span>
                  Misi Kami
                </h3>
                <ul className="space-y-3 text-gray-600 dark:text-gray-300">
                  <li className="flex items-start gap-2">
                    Menyajikan informasi akurat dan terkini.
                  </li>
                  <li className="flex items-start gap-2">
                    Mempromosikan UMKM lokal melalui liputan digital.
                  </li>
                  <li className="flex items-start gap-2">
                    Mengedukasi masyarakat tentang sejarah lokal.
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </section>

        {/* SECTION 3: Tim Pengembang (Dummy) */}
        <section className="container mx-auto px-4 text-center">
          <h2 className="text-3xl font-bold mb-10">Tim Di Balik Layar</h2>
          <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            {/* Card Member 1 */}
            <div className="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 hover:shadow-lg transition">
              <div className="w-24 h-24 mx-auto bg-gray-200 rounded-full mb-4 overflow-hidden">
                {/* <img
                  src="https://ui-avatars.com/api/?name=Rizky+F&background=2563EB&color=fff"
                  alt="Member"
                /> */}
              </div>
              <h4 className="font-bold text-lg">Muhamad Safii</h4>
              <p className="text-primary text-sm font-medium">Lead Developer</p>
            </div>
            {/* Card Member 2 */}
            <div className="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 hover:shadow-lg transition">
              <div className="w-24 h-24 mx-auto bg-gray-200 rounded-full mb-4 overflow-hidden">
                {/* <img
                  src="https://ui-avatars.com/api/?name=Sarah+A&background=F97316&color=fff"
                  alt="Member"
                /> */}
              </div>
              <h4 className="font-bold text-lg">Muhamad Safii</h4>
              <p className="text-accent text-sm font-medium">Content Editor</p>
            </div>
            {/* Card Member 3 */}
            <div className="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 hover:shadow-lg transition">
              <div className="w-24 h-24 mx-auto bg-gray-200 rounded-full mb-4 overflow-hidden">
                {/* <img
                  src="https://ui-avatars.com/api/?name=Budi+S&background=10B981&color=fff"
                  alt="Member"
                /> */}
              </div>
              <h4 className="font-bold text-lg">Muhamad Safii</h4>
              <p className="text-green-500 text-sm font-medium">
                UI/UX Designer
              </p>
            </div>
          </div>
        </section>
      </main>
      <Footer />
    </div>
  );
};

export default About;
