import { Head } from '@inertiajs/react';

export default function Home({ threads, popularThreads, recentActivity }) {
    return (
        <>
            <Head title="Forum" />

            <div className="bg-gray-100 min-h-screen">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    {/* Hero Section */}
                    <div className="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-sm p-8 mb-8 text-white">
                        <div className="flex justify-between items-center">
                            <div>
                                <h1 className="text-4xl font-bold mb-2">Welcome to Forum</h1>
                                <p className="text-blue-100">Join the discussion with our community</p>
                            </div>
                            <a
                                href="/threads/create"
                                className="inline-flex items-center px-6 py-3 bg-white text-blue-600 text-sm font-semibold rounded-lg hover:bg-blue-50 transition-colors duration-200 shadow-sm hover:shadow"
                            >
                                <svg className="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Start New Discussion
                            </a>
                        </div>
                    </div>

                    <div className="grid grid-cols-1 lg:grid-cols-4 gap-6">
                        {/* Main Content */}
                        <div className="lg:col-span-3">
                            <div className="space-y-3">
                                {threads.map((thread) => (
                                    <div
                                        key={thread.id}
                                        className="bg-white rounded-lg p-6 hover:shadow-md transition-all duration-200"
                                    >
                                        <div className="flex items-start justify-between">
                                            <div className="flex-1">
                                                <div className="flex items-center space-x-2">
                                                    {thread.is_pinned && (
                                                        <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                            <svg className="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M5 5a2 2 0 012-2h6a2 2 0 012 2v2.17a2 2 0 01-.586 1.414l-3.828 3.829a1 1 0 01-1.414 0L5.586 8.585A2 2 0 015 7.171V5z" />
                                                            </svg>
                                                            Pinned
                                                        </span>
                                                    )}
                                                    <a
                                                        href={`/threads/${thread.id}`}
                                                        className="text-xl font-semibold text-gray-900 hover:text-blue-600"
                                                    >
                                                        {thread.title}
                                                    </a>
                                                </div>
                                                <div className="mt-2 flex items-center space-x-4">
                                                    <span className="text-sm text-gray-500">
                                                        By <span className="font-medium text-blue-600">{thread.author.name}</span>
                                                    </span>
                                                    <span className="text-sm text-gray-500">• {thread.last_activity}</span>
                                                    <span className="text-sm text-blue-600">
                                                        {thread.replies_count} {thread.replies_count === 1 ? 'reply' : 'replies'}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>

                        {/* Sidebar */}
                        <div className="space-y-6">
                            {/* Popular Threads */}
                            <div className="bg-white rounded-lg p-6">
                                <h3 className="text-lg font-semibold text-gray-900 mb-4">Popular Discussions</h3>
                                <div className="space-y-3">
                                    {popularThreads?.map((thread) => (
                                        <a
                                            key={thread.id}
                                            href={`/threads/${thread.id}`}
                                            className="block text-sm text-gray-600 hover:text-blue-600"
                                        >
                                            {thread.title}
                                        </a>
                                    ))}
                                </div>
                            </div>

                            {/* Recent Activity */}
                            <div className="bg-white rounded-lg p-6">
                                <h3 className="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>
                                <div className="space-y-3">
                                    {recentActivity?.map((activity, index) => (
                                        <div key={index} className="flex items-start space-x-3">
                                            <div className="w-2 h-2 mt-2 rounded-full bg-blue-500"></div>
                                            <p className="text-sm text-gray-600">
                                                {activity}
                                            </p>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
