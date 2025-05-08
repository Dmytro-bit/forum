import { Head, Link, useForm } from '@inertiajs/react';
import GuestLayout from '@/Layouts/GuestLayout';

export default function Login() {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
        password: '',
    });

    function submit(e) {
        e.preventDefault();
        post(route('login'));
    }

    return (
        <GuestLayout>
            <Head title="Log in" />

            <h2 className="text-2xl font-bold text-emerald-900 mb-6 text-center">
                Sign in to Your Account
            </h2>

            <form onSubmit={submit} className="space-y-4">
                <div>
                    <label htmlFor="email" className="block text-sm font-medium text-gray-700">
                        Email
                    </label>
                    <input
                        id="email"
                        type="email"
                        value={data.email}
                        onChange={e => setData('email', e.target.value)}
                        className="mt-1 block w-full rounded-md border-emerald-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                    />
                    {errors.email && <p className="mt-1 text-sm text-red-600">{errors.email}</p>}
                </div>

                <div>
                    <label htmlFor="password" className="block text-sm font-medium text-gray-700">
                        Password
                    </label>
                    <input
                        id="password"
                        type="password"
                        value={data.password}
                        onChange={e => setData('password', e.target.value)}
                        className="mt-1 block w-full rounded-md border-emerald-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                    />
                    {errors.password && <p className="mt-1 text-sm text-red-600">{errors.password}</p>}
                </div>

                <button
                    type="submit"
                    disabled={processing}
                    className="w-full inline-flex justify-center rounded-md border border-transparent bg-emerald-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
                >
                    Log in
                </button>

                <p className="mt-4 text-center text-sm text-gray-600">
                    Don’t have an account?{' '}
                    <Link href={route('register')} className="font-medium text-emerald-600 hover:text-emerald-800">
                        Sign up
                    </Link>
                </p>
            </form>
        </GuestLayout>
    );
}

