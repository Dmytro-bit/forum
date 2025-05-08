import { Head, Link } from '@inertiajs/react';

export default function Home({ threads, popularThreads, recentActivity, auth }) {
    return (
        <>
            <Head title="Forum" />

            <div className="bg-emerald-50 min-h-screen">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    {/* Hero Section */}
                    <div className="bg-emerald-900 rounded-xl shadow-sm p-8 mb-8 text-white">
                        <div className="flex justify-between items-center">
                            <div>
                                <h1 className="text-4xl font-bold mb-2">Welcome to Greendit</h1>
                                <p className="text-emerald-300">
                                    Join the discussion with our green community
                                </p>
                            </div>
                            {auth?.user ? (
                                <div className="space-x-4">
                                    <Link
                                        href="/dashboard"
                                        className="inline-flex items-center px-6 py-3 bg-white text-emerald-900 text-sm font-semibold rounded-lg hover:bg-emerald-50 transition-colors duration-200 shadow-sm"
                                    >
                                        Dashboard
                                    </Link>
                                    <Link
                                        href="/threads/create"
                                        className="inline-flex items-center px-6 py-3 bg-white text-emerald-900 text-sm font-semibold rounded-lg hover:bg-emerald-50 transition-colors duration-200 shadow-sm"
                                    >
                                        Start New Discussion
                                    </Link>
                                </div>
                            ) : (
                                <div className="space-x-4">
                                    <Link
                                        href="/login"
                                        className="inline-flex items-center px-6 py-3 bg-white text-emerald-900 text-sm font-semibold rounded-lg hover:bg-emerald-50 transition-colors duration-200 shadow-sm"
                                    >
                                        Sign in
                                    </Link>
                                    <Link
                                        href="/register"
                                        className="inline-flex items-center px-6 py-3 bg-emerald-800 text-white text-sm font-semibold rounded-lg border border-emerald-700 hover:bg-emerald-700 transition-colors duration-200 shadow-sm"
                                    >
                                        Sign up
                                    </Link>
                                </div>
                            )}
                        </div>
                    </div>

                    <div className="grid grid-cols-1 lg:grid-cols-4 gap-6">
                        {/* Threads List */}
                        <div className="lg:col-span-3 space-y-3">
                            {threads.map((thread) => (
                                <div
                                    key={thread.id}
                                    className="bg-white rounded-lg p-6 hover:shadow-md transition-all duration-200"
                                >
                                    <div className="flex items-start justify-between">
                                        <div className="flex-1">
                                            <div className="flex items-center space-x-2">
                                                {thread.is_pinned && (
                                                    <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-900">
                            <svg
                                className="w-3 h-3 mr-1"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                              <path d="M5 5a2 2 0 012-2h6a2 2 0 012 2v2.17a2 2 0 01-.586 1.414l-3.828 3.829a1 1 0 01-1.414 0L5.586 8.585A2 2 0 015 7.171V5z" />
                            </svg>
                            Pinned
                          </span>
                                                )}
                                                <Link
                                                    href={`/threads/${thread.id}`}
                                                    className="text-xl font-semibold text-emerald-900 hover:text-emerald-700"
                                                >
                                                    {thread.title}
                                                </Link>
                                            </div>
                                            <div className="mt-2 flex items-center space-x-4">
                        <span className="text-sm text-emerald-600">
                          By{' '}
                            <span className="font-medium text-emerald-900">
                            {thread.author.name}
                          </span>
                        </span>
                                                <span className="text-sm text-emerald-600">
                          • {thread.last_activity}
                        </span>
                                                <span className="text-sm text-emerald-700">
                          {thread.replies_count}{' '}
                                                    {thread.replies_count === 1 ? 'reply' : 'replies'}
                        </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>

                        {/* Sidebar */}
                        <div className="space-y-6">
                            {/* Popular Threads */}
                            <div className="bg-white rounded-lg p-6">
                                <h3 className="text-lg font-semibold text-emerald-900 mb-4">
                                    Popular Discussions
                                </h3>
                                <div className="space-y-3">
                                    {popularThreads.map((t) => (
                                        <Link
                                            key={t.id}
                                            href={`/threads/${t.id}`}
                                            className="block text-sm text-emerald-700 hover:text-emerald-900"
                                        >
                                            {t.title}
                                        </Link>
                                    ))}
                                </div>
                            </div>

                            {/* Recent Activity (exactly as on Dashboard) */}
                            <div className="bg-white rounded-lg p-6">
                                <h3 className="text-lg font-semibold text-emerald-900 mb-4">
                                    Recent Activity
                                </h3>
                                <div className="space-y-3">
                                    {recentActivity.length > 0
                                        ? recentActivity.map((activity, idx) => (
                                            <div key={idx} className="flex items-start space-x-3">
                                                <div className="w-2 h-2 mt-2 rounded-full bg-emerald-500" />
                                                <p className="text-sm text-emerald-700">{activity}</p>
                                            </div>
                                        ))
                                        : (
                                            <p className="text-sm text-emerald-700">No recent activity.</p>
                                        )
                                    }
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
