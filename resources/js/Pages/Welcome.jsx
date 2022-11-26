import React, {useEffect, useState} from 'react';
import {Head, usePage} from '@inertiajs/inertia-react';
import PublicBeerDetails from "@/Components/PublicBeerDetails";
import BarcodeScanner from "@/Components/BarcodeScanner";
import Header from "@/Components/Header";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import GuestLayout from "@/Layouts/GuestLayout";
import FlashMessage from "@/Components/FlashMessage";

export default function Welcome(props) {

    const { flash } = usePage().props
    const [beers, setBeers] = useState([])
    const [categories, setCategories] = useState([])
    const [search, setSearch] = useState('')
    const [message, setMessage] = useState('')

    useEffect(() => {
        fetchAllBeers()
        fetch(route('categories.index'))
            .then(res => res.json())
            .then(data => {
                setCategories(data)
            })
            .catch(err => console.log(err))
    }, [flash])

    const fetchAllBeers = () => {
        fetch(route('beers.index'))
            .then(res => res.json())
            .then(data => {
                const filtered = data.filter(item => item.avg_rating > 0)
                filtered.sort((a, b) => b.avg_rating - a.avg_rating)
                setBeers(filtered)
            })
            .catch(err => console.log(err))
    }

    const getScannedBeers = (barcode) => {
        setMessage('')
        fetch(route('beers.barcode.show', barcode))
            .then(res => res.json())
            .then(data => {
                if (Object.keys(data).length === 0) {
                    setMessage('Sorry, no match found. Please try again or search manually.')
                } else {
                    setBeers(data)
                }
            })
            .catch(err => setMessage("Sorry, error fetching beers."))
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

    useEffect(() => {
        if (search === '') {
            return fetchAllBeers()
        }

        fetch(route('beers.search.show', search))
            .then(res => res.json())
            .then(data => {
                data.sort((a, b) => b.avg_rating - a.avg_rating)
                setBeers(data)
            })
            .catch(err => console.log(err))
    }, [search])

    const handleSearch = (e) => {
        setSearch(e.target.value)
    }

    return (
        <>
            {props.auth.user ?
                <AuthenticatedLayout
                    auth={props.auth}
                    errors={props.errors}
                    header={<h2 className="font-semibold text-xl text-white leading-tight">All Bevvies</h2>}
                >
                    <Head title="All Shouts" />

                    <FlashMessage />
                    <div className="bg-pink-400 dark:bg-gray-800 overflow-hidden sm:rounded-lg px-6">
                        <div className="max-w-7xl mx-auto pb-8">
                            <div className="bg-pink-100 overflow-hidden shadow-sm rounded-lg">
                                <Header
                                    categories={categories}
                                    search={search}
                                    handleSearch={handleSearch}
                                    searchByCategory={searchByCategory}
                                />
                                <BarcodeScanner
                                    getScannedBeers={getScannedBeers}
                                    setMessage={setMessage}
                                />
                                <p className="text-red-500 mt-4 text-center">{message}</p>
                                {beers.map((beer, index) => (
                                    <PublicBeerDetails
                                        beer={beer}
                                        key={index}
                                        searchByBrewery={searchByBrewery}
                                        searchByUser={searchByUser}
                                        userId={props.auth.user.id}
                                    />
                                ))}
                            </div>
                        </div>
                    </div>
                </AuthenticatedLayout>
                :
                <GuestLayout>
                    <Head title="All Shouts" />

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
                                <p className="text-red-500 mt-4 text-center">{message}</p>
                                <div className="pb-4">
                                    {beers.map((beer, index) => (
                                        <PublicBeerDetails
                                            beer={beer}
                                            key={index}
                                            searchByBrewery={searchByBrewery}
                                            searchByUser={searchByUser}
                                            userId={-1}
                                        />
                                    ))}
                                </div>
                            </div>
                        </div>
                </GuestLayout>
            }
        </>
    );
}
