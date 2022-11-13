import React, {useEffect, useState} from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/inertia-react';
import PrivateBeerDetails from "@/Components/PrivateBeerDetails";

export default function Dashboard(props) {

    const [beers, setBeers] = useState([])

    useEffect(() => {
        fetchAllBeers()
        // fetch(route('categories.index'))
        //     .then(res => res.json())
        //     .then(data => {
        //         setCategories(data)
        //     })
        //     .catch(err => console.log(err))
    }, [])

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

    const deleteBeer = () => {

    }

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>}
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
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
