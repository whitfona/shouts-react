import React, {useEffect, useState} from 'react';
import { Link, Head } from '@inertiajs/inertia-react';
import Quagga from "@ericblade/quagga2";
import ApplicationLogo from "@/Components/ApplicationLogo";
import BeerDetails from "@/Components/BeerDetails";

export default function Welcome(props) {
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
            .then(data => {
                console.log(data)
                data.sort((a, b) => b.avg_rating - a.avg_rating)
                setBeers(data)
            })
            .catch(err => console.log(err))
    }, [])
    return (
        <>
            <Head title="Welcome" />
            <div className="relative flex items-top justify-center min-h-screen bg-pink-400 dark:bg-gray-900 sm:items-center sm:pt-0">
                <div className="max-w-6xl mx-auto sm:px-6 lg:px-8">
                    <div className="flex justify-between pt-8">
                        <div className="flex flex-col justify-center items-center">
                            <ApplicationLogo size={50} />
                            <h1 className="text-white">SHOUTS!</h1>
                        </div>
                        <div>
                            {props.auth.user ? (
                                <Link href={route('dashboard')} className="text-sm text-gray-700 dark:text-gray-500 underline">
                                    Dashboard
                                </Link>
                            ) : (
                                <>
                                    <Link href={route('login')} className="text-sm text-white dark:text-gray-500 underline">
                                        Log in
                                    </Link>

                                    <Link
                                        href={route('register')}
                                        className="ml-4 text-sm text-white dark:text-gray-500 underline"
                                    >
                                        Register
                                    </Link>
                                </>
                            )}
                        </div>
                    </div>

                    <div className="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                        <div className="py-12">
                            <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div className="p-6 bg-white border-b border-gray-200">Welcome</div>
                                    <button onClick={startReader} className="p-4 bg-red-400">Scan Beer</button>
                                    <p>{message}</p>
                                    <div id="reader"></div>
                                    {beers.map(beer => (
                                        <BeerDetails beer={beer} />
                                    ))}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div className="flex justify-center mt-4 sm:items-center sm:items-center">
                        <div className="text-center text-sm text-gray-500 sm:text-left">
                            <a href="https://whitforddesign.ca">whitforddesign.ca</a>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
