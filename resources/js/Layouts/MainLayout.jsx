import { usePage } from '@inertiajs/react';

export default function MainLayout({ children }) {
    const { auth } = usePage().props;

    return (
        <div className="min-h-screen bg-gray-100">
            <nav className="bg-white border-b border-gray-200">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between h-16">
                        <div className="flex items-center">
                            <span className="text-lg font-semibold">
                                {auth.user.name}
                            </span>
                        </div>
                    </div>
                </div>
            </nav>

            <main>
                {children}
            </main>
        </div>
    );
}
