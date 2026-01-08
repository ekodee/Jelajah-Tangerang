import React from "react";
import { Routes, Route } from "react-router-dom";
import Home from "./pages/Home";
import Articles from "./pages/Articles";
import ArticleDetail from "./pages/ArticleDetail";
import Destinations from "./pages/Destinations";
import DestinationDetail from "./pages/DestinationDetail";
import About from "./pages/About";
import Login from "./pages/Login";
import Register from "./pages/Register";

const App = () => {
  return (
    <Routes>
      <Route path="/" element={<Home />} />
      <Route path="/artikel" element={<Articles />} />
      <Route path="/artikel/:slug" element={<ArticleDetail />} />
      <Route path="/destinasi" element={<Destinations />} />
      <Route path="/destinasi/:slug" element={<DestinationDetail />} />
      <Route path="/about" element={<About />} />

      {/* ROUTE AUTH */}
      <Route path="/login" element={<Login />} />
      <Route path="/register" element={<Register />} />
    </Routes>
  );
};

export default App;
