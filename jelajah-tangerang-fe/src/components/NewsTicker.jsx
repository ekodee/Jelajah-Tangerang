import React from "react";

const NewsTicker = () => {
  return (
    <div className="bg-primary text-white text-xs md:text-sm py-2 overflow-hidden relative z-50 border-b border-blue-600">
      <div className="container mx-auto px-4 flex items-center">
        <span className="font-bold bg-primary z-10 pr-4 shrink-0 uppercase tracking-wider flex items-center gap-2">
          <span className="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
          Live Update:
        </span>

        <div className="overflow-hidden w-full">
          <div className="whitespace-nowrap animate-marquee flex gap-16 font-medium">
            <span>
              Cuaca Tangerang: Cerah Berawan, 30°C. Cocok untuk wisata taman.
            </span>
            <span>
              Breaking: Festival Cisadane resmi dibuka mulai pukul 08.00 WIB.
            </span>
            <span>
              Info Lalin: Jalan Daan Mogot arah Pasar Lama terpantau padat
              merayap.
            </span>
            <span>
              Promo: Diskon 50% tiket masuk Water World untuk pemilik KTP
              Tangerang.
            </span>
          </div>
        </div>
      </div>
    </div>
  );
};

export default NewsTicker;
