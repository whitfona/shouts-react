import React, {useEffect, useState} from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/inertia-react';
import Quagga from "@ericblade/quagga2";

export default function Dashboard(props) {

    const startReader = () => {
        let countErrors = 0

        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.getElementById('reader')    // Or '#yourElement' (optional)
            },
            decoder: {
                readers: ["ean_reader", "upc_reader"]
            },
            locate: true
        }, function (err) {
            if (err) {
                console.log(err);
                return
            }
            console.log("Initialization finished. Ready to start");
            Quagga.start();
        });

        Quagga.onDetected(function (result) {

            const errors = result.codeResult.decodedCodes
                .filter(_ => _.error !== undefined)
                .map(_ => _.error);
            const median = getMedian( errors );
            if (median < 0.10) {
                // probably correct
                console.log(result.codeResult.code)
                stopReader()
                getScannedBeers(result.codeResult.code)
            }
            else {
                // probably wrong
                if (countErrors > 50) {
                    stopReader()
                    setMessage('Sorry, Beer not found')
                }
                countErrors++
            }
        })
    }

    // Used to get the median value of the barcode error to check if the barcode is likely correct or not
    const getMedian = (arr) => {
        arr.sort((a, b) => a - b);
        const half = Math.floor( arr.length / 2 );
        if (arr.length % 2 === 1) // Odd length
            return arr[ half ];
        return (arr[half - 1] + arr[half]) / 2.0;
    }

    const stopReader = () => {
        Quagga.stop();
        document.getElementById("reader").style.display = 'none';
    }

    const getScannedBeers = (barcode) => {
        console.log(barcode)
        setMessage('')
        fetch(route('beers.barcode.show', barcode))
            .then(res => res.json())
            .then(data => setBeers([data]))
            .catch(err => setMessage("Sorry, No Match Found"))
            // .catch(err => console.log(err))
    }

    const [beers, setBeers] = useState([])
    const [message, setMessage] = useState('')

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
                        <button onClick={startReader} className="p-4 bg-red-400">Scan Beer</button>
                        <p>{message}</p>
                        <div id="reader"></div>
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
