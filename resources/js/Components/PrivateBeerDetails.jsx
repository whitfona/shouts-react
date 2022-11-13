import React from 'react'
import DetailFormat from "@/Components/DetailFormat";
import MagnifyingGlass from "@/Components/MagnifyingGlass";

export default function PrivateBeerDetails({beer, searchByBrewery, deleteBeer}) {
    return (
        <div className="md:flex gap-4 p-4 mb-4 md:mb-10" key={beer.id}>
            <div>
                <img className="max-w-none w-[192px] h-[256px] mb-3 md:mb-0" src={beer.photo} />
                <div className="flex gap-x-2 mb-3">
                    <button onClick={() => deleteBeer(beer.rating_id)}
                        className="max-w-fit sm:px-6 rounded-md mt-6 p-4 bg-pink-400 hover:cursor-pointer hover:bg-pink-300 inline-block text-md text-white font-extrabold uppercase">
                        Delete
                    </button>
                    <button
                        className="max-w-fit sm:px-6 rounded-md mt-6 p-4 bg-pink-400 hover:cursor-pointer hover:bg-pink-300 inline-block text-md text-white font-extrabold uppercase">
                        Edit
                    </button>
                </div>
            </div>
            <div className="w-full">
                {/*<p>Barcode: {beer.barcode}</p>*/}
                <div className="md:flex flex-wrap justify-between gap-x-2 gap-y-0 mb-3">
                    <DetailFormat name={'Name'} value={beer.name} />
                    <DetailFormat name={'Rating'} value={beer.rating} />
                    <DetailFormat name={'Category'} value={beer.category} />
                </div>
                <div className="md:flex flex-wrap justify-between gap-x-2 gap-y-0 mb-3">
                    <h2 className="text-lg min-w-[15%]">
                        <span className="font-semibold tracking-wide uppercase">Percent: </span>
                        {beer.alcohol_percent}%
                    </h2>
                    <h2 className="text-lg min-w-[15%]">
                        <span className="font-semibold tracking-wide uppercase">Brewery: </span>
                        <button onClick={() => searchByBrewery(beer.brewery)}> {beer.brewery}</button>
                    </h2>
                    <DetailFormat name={'Lactose'} value={beer.has_lactose ? 'Yes' : 'No'} />
                </div>
                <div className="md:flex flex-wrap justify-between gap-x-2 gap-y-0 mb-3">
                    <h2 className="text-lg">
                        <span className="font-semibold tracking-wide uppercase">Date Added: </span>
                        {beer.date_added}
                    </h2>
                    <h2 className="text-lg">
                        <span className="font-semibold tracking-wide uppercase">Comment: </span>
                        {beer.comment}
                    </h2>
                </div>
            </div>
        </div>
    )
}
