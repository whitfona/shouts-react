import React from 'react';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head } from '@inertiajs/inertia-react';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";

export default function About(props) {

    return (
        <>
            {props.auth.user ?
                <AuthenticatedLayout
                    auth={props.auth}
                    errors={props.errors}
                    header={<h2 className="font-semibold text-xl text-white leading-tight">About</h2>}
                >
                    <Head title="About Shouts" />

                    <div className="max-w-7xl bg-pink-400 mx-auto p-4">
                        <div className="bg-white overflow-hidden shadow-sm rounded-lg">
                            <p className="p-8">
                                Have you ever been drinking with your pals and thought, <em>"Well how do you do, this certainly is a splendid tasting brew! I sure would like to wet my palate with this again."</em> But then proceeded to sample a few many cold ones that they all became a blur? Having experienced a similar situation, <strong>SHOUTS</strong> is here so that never happens again. Add, rate and share your bevvies, so you can enjoy your favourites and will never again have to suffer through a bevvie a previous you forgot you disliked.
                            </p>
                        </div>
                    </div>
                </AuthenticatedLayout>
                :
                <GuestLayout
                >
                    <Head title="About" />

                    <p className="p-8">
                        Have you ever been drinking with your pals and thought, <em>"Well how do you do, this certainly is a splendid tasting brew! I sure would like to wet my palate with this again."</em> But then proceeded to sample a few many cold ones that they all became a blur? Having experienced a similar situation, <strong>SHOUTS</strong> is here so that never happens again. Add, rate and share your bevvies, so you can enjoy your favourites and will never again have to suffer through a bevvie a previous you forgot you disliked.
                    </p>


                </GuestLayout>
            }
        </>
    );
}
