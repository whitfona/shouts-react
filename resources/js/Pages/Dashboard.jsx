import React, {useEffect, useState} from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, usePage} from '@inertiajs/inertia-react';
import PrivateBeerDetails from "@/Components/PrivateBeerDetails";
import Header from "@/Components/Header";

export default function Dashboard(props) {
    const { flash } = usePage().props
    const [beers, setBeers] = useState([])
    const [categories, setCategories] = useState([])
    const [search, setSearch] = useState('')
    const [showFlashMessage, setShowFlashMessage] = useState(false)

    useEffect(() => {
        fetchAllBeers()
        fetch(route('categories.index'))
            .then(res => res.json())
            .then(data => {
                setCategories(data)
            })
            .catch(err => console.log(err))
    }, [])

    useEffect(() => {
        if (!flash.message) {
            return
        }
        setShowFlashMessage(true)
        setTimeout(() => {
            setShowFlashMessage(false)
        }, 4000)
    }, [flash])

    const fetchAllBeers = () => {
        fetch(route('beers.user.index'))
            .then(res => res.json())
            .then(data => {
                data.sort((a, b) => b.rating - a.rating)
                setBeers(data)
            })
            .catch(err => console.log(err))
    }

    const searchByBrewery = (brewery) => {
        fetch(route('beers.user.brewery', brewery))
            .then(res => res.json())
            .then(data => {
                data.sort((a, b) => b.rating - a.rating)
                setBeers(data)
            })
            .catch(err => console.log(err))
    }

    const deleteBeer = async (beer) => {
        await axios.delete(route('beers.user.destroy', beer))
            .then(res => {
                if (res.status === 202) {
                    fetchAllBeers()
                }
            })
            .catch(err => console.log(err))
    }

    const searchByCategory = (event) => {
        const category = event.target.value

        if (category == -1) {
            fetchAllBeers()
        } else {
            fetch(route('beers.user.category', category))
                .then(res => res.json())
                .then(data => {
                    data.sort((a, b) => b.rating - a.rating)
                    setBeers(data)
                })
                .catch(err => console.log(err))
        }
    }

    const handleSearch = (e) => {
        setSearch(e.target.value)
        if (search.length > 1) {
            fetch(route('beers.user.search', search))
                .then(res => res.json())
                .then(data => {
                    if (data.length === 0) {
                        setBeers([])
                    }
                    data.sort((a, b) => b.avg_rating - a.avg_rating)
                    setBeers(data)
                })
                .catch(err => console.log(err))
        } else {
            fetchAllBeers()
        }
    }

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>}
        >
            <Head title="Dashboard" />

            {showFlashMessage && (
                <span className="bg-pink-100 bottom-0 fixed p-4 right-0">{flash.message}</span>
            )}
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <Header
                            categories={categories}
                            searchByCategory={searchByCategory}
                            search={search}
                            handleSearch={handleSearch}
                        />
                        <div>
                            {beers.map(beer => (
                                <PrivateBeerDetails
                                    beer={beer}
                                    searchByBrewery={searchByBrewery}
                                    deleteBeer={deleteBeer}
                                />
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
