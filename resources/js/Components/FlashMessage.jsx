import React, {useEffect, useState} from "react";
import {usePage} from "@inertiajs/inertia-react";

export default function FlashMessage () {
    const { flash } = usePage().props

    const [showFlashMessage, setShowFlashMessage] = useState(false)

    useEffect(() => {
        if (!flash.message) {
            return
        }
        setShowFlashMessage(true)
        setTimeout(() => {
            setShowFlashMessage(false)
        }, 4000)
    }, [flash])

    return (
        <>
            {showFlashMessage && (
                <span className="bg-pink-100 bottom-0 fixed p-4 right-0">{flash.message}</span>
            )}
        </>
    );
}
