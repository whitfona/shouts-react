import React, {useEffect, useState} from 'react';
import {useForm} from '@inertiajs/inertia-react';
import InputLabel from "@/Components/Inputs/InputLabel";
import TextInput from "@/Components/Inputs/TextInput";
import InputError from "@/Components/Inputs/InputError";
import Modal from "@/Components/Modals/Modal";
import TypeaheadInput from "@/Components/Inputs/TypeaheadInput";
import FileInput from "@/Components/Inputs/FileInput";

export default function UpdateBevvie({beer, setShowUpdateModal}) {

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
    const [breweries, setBreweries] = useState([])
    const [previewImage, setPreviewImage] = useState('')

    useEffect(() => {
        fetch(route('categories.index'))
            .then(res => res.json())
            .then(data => {
                setCategories(data)
            })
            .catch(err => console.log(err))

        fetch(route('beers.index'))
            .then(res => res.json())
            .then(data => {
                const beersSet = new Set(data.map(beer => beer.brewery))
                setBreweries(Array.from(beersSet))
            })
            .catch(err => console.log(err))

        const checked = beer.has_lactose === 1
        setData({
            alcohol_percent: beer.alcohol_percent ? beer.alcohol_percent : '',
            barcode:  beer.barcode ? beer.barcode : '',
            beer_id: beer.beer_id,
            brewery: beer.brewery,
            category_id: beer.category_id,
            comment: beer.comment ? beer.comment : '',
            has_lactose: checked,
            name: beer.name,
            photo: beer.photo ? beer.photo : '',
            rating: beer.rating
        })

        if (beer.photo) {
            setPreviewImage(beer.photo)
        }
    }, [])

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.type === 'checkbox' ? event.target.checked : event.target.value);
    };

    const breweryFound = (e) => {
        if (e.length === 1) {
            const brewery = e[0]

            setData('brewery', brewery)
        }
    }

    const submit = (e) => {
        e.preventDefault();

        post(route('beers.store'), {
            onSuccess: () => setShowUpdateModal(false)
        });
    };

    return (
         <Modal>
            <form onSubmit={submit} className="p-4 bg-white shadow-sm rounded-lg">
                <input type="hidden" id="beer_id" name="beer_id" value={data.beer_id} />
                <div className="font-semibold pb-4 text-xl leading-tight">Update Bevvie</div>
                <div>
                    {previewImage && <img className="w-[192px] h-[256px] mb-3 md:mb-0 m-auto" src={previewImage} alt={data.name} />}
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

                        <TypeaheadInput
                            data={breweries}
                            onInputChange={(e) => setData('brewery', e)}
                            onChange={breweryFound}
                            initialValue={beer.brewery}
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

                <FileInput
                    setPreviewImage={setPreviewImage}
                    error={errors.photo}
                    setData={setData}
                />

                <div className="flex gap-4">
                    <button type="submit"
                            className="inline-flex items-center px-10 py-6 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mt-8">
                        Save
                    </button>
                    <button
                        onClick={() => setShowUpdateModal(false)}
                        type="submit"
                        className="inline-flex items-center px-10 py-6 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mt-8"
                    >
                        Exit
                    </button>
                </div>
            </form>
         </Modal>
    );
}
