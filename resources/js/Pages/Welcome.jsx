import React, {useEffect, useMemo, useState} from 'react';
import { Link, Head } from '@inertiajs/inertia-react';
import Quagga from "@ericblade/quagga2";
import ApplicationLogo from "@/Components/ApplicationLogo";
import BeerDetails from "@/Components/BeerDetails";
import MagnifyingGlass from "@/Components/MagnifyingGlass";

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
            document.getElementById("reader").style.display = 'block';
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
            .then(data => {
                setBeers([data])
            })
            .catch(err => setMessage("Sorry, No Match Found"))
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
        }
        if (search.length === 1) {
            setMessage('')
            fetchAllBeers()
        }
    }

    const [beers, setBeers] = useState([])
    const [categories, setCategories] = useState([])
    const [search, setSearch] = useState('')
    const [message, setMessage] = useState('')

    const fetchAllBeers = () => {
        fetch(route('beers.barcode.index'))
            .then(res => res.json())
            .then(data => {
                data.sort((a, b) => b.avg_rating - a.avg_rating)
                setBeers(data)
            })
            .catch(err => console.log(err))
    }

    useEffect(() => {
        fetchAllBeers()
        fetch(route('categories.index'))
            .then(res => res.json())
            .then(data => {
                setCategories(data)
            })
            .catch(err => console.log(err))
    }, [])
    return (
        <>
            <Head title="Welcome" />
            <div className="relative flex items-top justify-center min-h-screen bg-pink-400 dark:bg-gray-900 sm:items-center sm:pt-0">
                <div className="max-w-6xl mx-auto sm:px-6 lg:px-8">
                    <div className="flex justify-between pt-8">
                        <Link href="/" className="flex flex-col justify-center items-center">
                            <ApplicationLogo size={50} />
                            <h1 className="text-white">SHOUTS!</h1>
                        </Link>
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
                                    <header className="border-b border-gray-200">
                                        <div className="font-semibold pb-4 text-xl leading-tight">All Bevvies</div>
                                        <input
                                            className="rounded-md shadow-sm text-gray-500 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mb-2 md:w-1/3"
                                            type="text"
                                            placeholder={'Search...'}
                                            value={search}
                                            onChange={handleSearch}
                                        />
                                        <select
                                            onChange={searchByCategory}
                                            defaultValue={'disabled'}
                                            className="text-gray-500 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 flex"
                                        >
                                            <option value={'disabled'} disabled>Filter by Category</option>
                                            <option key={-1} value={-1}>All</option>
                                            {categories.map(category => (
                                                <option key={category.id} value={category.id}>{category.type}</option>
                                            ))}
                                        </select>
                                        <button onClick={startReader}
                                                className="max-w-fit mx-auto sm:px-6 rounded-md mb-4 p-4 bg-pink-400 flex
                                                justify-center items-center hover:cursor-pointer hover:bg-pink-300 text-4xl
                                                text-white font-extrabold uppercase pl-3">
                                            <span className="w-16 bg-pink-200 p-3 rounded-full mr-2"><MagnifyingGlass /></span>
                                            Barcode
                                        </button>
                                        <p>{message}</p>
                                    </header>
                                    <div id="reader"></div>
                                    {beers.map(beer => (
                                        <BeerDetails
                                            beer={beer}
                                            searchByBrewery={searchByBrewery}
                                            searchByUser={searchByUser}
                                        />
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
