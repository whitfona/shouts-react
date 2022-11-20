import React, {useEffect, useState} from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, Link, useForm, usePage} from '@inertiajs/inertia-react';
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import heic2any from "heic2any";

export default function Dashboard(props) {
    const { flash } = usePage().props
    const [showFlashMessage, setShowFlashMessage] = useState(false)
    const [previewImage, setPreviewImage] = useState('')
    const { data, setData, post, errors } = useForm({
        user_id: '',
        name: '',
        email: '',
        photo: '',
    });

    useEffect(() => {
        fetch(route('user.show'))
            .then(res => res.json())
            .then(data => {
                setData({
                    user_id: data.id,
                    name: data.name,
                    email: data.email,
                    photo: data.profile_image
                })
                if (data.profile_image) {
                    setPreviewImage(`http://localhost:8000/storage/users/${data.profile_image}`)
                    // setPreviewImage(`https://itsyourshout.ca/storage/users/${data.profile_image}`)
                }
            })
            .catch(err => console.log(err))
    }, []);

    useEffect(() => {
        if (!flash.message) {
            return
        }
        setShowFlashMessage(true)
        setTimeout(() => {
            setShowFlashMessage(false)
        }, 4000)
    }, [flash])

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value);
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

    const submit = (e) => {
        e.preventDefault();
        post(route('user.store'));
    };


    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-white leading-tight">Update Profile</h2>}
        >
            <Head title="Profile" />

            {showFlashMessage && (
                <span className="bg-pink-100 bottom-0 fixed p-4 right-0">{flash.message}</span>
            )}
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

                            {previewImage && <img className="md:w-80 mt-1 mb-2" src={previewImage} />}

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
