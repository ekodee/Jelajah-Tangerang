import axios from "axios";

const api = axios.create({
  // URL Backend Laravel Anda
  baseURL: "http://localhost:8000/api",
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
});

export default api;
