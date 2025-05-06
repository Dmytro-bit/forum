import React from "react";

export default function Home() {
    return (
        <main className="flex flex-col items-center justify-center min-h-screen p-4">
            <h1 className="text-4xl font-bold mb-4">Welcome to Our Website</h1>
            <p className="text-lg text-gray-700 mb-6 max-w-xl text-center">
                This is the homepage of your new React app. Explore our features, learn more about us, and get started
                with what we have to offer.
            </p>
            <div className="flex gap-4">
                <button className="px-6 py-2 bg-blue-600 text-white rounded-2xl shadow hover:bg-blue-700 transition">
                    Get Started
                </button>
                <button className="px-6 py-2 bg-gray-200 text-gray-800 rounded-2xl shadow hover:bg-gray-300 transition">
                    Learn More
                </button>
            </div>
        </main>
    );
}
