import React, {useEffect, useState} from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, Link, useForm} from '@inertiajs/inertia-react';
import MagnifyingGlass from "@/Components/MagnifyingGlass";
import PlusIcon from "@/Components/PlusIcon";
import BarcodeScanner from "@/Components/BarcodeScanner";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import PrimaryButton from "@/Components/PrimaryButton";

export default function AddBevvie(props) {

    const { data, setData, post, processing, errors, reset } = useForm({
        barcode: '',
        name: '',
        brewery: '',
        rating: '',
        alcohol_percent: '',
        category: '',
        has_lactose: false,
        comments: '',
        image: ''
    });
    const [categories, setCategories] = useState([])

    useEffect(() => {
        fetch(route('categories.index'))
            .then(res => res.json())
            .then(data => {
                setCategories(data)
            })
            .catch(err => console.log(err))
    }, [])

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.type === 'checkbox' ? event.target.checked : event.target.value);
    };

    const getScannedBeer = (barcode) => {
        clearAllFields()
        fetch(route('beers.user.barcode', barcode))
            .then(res => res.json())
            .then(data => {
                const checked = data.has_lactose === 1
                setData({
                    barcode:  data.barcode,
                    name: data.name,
                    brewery: data.brewery,
                    rating: data.rating,
                    alcohol_percent: data.alcohol_percent,
                    category: data.category_id,
                    has_lactose: checked,
                    comments: data.comment,
                    // image: data.image
                })
            })
            .catch(err => setMessage("Sorry, error fetching beers."))
        // .catch(err => console.log(err))
    }

    const clearAllFields = () => {
        setData({
            barcode: '',
            name: '',
            rating:'',
            alcohol_percent: '',
            category: '',
            has_lactose: false,
            comments: '',
            image: ''
        })
    }


    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Add Bevvie</h2>}
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div>
                            <button
                                    className="max-w-fit mx-auto sm:px-6 rounded-md mb-4 p-4 bg-pink-400 flex
                                                justify-center items-center hover:cursor-pointer hover:bg-pink-300 text-4xl
                                                text-white font-extrabold uppercase pl-3 mt-6">
                                <span className="w-16 bg-pink-200 p-3 rounded-full mr-2"><MagnifyingGlass /></span>
                                Add By Barcode
                            </button>
                            <button
                                    className="max-w-fit mx-auto sm:px-6 rounded-md mb-4 p-4 bg-pink-400 flex
                                                justify-center items-center hover:cursor-pointer hover:bg-pink-300 text-4xl
                                                text-white font-extrabold uppercase pl-3 mt-6">
                                <span className="w-16 bg-pink-200 p-3 rounded-full mr-2"><PlusIcon width={40} /> </span>
                                Add Manually
                            </button>
                        </div>
                        <div>
                            <BarcodeScanner getScannedBeers={getScannedBeer} />
                            {/*<form onSubmit={submit} className="p-4">*/}
                            <form className="p-4">
                                <h2 className="font-medium text-3xl text-gray-700 text-center pb-4">Add By Barcode</h2>
                                <div>
                                    <InputLabel forInput="barcode" value="Barcode" />

                                    <TextInput
                                        type="text"
                                        name="barcode"
                                        value={data.barcode}
                                        className="mt-1 block w-full md:w-auto"
                                        autoComplete="name"
                                        // isFocused={true}
                                        handleChange={onHandleChange}
                                    />

                                    <InputError message={errors.barcode} className="mt-2" />
                                </div>

                                <div className="md:flex gap-4">
                                    <div className="mt-4 md:grow">
                                        <InputLabel forInput="name" value="Name*" />

                                        <TextInput
                                            type="text"
                                            name="name"
                                            value={data.name}
                                            className="mt-1 block w-full"
                                            autoComplete="name"
                                            handleChange={onHandleChange}
                                            required
                                        />

                                        <InputError message={errors.name} className="mt-2" />
                                    </div>

                                    <div className="mt-4 md:grow">
                                        <InputLabel forInput="brewery" value="Brewery*" />

                                        <TextInput
                                            type="text"
                                            name="brewery"
                                            value={data.brewery}
                                            className="mt-1 block w-full"
                                            handleChange={onHandleChange}
                                            required
                                        />

                                        <InputError message={errors.brewery} className="mt-2" />
                                    </div>
                                </div>

                                <div className="md:flex gap-4">
                                    <div className="flex gap-4 mt-4">
                                        <div>
                                            <InputLabel forInput="rating" value="Rating (as decimal number)*" />

                                            <TextInput
                                                type="text"
                                                name="rating"
                                                value={data.rating}
                                                className="mt-1 block w-full"
                                                handleChange={onHandleChange}
                                                required
                                            />

                                            <InputError message={errors.rating} className="mt-2" />
                                        </div>

                                        <div>
                                            <InputLabel forInput="alcohol_percent" value="Alcohol Percent (as decimal number)" />

                                            <TextInput
                                                type="text"
                                                name="alcohol_percent"
                                                value={data.alcohol_percent}
                                                className="mt-1 block w-full"
                                                handleChange={onHandleChange}
                                            />

                                            <InputError message={errors.alcohol_percent} className="mt-2" />
                                        </div>
                                    </div>

                                    <div className="flex gap-4 mt-4">
                                        <div>
                                            <InputLabel forInput="category" value="Category" />

                                            <select
                                                value={data.category}
                                                onChange={(e) => setData({category: e.target.value})}
                                                className="text-gray-500 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 flex mt-1"
                                            >
                                                {categories.map(category => (
                                                    <option key={category.id} value={category.id}>{category.type}</option>
                                                ))}
                                            </select>

                                            <InputError message={errors.category} className="mt-2" />
                                        </div>

                                        <div>
                                            <InputLabel forInput="has_lactose" value="Has Lactose" />

                                            <input
                                                className="rounded-md shadow-sm border-gray-300 focus:border-indigo-300
                                                focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-6 h-6 block md:w-10
                                                md:h-10 mt-1 checked:bg-pink-400 focus:bg-pink-400 "
                                                id="hasLactose"
                                                type="checkbox"
                                                name="has_lactose"
                                                checked={data.has_lactose}
                                                onChange={() => setData({has_lactose: !data.has_lactose})}
                                            />

                                            <InputError message={errors.has_lactose} className="mt-2" />
                                        </div>
                                    </div>
                                </div>

                                <div className="mt-4">
                                    <InputLabel forInput="comments" value="Comments" />

                                    <textarea
                                        className="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full"
                                        id="comments"
                                        rows="4"
                                        name="comments"
                                        value={data.comments}
                                    >
                                    </textarea>

                                    <InputError message={errors.comments} className="mt-2" />
                                </div>

                                <div className="mt-4">
                                    <InputLabel forInput="image" value="Add Image" />

                                    <input
                                        className="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full rounded-none"
                                        id="image"
                                        type="file"
                                        name="image"
                                    />

                                    <InputError message={errors.image} className="mt-2" />
                                </div>

                                <div className="flex gap-4">
                                    <button type="submit"
                                            className="inline-flex items-center px-10 py-6 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mt-8">
                                        Add
                                    </button>
                                    <button type="submit"
                                            className="inline-flex items-center px-10 py-6 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mt-8">
                                        Exit
                                    </button>
                                </div>

                                {/*<div className="flex items-center justify-end mt-4">*/}
                                {/*    <Link href={route('login')} className="underline text-sm text-gray-600 hover:text-gray-900">*/}
                                {/*        Already registered?*/}
                                {/*    </Link>*/}

                                {/*    <PrimaryButton className="ml-4" processing={processing}>*/}
                                {/*        Register*/}
                                {/*    </PrimaryButton>*/}
                                {/*</div>*/}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
