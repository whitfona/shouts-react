import InputLabel from "@/Components/InputLabel";
import InputError from "@/Components/InputError";
import React from "react";
import heic2any from "heic2any";

export default function FileInput ({ setPreviewImage, error, setData }) {

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

    return (
        <div className="mt-4">
            <InputLabel forInput="photo" value="Add Image" />

            <input
                className="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full rounded-none"
                id="photo"
                type="file"
                name="photo"
                onChange={onHandleFileChange}
            />

            <InputError message={error} className="mt-2" />
        </div>
    )
}
