export default function Modal ({children}) {
    return (
        <div className="fixed top-0 right-0 bottom-0 left-0 overflow-y-scroll p-4 bg-pink-100">
            {children}
        </div>
    )
}
