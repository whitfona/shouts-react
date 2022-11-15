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
                <div className="max-w-6xl mx-auto sm:px-6 lg:px-8">
                    <nav>
                        <div className="flex justify-between px-4 pt-8">
                            <Link href="/" className="flex flex-col justify-center items-center">
                                <ApplicationLogo size={50} />
                                <h1 className="text-white">SHOUTS!</h1>
                            </Link>
                            <div>
                                {props.auth.user ? (
                                    <div className="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex h-16">
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
                                ) : (
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
                                )}

                            </div>
                        </div>
                    </nav>

                    <div className="mt-8 bg-white dark:bg-gray-800 overflow-hidden sm:rounded-lg">
                        <div className="">
                            <div className="max-w-7xl mx-auto">
                                <div className="bg-pink-100 overflow-hidden shadow-sm sm:rounded-lg">
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

                    {/*<div className="flex justify-center my-4 sm:items-center sm:items-center">*/}
                    {/*    <div className="text-center text-sm text-gray-500 sm:text-left">*/}
                    {/*        <a className="text-white" href="https://whitforddesign.ca">Whitford Design | {year}</a>*/}
                    {/*    </div>*/}
                    {/*</div>*/}
                </div>
            </div>
        </>
    );
}
