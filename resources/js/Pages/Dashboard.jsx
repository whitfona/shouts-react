import React, {useEffect, useState} from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/inertia-react';

export default function Dashboard(props) {

    const [beers, setBeers] = useState([])

    useEffect(() => {
        fetch(route('beers.barcode.index'))
            .then(res => res.json())
            .then(data => setBeers(data))
            .catch(err => console.log(err))
    }, [])

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
                        <div className="p-6 bg-white border-b border-gray-200">You're logged in!</div>
                        <div>
                            {beers.map(beer => (
                                <div key={beer.id}>
                                    <p>Barcode: {beer.barcode}</p>
                                    <p>Name: {beer.name}</p>
                                    <p>Brewery: {beer.brewery}</p>
                                    <p>Percent: {beer.alcohol_percent}</p>
                                    <p>Type: {beer.category.type}</p>
                                    {beer.rating.map(rating => (
                                        <ol key={rating.id}>
                                            <li>User: {rating.user.name}</li>
                                            <li>Rating: {rating.rating}</li>
                                            <li>Comment: {rating.comment}</li>
                                        </ol>
                                    ))}
                                <br /><br />
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
