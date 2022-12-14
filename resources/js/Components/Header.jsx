export default function Header({categories, message, search, handleSearch, searchByCategory}) {
    return (
        <header className="bg-pink-100 p-6">
            <input
                className="rounded-md shadow-sm text-gray-500 border-gray-300 focus:border-indigo-300 focus:ring
                focus:ring-indigo-200 focus:ring-opacity-50 mb-2 w-full md:w-1/3"
                type="text"
                placeholder={'Search...'}
                value={search}
                onChange={handleSearch}
            />
            <select
                onChange={searchByCategory}
                defaultValue={'disabled'}
                className="text-gray-500 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring
                focus:ring-indigo-200 focus:ring-opacity-50 flex w-full md:w-1/3"
            >
                <option value={'disabled'} disabled>Filter by Category</option>
                <option key={-1} value={-1}>All</option>
                {categories.map(category => (
                    <option key={category.id} value={category.id}>{category.type}</option>
                ))}
            </select>
            <p>{message}</p>
        </header>
    )
}
