import React, {useEffect, useState} from 'react';
import ApplicationLogo from '@/Components/ApplicationLogo';
import { Link } from '@inertiajs/inertia-react';
import NavLink from "@/Components/NavLink";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink";

export default function Guest({ children }) {
    const [year, setYear] = useState()
    const [showingNavigationDropdown, setShowingNavigationDropdown] = useState(false);


    useEffect(() => {
        getYear()
    }, [])

    const getYear = () => {
        const date = new Date
        const year = date.getFullYear()
        setYear(year)
    }

    return (
    <>
        <nav className="bg-pink-400 border-b border-gray-100">
            <div className="max-w-7xl mx-auto p-4 sm:px-6 lg:px-8">
                <div className="flex justify-between h-16">
                        <Link href="/" className="flex flex-col items-center justify-center">
                            <ApplicationLogo size={40} />
                            <h1 className="text-white">SHOUTS!</h1>
                        </Link>

                        <div className="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <NavLink href={route('welcome')} active={route().current('welcome')}>
                                All Bevvies
                            </NavLink>
                            <NavLink href={route('login')} active={route().current('login')}>
                                Login
                            </NavLink>
                            <NavLink href={route('register')} active={route().current('register')}>
                                Register
                            </NavLink>
                            <NavLink href={route('about')} active={route().current('about')}>
                                About
                            </NavLink>
                        </div>

                    <div className="-mr-2 flex items-center sm:hidden">
                        <button
                            onClick={() => setShowingNavigationDropdown((previousState) => !previousState)}
                            className="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                        >
                            <svg className="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path
                                    className={!showingNavigationDropdown ? 'inline-flex' : 'hidden'}
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    className={showingNavigationDropdown ? 'inline-flex' : 'hidden'}
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div className={(showingNavigationDropdown ? 'block' : 'hidden') + ' sm:hidden'}>
                <div className="pt-2 pb-3 space-y-1">
                    <ResponsiveNavLink href={route('welcome')} active={route().current('welcome')}>
                        All Bevvies
                    </ResponsiveNavLink>
                    <ResponsiveNavLink href={route('login')} active={route().current('login')}>
                        Login
                    </ResponsiveNavLink>
                    <ResponsiveNavLink href={route('register')} active={route().current('register')}>
                        Register
                    </ResponsiveNavLink>
                    <ResponsiveNavLink href={route('about')} active={route().current('about')}>
                        About
                    </ResponsiveNavLink>
                </div>

            </div>
        </nav>










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
    </>
    );
}
