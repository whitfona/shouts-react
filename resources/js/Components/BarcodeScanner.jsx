import Quagga from "@ericblade/quagga2";
import MagnifyingGlass from "@/Components/MagnifyingGlass";

export default function BarcodeScanner({getScannedBeers, setMessage}) {
    const startReader = () => {
        let countErrors = 0

        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.getElementById('reader')    // Or '#yourElement' (optional)
            },
            decoder: {
                readers: ["ean_reader", "upc_reader"]
            },
            locate: true
        }, function (err) {
            if (err) {
                console.log(err);
                return
            }
            console.log("Initialization finished. Ready to start");
            Quagga.start();
            document.getElementById("reader").style.display = 'block';
        });

        Quagga.onDetected(function (result) {

            const errors = result.codeResult.decodedCodes
                .filter(_ => _.error !== undefined)
                .map(_ => _.error);
            const median = getMedian( errors );
            if (median < 0.10) {
                // probably correct
                console.log(result.codeResult.code)
                stopReader()
                getScannedBeers(result.codeResult.code)
            }
            else {
                // probably wrong
                if (countErrors > 50) {
                    stopReader()
                    setMessage('Sorry, unable to find that beer.')
                }
                countErrors++
            }
        })
    }

    // Used to get the median value of the barcode error to check if the barcode is likely correct or not
    const getMedian = (arr) => {
        arr.sort((a, b) => a - b);
        const half = Math.floor( arr.length / 2 );
        if (arr.length % 2 === 1) // Odd length
            return arr[ half ];
        return (arr[half - 1] + arr[half]) / 2.0;
    }

    const stopReader = () => {
        Quagga.stop();
        document.getElementById("reader").style.display = 'none';
    }

    return (
        <>
            <button onClick={startReader}
                    className="max-w-fit mx-auto sm:px-6 rounded-md mb-4 p-4 bg-pink-400 flex
                                                justify-center items-center hover:cursor-pointer hover:bg-pink-300 text-4xl
                                                text-white font-extrabold uppercase pl-3 mt-6">
                <span className="w-16 bg-pink-200 p-3 rounded-full mr-2"><MagnifyingGlass /></span>
                Barcode
            </button>
            <div id="reader"/>
        </>
    )
}
