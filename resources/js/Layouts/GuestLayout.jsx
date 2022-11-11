import React from 'react';
import ApplicationLogo from '@/Components/ApplicationLogo';
import { Link } from '@inertiajs/inertia-react';

export default function Guest({ children }) {
    return (
        <div className="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-pink-400">
            <div>
                <Link href="/" className="flex flex-col justify-center items-center">
                    <ApplicationLogo className="w-20 h-20 fill-current text-gray-500" />
                    <h1 className="text-3xl text-white">SHOUTS</h1>
                </Link>
            </div>

            <div className="sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {children}
            </div>
        </div>
    );
}
