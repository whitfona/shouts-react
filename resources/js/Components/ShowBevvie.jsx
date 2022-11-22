import React, {useState} from 'react';
import PublicBeerDetails from "@/Components/PublicBeerDetails";
import {useForm} from "@inertiajs/inertia-react";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";

export default function ShowBevvie({beer, setShowBevvieModal, userId}) {

    const [addRating, setAddRating] = useState(false)
    const [showError, setShowError] = useState(false)
    const { data, setData, post, errors } = useForm({
        beer_id: beer.id,
        user_id: userId,
        comment: '',
        rating: ''
    });

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.type === 'checkbox' ? event.target.checked : event.target.value);
    };

    const submit = (e) => {
        e.preventDefault();

        post(route('ratings.store'), {
            onSuccess: () => setShowBevvieModal(false)
        })
    }

    const showAddRatingSection = () => {
        if (userId === -1) {
            setShowError(true)
        } else {
            setAddRating(true)
        }
    }

    return (
        <div className="fixed top-0 right-0 bottom-0 left-0 overflow-y-scroll p-4 bg-pink-100">
            <PublicBeerDetails beer={beer} />
            {showError &&
                <p className="mt-4 px-2 text-lg text-red-600">You must be logged in to rate this beer. <br/><a
                    href={route('login')}>Click HERE to log in</a></p>
            }
            {addRating &&
                <>
                    <h2 className="font-semibold text-xl leading-tight mt-4">Add Your Rating</h2>
                    <form onSubmit={submit}>
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

                        <div className="flex gap-4">
                            <button type="submit"
                                    className="inline-flex items-center px-10 py-6 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mt-8">
                                Save
                            </button>
                            <button
                                onClick={() => setShowBevvieModal(false)}
                                type="button"
                                className="inline-flex items-center px-10 py-6 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mt-8"
                            >
                                Exit
                            </button>
                        </div>
                    </form>
                </>
            }

            {addRating ? null : <div className="flex gap-4">
                <button
                    onClick={showAddRatingSection}
                    type="button"
                    className="inline-flex items-center px-10 py-6 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mt-8"
                >
                    Add Rating
                </button>
                <button
                    onClick={() => setShowBevvieModal(false)}
                    type="button"
                    className="inline-flex items-center px-10 py-6 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mt-8"
                >
                    Exit
                </button>
            </div>}
        </div>
    );
}
