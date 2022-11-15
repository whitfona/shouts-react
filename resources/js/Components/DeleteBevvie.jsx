import React from 'react';
import {useForm} from '@inertiajs/inertia-react';

export default function DeleteBevvie({beer, setShowDeleteModal}) {

    const { data, post } = useForm({
        beer_id: beer.beer_id
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('beers.user.destroy'));
        setShowDeleteModal(false)
    };


    return (
         <div className="fixed top-0 right-0 bottom-0 left-0 overflow-y-scroll p-4 bg-pink-100">
            <form onSubmit={submit} className="p-4 bg-white shadow-sm rounded-lg">
                <p className="pb-4 text-xl leading-tight text-center">Are you sure you want to delete <span className="font-bold ">{beer.name}</span>?</p>

                <input type="hidden" id="beer_id" name="beer_id" value={data.beer_id} />
                <div className="flex justify-center gap-4">
                    <button
                        type="submit"
                        className="inline-flex items-center px-10 py-6 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mt-8"
                    >
                        Delete
                    </button>
                    <button
                        onClick={() => setShowDeleteModal(false)}
                        type="submit"
                        className="inline-flex items-center px-10 py-6 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mt-8"
                    >
                        Exit
                    </button>
                </div>
            </form>
        </div>
    );
}
