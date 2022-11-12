import React from 'react'

export default function DetailFormat({name, value}) {
    return (
        <h2 className="text-lg min-w-[15%]">
            <span className="font-semibold tracking-wide uppercase">{name}: </span>
            {value}
        </h2>
    )
}
