import React, {useEffect, useState} from 'react';
import Checkbox from '@/Components/Checkbox';
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, Link, useForm } from '@inertiajs/inertia-react';

export default function About({ status }) {

    return (
        <GuestLayout
        >
            <Head title="About" />

            <p>
                Have you ever been drinking with your pals and thought, <em>"Well how do you do, this certainly is a splendid tasting brew! I sure would like to wet my palate with this again."</em> But then proceeded to sample a few many cold ones that they all became a blur? Having experienced a similar situation, <strong>SHOUTS</strong> is here so that never happens again. Add, rate and share your bevvies, so you can enjoy your favourites and will never again have to suffer through a bevvie a previous you forgot you disliked.
            </p>


        </GuestLayout>
    );
}
