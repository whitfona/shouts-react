import React, {useEffect, useState} from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, Link, useForm, usePage} from '@inertiajs/inertia-react';
import PrivateBeerDetails from "@/Components/PrivateBeerDetails";
import Header from "@/Components/Header";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import Checkbox from "@/Components/Checkbox";
import PrimaryButton from "@/Components/PrimaryButton";
import BarcodeScanner from "@/Components/BarcodeScanner";
import {Typeahead} from "react-bootstrap-typeahead";

export default function Dashboard(props) {
    const { flash } = usePage().props
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: '',
    });
    const [showPassword, setShowPassword] = useState(false);

    useEffect(() => {
        return () => {
            reset('password');
        };
    }, []);

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.type === 'checkbox' ? event.target.checked : event.target.value);
    };

    const submit = (e) => {
        e.preventDefault();

        post(route('login'));
    };


    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-white leading-tight">Update Profile</h2>}
        >
            <Head title="Profile" />

            <div className="max-w-7xl bg-pink-400 mx-auto p-4">
                <div className="bg-white overflow-hidden shadow-sm rounded-lg">
                    <form onSubmit={submit} className="p-4">
                        <input type="hidden" id="user_id" name="user_id" value={data.user_id} />
                        <div className="mt-4 md:grow">
                            <InputLabel forInput="name" value="Name*" />

                            <TextInput
                                type="text"
                                name="name"
                                value={data.name}
                                className="mt-1 block w-full md:w-auto"
                                autoComplete="name"
                                handleChange={onHandleChange}
                            />

                            <InputError message={errors.name} className="mt-2" />
                        </div>

                        <div className="mt-4 md:grow">
                            <InputLabel forInput="email" value="Email*"/>

                            <TextInput
                                type="email"
                                name="email"
                                value={data.email}
                                className="mt-1 block w-full"
                                autoComplete="email"
                                handleChange={onHandleChange}
                                required
                            />

                            <InputError message={errors.email} className="mt-2" />
                        </div>

                        <div className="mt-4 md:grow">
                            <InputLabel forInput="photo" value="Profile Image" />

                            {data.photo && <img className="w-[192px] h-[256px] mb-3 md:mb-0 m-auto" src={data.photo} />}

                            <input
                                className="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full rounded-none"
                                id="photo"
                                type="file"
                                name="photo"
                            />

                            <InputError message={errors.photo} className="mt-2" />
                        </div>
                        <div className="flex gap-4">
                            <button type="submit"
                                    className="inline-flex items-center px-10 py-6 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mt-8">
                                Update
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
