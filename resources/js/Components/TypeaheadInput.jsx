import {Typeahead} from "react-bootstrap-typeahead";
import React from "react";

export default function TypeaheadInput ({data, onChange, onInputChange, placeholder, labelKey}) {
    return (
        <Typeahead
            placeholder={placeholder}
            onChange={onChange}
            onInputChange={onInputChange}
            options={data}
            id="id"
            clearButton={true}
            labelKey={labelKey}
            className="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full md:w-auto"
        />
    )
}

// <Typeahead
//     onChange={getSearchedBeer}
//     placeholder={'Search for beer...'}
//     options={beers}
//     id="id"
//     clearButton={true}
//     labelKey={beer => `${beer.name} | ${beer.brewery} | ${beer.alcohol_percent}% | ${beer.category}`}
//     className="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full md:w-auto"
// />
