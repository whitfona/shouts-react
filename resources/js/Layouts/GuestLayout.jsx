import React, {useEffect, useState} from 'react';
import ApplicationLogo from '@/Components/ApplicationLogo';
import { Link } from '@inertiajs/inertia-react';

export default function Guest({ children }) {
    const [year, setYear] = useState()

    useEffect(() => {
        getYear()
    }, [])

    const getYear = () => {
        const date = new Date
        const year = date.getFullYear()
        setYear(year)
    }

    return (
        <div className="min-h-screen flex flex-col sm:justify-center items-center p-8 sm:pt-0 bg-pink-400">
            <div>
                <Link href="/" className="flex flex-col justify-center items-center">
                    <ApplicationLogo className="w-20 h-20 fill-current text-gray-500" />
                    <h1 className="text-3xl text-white">SHOUTS</h1>
                </Link>
            </div>

            <div className="sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden rounded-lg">
                {children}
            </div>

            <div className="flex justify-center my-4 sm:items-center sm:items-center">
                <div className="text-center text-sm text-gray-500 sm:text-left">
                    <a className="text-white" href="https://whitforddesign.ca">Whitford Design | {year}</a>
                </div>
            </div>
        </div>
    );
}
