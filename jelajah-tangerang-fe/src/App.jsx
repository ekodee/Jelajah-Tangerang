import React from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";

// Import Semua Halaman
import Home from "./pages/Home";
import Articles from "./pages/Articles";
import ArticleDetail from "./pages/ArticleDetail";
import Destinations from "./pages/Destinations"; // Import Destinasi
import About from "./pages/About"; // Import Tentang
import DestinationDetail from "./pages/DestinationDetail";

function App() {
  return (
    <Router>
      <Routes>
        <Route path="/" element={<Home />} />

        {/* Routes Artikel */}
        <Route path="/artikel" element={<Articles />} />
        <Route path="/artikel/:id" element={<ArticleDetail />} />

        {/* Route Destinasi */}
        <Route path="/destinasi" element={<Destinations />} />
        <Route path="/destinasi/:id" element={<DestinationDetail />} />

        {/* Route Tentang */}
        <Route path="/tentang" element={<About />} />
      </Routes>
    </Router>
  );
}

export default App;
