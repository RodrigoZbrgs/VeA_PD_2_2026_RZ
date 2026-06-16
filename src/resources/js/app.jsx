import '../css/loader.css'
import { useEffect, useState } from "react";

export default function App() {
    const [selectedAlbumID, setSelectedAlbumID] = useState(null);
    // funkcija Album ID saglabāšanai stāvoklī
    function handleAlbumSelection(albumID) {
        setSelectedAlbumID(albumID);
    }

    // funkcija grāmatas izvēles atcelšanai
    function handleGoingBack() {
        setSelectedAlbumID(null);
    }

    return (
        <>
            <Header />
            <main className="mb-8 px-2 md:container md:mx-auto" >
                {
                    selectedAlbumID
                        ? <AlbumPage
                            selectedAlbumID={selectedAlbumID}
                            handleAlbumSelection={handleAlbumSelection}
                            handleGoingBack={handleGoingBack}
                        />
                        : <Homepage handleAlbumSelection={handleAlbumSelection} />

                }
            </main>
            <Footer />
        </>
    )
}
// Grāmatas lapa – strukturāla komponente, kas satur grāmatas lapas daļas
function AlbumPage({ selectedAlbumID, handleAlbumSelection, handleGoingBack }) {
    return (
        <>
            <SelectedAlbumView
                selectedAlbumID={selectedAlbumID}
                handleGoingBack={handleGoingBack}
            />
            <RelatedAlbumSection
                selectedAlbumID={selectedAlbumID}
                handleAlbumSelection={handleAlbumSelection}
            />
        </>
    )
}

function RelatedAlbumSection({ selectedAlbumID, handleAlbumSelection }) {
    const [RelatedAlbums, setRelatedAlbums] = useState([]);
    const [isLoading, setIsLoading] = useState(false);
    const [error, setError] = useState(null);

    useEffect(function () {
        async function fetchRelatedAlbums() {
            try {
                setIsLoading(true);
                setError(null);
                const response = await fetch('http://localhost/data/get-related-albums/' + selectedAlbumID);

                if (!response.ok) {
                    throw new Error("Datu ielādes kļūda. Lūdzu, pārlādējiet lapu!");
                }

                const data = await response.json();
                console.log('related albums fetched', data);
                setRelatedAlbums(data);
            } catch (error) {
                setError(error.message);
            } finally {
                setIsLoading(false);
            }
        }

        fetchRelatedAlbums();
    }, [selectedAlbumID]);

    return (
        <>
            <div className="flex flex-wrap">
                <h2 className="text-3xl leading-8 font-light text-neutral-900 mb-4">
                    Līdzīgi albumi
                </h2>
            </div>
            {isLoading && <Loader />}
            {error && <ErrorMessage msg={error} />}
            {!isLoading && !error && (
                <div className="flex flex-wrap md:flex-row md:space-x-4 md:flex-nowrap">
                    {RelatedAlbums.map(Album => (
                        <RelatedAlbumView
                            Album={Album}
                            key={Album.id}
                            handleAlbumSelection={handleAlbumSelection}
                        />
                    ))}
                </div>
            )}
        </>
    )
}

// Top grāmatas skats- attēlo sākumlapas grāmatas
function TopAlbumView({ album, index, handleAlbumSelection }) {
    return (
        <div className="bg-neutral-100 rounded-lg mb-8 py-8 flex flex-wrap md:flex-row">
            <div className=
                {`order-2 px-12 md:basis-1/2
                    ${index % 2 === 1 ? "md:order-1 md:text-right" : ""}
                `}
            >
                <h2 className="mb-4 text-3xl leading-8 font-light text-neutral-900">
                    {album.name}
                </h2>
                <SeeMoreBtn
                    albumID={album.id}
                    handleAlbumSelection={handleAlbumSelection}
                />
            </div>
            <div className=
                {`order-1 md:basis-1/2 ${index % 2 === 1 ? "md:order-2" : ""}`}
            >
                <img
                    src={album.image}
                    alt={album.name}
                    className="p-1 rounded-md border border-neutral-200 w-2/4 aspect-auto mx-auto" />
            </div>
        </div>
    )
}

function SelectedAlbumView({ selectedAlbumID, handleGoingBack }) {
    const [selectedAlbum, setSelectedAlbum] = useState({});
    const [isLoading, setIsLoading] = useState(false);
    const [error, setError] = useState(null);

    useEffect(function () {
        async function fetchSelectedAlbum() {
            try {
                setIsLoading(true);
                setError(null);
                const response = await fetch('http://localhost/data/get-album/' + selectedAlbumID);

                if (!response.ok) {
                    throw new Error("Datu ielādes kļūda. Lūdzu, pārlādējiet lapu!");
                }

                const data = await response.json();
                console.log('album ' + selectedAlbumID + ' fetched', data);
                setSelectedAlbum(data);
            } catch (error) {
                setError(error.message);
            } finally {
                setIsLoading(false);
            }
        }
        fetchSelectedAlbum();
    }, [selectedAlbumID]);

    return (
        <>
            {isLoading && <Loader />}
            {error && <ErrorMessage msg={error} />}
            {!isLoading && !error && <>
                <div className="rounded-lg flex flex-wrap md:flex-row">
                    <div className="order-2 md:order-1 md:pt-12 md:basis-1/2">
                        <h1 className="text-3xl leading-8 font-light text-neutral-900 mb-2">
                            {selectedAlbum.name}
                        </h1>
                        <p className="text-xl leading-7 font-light text-neutral-900 mb-2">
                            {selectedAlbum.artist}
                        </p>
                        <dl className="mb-4 md:flex md:flex-wrap md:flex-row">
                            <dt className="font-bold md:basis-1/4">
                                Izdošanas gads
                            </dt>
                            <dd className="mb-2 md:basis-3/4">
                                {selectedAlbum.year}
                            </dd>

                            <dt className="font-bold md:basis-1/4">
                                Straumejumi
                            </dt>
                            <dd className="mb-2 md:basis-3/4">
                                {selectedAlbum.streams}
                            </dd>

                            <dt className="font-bold md:basis-1/4">
                                Žanrs
                            </dt>
                            <dd className="mb-2 md:basis-3/4">
                                {selectedAlbum.genre}
                            </dd>
                        </dl>
                    </div>
                    <div className="order-1 md:order-2 md:pt-12 md:px-12 md:basis-1/2">
                        <img
                            src={selectedAlbum.image}
                            alt={selectedAlbum.name}
                            className="p-1 rounded-md border border-neutral-200 mx-auto" />
                    </div>
                </div>
                <div className="mb-12 flex flex-wrap">
                    <GoBackBtn handleGoingBack={handleGoingBack} />
                </div>
            </>}
        </>
    )
}

// Līdzīgās grāmatas skats
function RelatedAlbumView({ Album, handleAlbumSelection }) {
    return (
        <div className="rounded-lg mb-4 md:basis-1/3">
            <img
                src={Album.image}
                alt={Album.name}
                className="md:h-[400px] md:mx-auto max-md:w-2/4 max-md:mx-auto" />
            <div className="p-4">
                <h3 className="text-xl leading-7 font-light text-neutral-900 mb-4">
                    {Album.name}
                </h3>
                <SeeMoreBtn
                    AlbumID={Album.id}
                    handleAlbumSelection={handleAlbumSelection}
                />
            </div>
        </div>
    )
}



// Sākumlapa- ielādē datus no API un attēlo top grāmatas
function Homepage({ handleAlbumSelection }) {
    const [TopAlbums, setTopAlbums] = useState([]);
    const [isLoading, setIsLoading] = useState(false);
    const [error, setError] = useState(null);

    useEffect(function () {
        async function fetchTopAlbums() {
            try {
                setIsLoading(true);
                setError(null);
                const response = await fetch('http://localhost/data/get-top-albums');

                if (!response.ok) {
                    throw new Error("Datu ielādes kļūda. Lūdzu, pārlādējiet lapu!");
                }

                const data = await response.json();
                console.log('top albums fetched', data);
                setTopAlbums(data);
            } catch (error) {
                setError(error.message);
            } finally {
                setIsLoading(false);
            }
        }

        fetchTopAlbums();
    }, []);

    return (
        <>
            {isLoading && <Loader />}
            {error && <ErrorMessage msg={error} />}
            {!isLoading && !error && (TopAlbums.map((album, index) => (
                <TopAlbumView
                    album={album}
                    key={album.id}
                    index={index}
                    handleAlbumSelection={handleAlbumSelection}
                />
            )))}
        </>
    )
}

// Galvene un kājene – strukturālas komponentes bez funkcijām vai datiem 
function Header() {
    return (
        <header className="bg-green-500 mb-8 py-2 sticky top-0">
            <div className="px-2 py-2 font-serif text-green-50 text-xl 
leading-6 md:container md:mx-auto" >
                Musicfy &#127929;
            </div>
        </header>
    )
}

function Footer() {
    return (
        <footer className="bg-neutral-300 mt-8">
            <div className="py-8 md:container md:mx-auto px-2">
                R.Zandbergs, VeA, 2026
            </div>
        </footer>
    )
}

// Poga “Rādīt vairāk”
function SeeMoreBtn({ albumID, handleAlbumSelection }) {
    return (
        <button
            className="inline-block rounded-full py-2 px-4 bg-sky-500 hover:bg-sky-400 text-sky-50 cursor-pointer"
            onClick={() => handleAlbumSelection(albumID)}
        >Rādīt vairāk</button>
    )
}

// Poga “Uz sākumu”
function GoBackBtn({ handleGoingBack }) {
    return (
        <button
            className="inline-block rounded-full py-2 px-4 bg-neutral-500 hover:bg-neutral-400 text-neutral-50 cursor-pointer"
            onClick={handleGoingBack}
        >Uz sākumu</button>
    )
}

// Ielādes indikators un kļūdas
function Loader() {
    return (
        <div className="my-12 px-2 md:container md:mx-auto text-center clear-both">
            <span class="loader"></span>
        </div>
    )
}

function ErrorMessage({ msg }) {
    return (
        <div className="md:container md:mx-auto bg-red-300 my-8 p-2">
            <p className="text-black">{msg}</p>
        </div>
    )
}
