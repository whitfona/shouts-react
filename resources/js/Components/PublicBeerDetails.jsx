import React from 'react'
import DetailFormat from "@/Components/DetailFormat";

export default function PublicBeerDetails({beer, searchByBrewery, searchByUser}) {
    return (
        <div className="md:flex gap-4 p-4 mb-4 md:mb-10" key={beer.id}>
            <img className="w-[192px] h-[256px] mb-3 md:mb-0" src={beer.photo} />
            <div className="w-full">
                {/*<p>Barcode: {beer.barcode}</p>*/}
                <div className="md:flex flex-wrap justify-between gap-x-2 gap-y-0 mb-3">
                    <DetailFormat name={'Name'} value={beer.name} />
                    <DetailFormat name={'Avg. Rating'} value={beer.avg_rating} />
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
                <div key={beer.id}>
                    {beer.ratings.map(rating => (
                        <div key={rating.id}>
                            <div className="mb-4">
                                <p>
                                    <span className="text-md font-semibold tracking-wide uppercase">Added By: </span>
                                    <button onClick={() => searchByUser(rating.user_id)}>
                                    <img className="w-8 h-8 rounded-full inline" src={rating.user_photo} /> {rating.user}</button> | {rating.date_added}</p>
                                {/*<p><span className="text-md font-semibold tracking-wide uppercase">Added By: </span><img className="w-8 h-8 rounded-full inline" src={rating.user_photo} /> {rating.user} | {rating.date_added}</p>*/}
                                <p><span className="text-md font-semibold tracking-wide uppercase">Rating: </span>{rating.rating}</p>
                                <p><span className="text-md font-semibold tracking-wide uppercase">Comment: </span>{rating.comment}</p>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </div>
    )
}
