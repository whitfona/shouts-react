import React, {useEffect, useMemo, useState} from 'react';
import { Link, Head } from '@inertiajs/inertia-react';
import ApplicationLogo from "@/Components/ApplicationLogo";
import PublicBeerDetails from "@/Components/PublicBeerDetails";
import BarcodeScanner from "@/Components/BarcodeScanner";
import Header from "@/Components/Header";
import NavLink from "@/Components/NavLink";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink";

export default function Welcome(props) {

    const [beers, setBeers] = useState([])
    const [categories, setCategories] = useState([])
    const [search, setSearch] = useState('')
    const [message, setMessage] = useState('')
    const [showingNavigationDropdown, setShowingNavigationDropdown] = useState(false);

    useEffect(() => {
        fetchAllBeers()
        fetch(route('categories.index'))
            .then(res => res.json())
            .then(data => {
                setCategories(data)
            })
            .catch(err => console.log(err))

    }, [])

    const fetchAllBeers = () => {
        fetch(route('beers.index'))
            .then(res => res.json())
            .then(data => {
                data.sort((a, b) => b.avg_rating - a.avg_rating)
                setBeers(data)
            })
            .catch(err => console.log(err))
    }

    const getScannedBeers = (barcode) => {
        setMessage('')
        fetch(route('beers.barcode.show', barcode))
            .then(res => res.json())
            .then(data => {
                setBeers([data])
            })
            .catch(err => setMessage("Sorry, error fetching beers."))
        // .catch(err => console.log(err))
    }

    const searchByBrewery = (brewery) => {
        fetch(route('beers.brewery.show', brewery))
            .then(res => res.json())
            .then(data => {
                data.sort((a, b) => b.avg_rating - a.avg_rating)
                setBeers(data)
            })
            .catch(err => console.log(err))
    }

    const searchByCategory = () => {
        const category = event.target.value
        if (category == -1) {
            fetchAllBeers()
        } else {
            fetch(route('beers.category.show', category))
                .then(res => res.json())
                .then(data => {
                    data.sort((a, b) => b.avg_rating - a.avg_rating)
                    setBeers(data)
                })
                .catch(err => console.log(err))
        }
    }

    const searchByUser = (user) => {
        fetch(route('beers.user.show', user))
            .then(res => res.json())
            .then(data => {
                data.sort((a, b) => b.ratings[0].rating - a.ratings[0].rating)
                setBeers(data)
            })
            .catch(err => console.log(err))
    }

    const handleSearch = (e) => {
        setSearch(e.target.value)
        if (search.length > 1) {
            fetch(route('beers.search.show', search))
                .then(res => res.json())
                .then(data => {
                    if (data.length === 0) {
                        setMessage('Sorry, no beers match that search.')
                        setBeers([])
                    }
                        data.sort((a, b) => b.avg_rating - a.avg_rating)
                        setBeers(data)
                })
                .catch(err => console.log(err))
        } else {
            setMessage('')
            fetchAllBeers()
        }
    }

    return (
        <>
            <Head title="Welcome" />
            <div className="relative flex items-top justify-center min-h-screen bg-pink-400 dark:bg-gray-900 sm:items-center sm:pt-0">
                <div className="">
                {/*<div className="max-w-6xl mx-auto sm:px-6 lg:px-8">*/}
                    <nav className="bg-pink-400 border-b border-gray-100">
                        <div className="max-w-7xl mx-auto p-4 sm:px-6 lg:px-8">
                            <div className="flex justify-between h-16">
                                <Link href="/" className="flex flex-col items-center justify-center">
                                    <ApplicationLogo size={40} />
                                    <h1 className="text-white">SHOUTS!</h1>
                                </Link>

                                {props.auth.user ?
                                    <div className="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                        <NavLink href={route('welcome')} active={route().current('welcome')}>
                                            All Bevvies
                                        </NavLink>
                                        <NavLink href={route('dashboard')} active={route().current('dashboard')}>
                                            My Bevvies
                                        </NavLink>
                                        <NavLink href={route('beer.create')} active={route().current('beer.create')}>
                                            Add Bevvie
                                        </NavLink>
                                        <NavLink href={route('about')} active={route().current('about')}>
                                            About
                                        </NavLink>
                                    </div>
                                    :
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
                                }

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

                        {props.auth.user ?
                            <div className={(showingNavigationDropdown ? 'block' : 'hidden') + ' sm:hidden'}>
                                <div className="pt-2 pb-3 space-y-1">
                                    <ResponsiveNavLink href={route('welcome')} active={route().current('welcome')}>
                                        All Bevvies
                                    </ResponsiveNavLink>
                                    <ResponsiveNavLink href={route('dashboard')} active={route().current('dashboard')}>
                                        My Bevvies
                                    </ResponsiveNavLink>
                                    <ResponsiveNavLink href={route('beer.create')} active={route().current('beer.create')}>
                                        Add Bevvie
                                    </ResponsiveNavLink>
                                    <ResponsiveNavLink href={route('about')} active={route().current('about')}>
                                        About
                                    </ResponsiveNavLink>
                                </div>
                            </div>
                            :
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
                            </div>}

                    </nav>

                    <div className="bg-pink-400 dark:bg-gray-800 overflow-hidden sm:rounded-lg px-6">
                        <h2 className="font-semibold text-xl text-white leading-tight py-6 px-4 sm:px-0">All Bevvies</h2>
                        <div className="max-w-7xl mx-auto">
                            <div className="bg-pink-100 overflow-hidden shadow-sm rounded-lg">
                                <Header
                                    categories={categories}
                                    message={message}
                                    search={search}
                                    handleSearch={handleSearch}
                                    searchByCategory={searchByCategory}
                                />
                                <BarcodeScanner
                                    getScannedBeers={getScannedBeers}
                                    setMessage={setMessage}
                                />
                                {beers.map(beer => (
                                    <PublicBeerDetails
                                        beer={beer}
                                        searchByBrewery={searchByBrewery}
                                        searchByUser={searchByUser}
                                    />
                                ))}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
