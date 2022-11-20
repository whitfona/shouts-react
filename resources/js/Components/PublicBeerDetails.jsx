import React from 'react'
import DetailFormat from "@/Components/DetailFormat";

export default function PublicBeerDetails({beer, searchByBrewery, searchByUser}) {
    return (
        <div className="border-t-8 border-pink-100 bg-white md:flex gap-4 p-4" key={beer.id}>
            <img className="w-[192px] mb-3 md:mb-0" src={`http://localhost:8000/storage/beers/${beer.photo}`} />
            {/*<img className="w-[192px] mb-3 md:mb-0" src={`https://itsyourshout.ca/storage/beers/${beer.photo}`} />*/}
            <div className="w-full">
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
                                        {rating.user_photo && <img className="w-8 h-8 rounded-full inline" src={`http://localhost:8000/storage/users/${rating.user_photo}`} />} {rating.user}</button> | {rating.date_added}</p>
                                        {/*{rating.user_photo && <img className="w-8 h-8 rounded-full inline" src={`https://itsyourshout.ca/storage/users/${rating.user_photo}`} />} {rating.user}</button> | {rating.date_added}</p>*/}
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
