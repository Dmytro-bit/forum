import React from 'react';
import {Head, Link} from '@inertiajs/react';

export default function ForumIndex({threads, popularThreads, recentActivity}) {
    return (
        <>
            <Head title="Forum"/>

            {/* Header */}
            <header className="bg-green-800 text-white py-4">
                <div className="container mx-auto flex justify-between items-center">
                    <h1 className="text-2xl font-bold"><Link href="/">Forum</Link></h1>
                    <nav>
                        <ul className="flex space-x-4">
                            <li><Link href="/" className="hover:underline">Home</Link></li>
                            <li><Link href="#" className="hover:underline">Forum</Link></li>
                            <li><Link href="#" className="hover:underline">About</Link></li>
                        </ul>
                    </nav>
                </div>
            </header>

            <div className="container mx-auto px-4 py-6">
                {/* Create Thread Button */}
                <div className="mb-4 flex justify-end">
                    <Link
                        href="/threads/create"
                        className="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-500"
                    >
                        Create Thread
                    </Link>
                </div>

                <div className="flex flex-col lg:flex-row lg:space-x-6">
                    {/* Threads List */}
                    <div className="flex-1">
                        {threads.map(thread => (
                            <div key={thread.id} className="card mb-4 shadow-sm">
                                <div className="card-body">
                                    <Link href={`/threads/${thread.id}`} className="card-title h5">
                                        {thread.title}
                                    </Link>
                                    <p className="card-subtitle text-muted">
                                        by {thread.author.name}
                                    </p>
                                    <p className="text-green-500 mt-2">
                                        {thread.replies_count} replies
                                    </p>
                                    <p className="text-sm text-gray-500">
                                        Last activity: {thread.last_activity}
                                    </p>
                                </div>
                            </div>
                        ))}
                    </div>

                    {/* Sidebar */}
                    <aside className="w-full lg:w-1/3">
                        <input
                            type="text"
                            placeholder="Search threads..."
                            className="form-control mb-4"
                        />

                        <div className="bg-gray-100 p-4 rounded mb-4">
                            <h5 className="font-bold mb-2">Popular Threads</h5>
                            <ul className="list-disc list-inside">
                                {popularThreads.map(pt => (
                                    <li key={pt.id}>{pt.title}</li>
                                ))}
                            </ul>
                        </div>

                        <div className="bg-gray-100 p-4 rounded">
                            <h5 className="font-bold mb-2">Recent Activity</h5>
                            <ul className="list-disc list-inside">
                                {recentActivity.map((act, idx) => (
                                    <li key={idx}>{act}</li>
                                ))}
                            </ul>
                        </div>
                    </aside>
                </div>
            </div>
            {/* Footer */}
            <footer className="mt-8 bg-green-950 text-white py-6">
                <div className="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <h6 className="font-bold mb-2">Quick Links</h6>
                        <ul className="list-none space-y-1">
                            <li><Link href="#" className="hover:underline">Contact Us</Link></li>
                            <li><Link href="#" className="hover:underline">Terms of Use</Link></li>
                            <li><Link href="#" className="hover:underline">Privacy Policy</Link></li>
                        </ul>
                    </div>
                    <div>
                        <h6 className="font-bold mb-2">About</h6>
                        <p className="text-sm">
                            Welcome to our forum! Join the discussion and share your thoughts with the community.
                        </p>
                    </div>
                    <div>
                        <h6 className="font-bold mb-2">Follow Us</h6>
                        <div className="flex space-x-4">
                            <a href="#" className="hover:text-blue-400"><i className="fab fa-facebook"></i> Facebook</a>
                            <a href="#" className="hover:text-blue-400"><i className="fab fa-twitter"></i> Twitter</a>
                            <a href="#" className="hover:text-blue-400"><i
                                className="fab fa-instagram"></i> Instagram</a>
                        </div>
                    </div>
                </div>
                <div className="text-center mt-4 text-sm">
                    &copy; {new Date().getFullYear()} Forum. All rights reserved.
                </div>
            </footer>
        </>
    );
}
