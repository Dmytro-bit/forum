import React from 'react';
import { Head, Link } from '@inertiajs/react';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm';
import UpdatePasswordForm from './Partials/UpdatePasswordForm';
import DeleteUserForm from './Partials/DeleteUserForm';

export default function Edit({ mustVerifyEmail, status }) {
    return (
        <>
            <Head title="Profile" />

            {/* Header */}
            <header className="bg-green-800 text-white py-4">
                <div className="container mx-auto flex justify-between items-center">
                    <h1 className="text-2xl font-bold">Forum</h1>
                    <nav>
                        <ul className="flex space-x-4">
                            <li><Link href="/" className="hover:underline">Home</Link></li>
                            <li><Link href="/profile" className="underline">Profile</Link></li>
                            <li><Link href="/threads" className="hover:underline">Threads</Link></li>
                        </ul>
                    </nav>
                </div>
            </header>

            <div className="flex h-screen overflow-hidden">
                {/* Sidebar */}
                <aside className="w-1/4 bg-gray-100 p-6">
                    <h6 className="font-bold mb-4">Your Account</h6>
                    <ul className="space-y-2">
                        <li>
                            <Link
                                href="/profile"
                                className="block p-2 rounded bg-green-700 text-white"
                            >
                                Edit Profile
                            </Link>
                        </li>
                        <li>
                            <Link
                                href="#password"
                                className="block p-2 rounded hover:bg-gray-200"
                            >
                                Change Password
                            </Link>
                        </li>
                        <li>
                            <Link
                                href="#delete"
                                className="block p-2 rounded hover:bg-gray-200 text-red-600"
                            >
                                Delete Account
                            </Link>
                        </li>
                    </ul>
                </aside>

                {/* Main Content */}
                <main className="flex-1 overflow-auto p-8 space-y-8 bg-white">
                    {/* Profile Info */}
                    <section id="profile-info" className="space-y-4">
                        <h2 className="text-xl font-semibold text-gray-800">Profile Information</h2>
                        <div className="bg-gray-50 shadow sm:rounded-lg sm:p-6">
                            <UpdateProfileInformationForm
                                mustVerifyEmail={mustVerifyEmail}
                                status={status}
                            />
                        </div>
                    </section>

                    {/* Password */}
                    <section id="password" className="space-y-4">
                        <h2 className="text-xl font-semibold text-gray-800">Update Password</h2>
                        <div className="bg-gray-50 shadow sm:rounded-lg sm:p-6">
                            <UpdatePasswordForm />
                        </div>
                    </section>

                    {/* Delete Account */}
                    <section id="delete" className="space-y-4">
                        <h2 className="text-xl font-semibold text-gray-800 text-red-600">Delete Account</h2>
                        <div className="bg-gray-50 shadow sm:rounded-lg sm:p-6">
                            <DeleteUserForm />
                        </div>
                    </section>
                </main>
            </div>
        </>
    );
}
