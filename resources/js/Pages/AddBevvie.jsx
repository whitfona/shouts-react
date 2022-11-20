import React, {useEffect, useState} from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, Link, useForm} from '@inertiajs/inertia-react';
import BarcodeScanner from "@/Components/BarcodeScanner";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import { Typeahead } from "react-bootstrap-typeahead";
import heic2any from "heic2any";

export default function AddBevvie(props) {

    const { data, setData, post, errors } = useForm({
        alcohol_percent: '',
        barcode: '',
        beer_id: '',
        brewery: '',
        category_id: 1,
        comment: '',
        has_lactose: false,
        name: '',
        photo: '',
        rating: ''
    });
    const [categories, setCategories] = useState([])
    const [beers, setBeers] = useState([])
    const [message, setMessage] = useState('')
    const [previewImage, setPreviewImage] = useState('')

    useEffect(() => {
        fetch(route('beers.index'))
            .then(res => res.json())
            .then(data => {
                setBeers(data)
            })
            .catch(err => console.log(err))
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

    const onHandleFileChange = (event) => {
        const file = event.target.files[0]

        setData(event.target.name, file);

        if (file.type === "image/heic") {
            heic2any({
                blob: file,
                toType: 'image/jpeg',
            }).then(blob => {
                setPreviewImage(URL.createObjectURL(blob))
            }, error => {
                console.log(error)
            });
        } else {
            setPreviewImage(URL.createObjectURL(file))
        }
    };

    const getScannedBeer = (barcode) => {
        clearAllFields()
        setMessage('')
        fetch(route('beers.user.barcode', barcode))
            .then(res => res.json())
            .then(data => {
                // if no matches are returned
                if (Object.keys(data).length === 0) {
                    setFields({barcode: barcode})
                    setMessage('Sorry, no match found. Please try again or enter manually.')
                } else {
                    const checked = data.has_lactose === 1
                    setFields(data, checked)
                }
            })
            .catch(err => setMessage("Sorry, error fetching beers."))
    }

    const getSearchedBeer = (e) => {
        clearAllFields()

        if (e.length === 1) {
            const beer = e[0].id

            fetch(route('beers.user.beer', beer))
                .then(res => res.json())
                .then(data => {
                    const checked = data.has_lactose === 1
                    setFields(data, checked)
                })
                .catch(err => setMessage("Sorry, error fetching beer."))
        }
    }

    const submit = (e) => {
        e.preventDefault();

        post(route('beers.store'));
    };

    const setFields = (data, checked) =>{
        setData({
            alcohol_percent: data.alcohol_percent ? data.alcohol_percent : '',
            barcode:  data.barcode ? data.barcode : '',
            beer_id: data.beer_id,
            brewery: data.brewery,
            category_id: data.category_id ? data.category_id : 1,
            comment: data.comment ? data.comment : '',
            has_lactose: checked,
            name: data.name,
            photo: data.photo ? data.photo : '',
            rating: data.rating ? data.rating : ''
        })

        if (data.photo) {
            setPreviewImage(`http://localhost:8000/storage/beers/${data.photo}`)
            // setPreviewImage(`https://itsyourshout.ca/storage/beers/${data.photo}`)
        }
    }

    const clearAllFields = async () => {
        await setData({
            alcohol_percent: '',
            barcode: '',
            beer_id: '',
            brewery: '',
            category_id: 1,
            comment: '',
            has_lactose: false,
            name: '',
            photo: '',
            rating: ''
        })
    }

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-white leading-tight">Add Bevvie</h2>}
        >
            <Head title="Add Bevvie" />

            <div className="max-w-7xl bg-pink-400 mx-auto p-4">
                <div className="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div className="p-4 border-b border-gray-200T">
                        <BarcodeScanner getScannedBeers={getScannedBeer} />
                        <p className="text-center my-3">OR</p>
                        <Typeahead
                            onChange={getSearchedBeer}
                            placeholder={'Search for beer...'}
                            options={beers}
                            id="id"
                            clearButton={true}
                            labelKey={beer => `${beer.name} | ${beer.brewery} | ${beer.alcohol_percent}% | ${beer.category}`}
                            className="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full md:w-auto"
                        />
                        <p className="text-red-500 mt-4">{message}</p>
                    </div>
                    <form onSubmit={submit} className="p-4">
                        <input type="hidden" id="beer_id" name="beer_id" value={data.beer_id} />
                        <InputError message={errors.beer_id} className="mt-2" />
                        <div>
                            {previewImage && <img className="w-[192px] h-[256px] mb-3 md:mb-0 m-auto" src={previewImage} />}
                        </div>
                        <div>
                            <InputLabel forInput="barcode" value="Barcode" />

                            <TextInput
                                type="text"
                                name="barcode"
                                value={data.barcode}
                                className="mt-1 block w-full md:w-auto"
                                autoComplete="name"
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
                                    <InputLabel forInput="category_id" value="Category" />

                                    <select
                                        value={data.category_id}
                                        onChange={(e) => setData('category_id', e.target.value)}
                                        className="text-gray-500 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 flex mt-1"
                                    >
                                        {categories.map(category => (
                                            <option key={category.id} value={category.id}>{category.type}</option>
                                        ))}
                                    </select>

                                    <InputError message={errors.category_id} className="mt-2" />
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
                                        onChange={onHandleChange}
                                    />

                                    <InputError message={errors.has_lactose} className="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div className="mt-4">
                            <InputLabel forInput="rating" value="Rating (as decimal number)*" />

                            <TextInput
                                type="text"
                                name="rating"
                                value={data.rating}
                                className="mt-1 block"
                                handleChange={onHandleChange}
                                required
                            />

                            <InputError message={errors.rating} className="mt-2" />
                        </div>

                        <div className="mt-4">
                            <InputLabel forInput="comment" value="Comments" />

                            <textarea
                                className="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full"
                                id="comment"
                                rows="4"
                                name="comment"
                                onChange={onHandleChange}
                                value={data.comment}
                            >
                            </textarea>

                            <InputError message={errors.comment} className="mt-2" />
                        </div>

                        <div className="mt-4">
                            <InputLabel forInput="photo" value="Add Image" />

                            <input
                                className="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full rounded-none"
                                id="photo"
                                type="file"
                                name="photo"
                                onChange={onHandleFileChange}
                            />

                            <InputError message={errors.photo} className="mt-2" />
                        </div>

                        <div className="flex gap-4">
                            <button type="submit"
                                    className="inline-flex items-center px-10 py-6 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mt-8">
                                Save
                            </button>
                            <Link
                                href={route('dashboard')}
                                className="inline-flex items-center px-10 py-6 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mt-8"
                            >Exit
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
