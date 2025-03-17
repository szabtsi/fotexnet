import { StrictMode } from "react";
import { createRoot } from "react-dom/client";
import App from "./pages/App.jsx";
import { BrowserRouter, Routes, Route } from "react-router";
import AppLayout from "./components/Layout.jsx";
import Movie from "./pages/Movie.jsx";
import "./index.css";

createRoot(document.getElementById("root")).render(
    <StrictMode>
        <BrowserRouter>
            <Routes>
                <Route element={<AppLayout />}>
                    <Route path="/" element={<App />} />
                    <Route path="/movies/:id" element={<Movie />} />
                </Route>
            </Routes>
        </BrowserRouter>
    </StrictMode>
);
