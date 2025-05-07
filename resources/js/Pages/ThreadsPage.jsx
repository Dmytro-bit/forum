import {Head} from "@inertiajs/react";
import {useEffect, useState} from "react";

export default function ThreadsPage() {
    const [threads, setThreads] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        fetch("/api/threads")
            .then((response) => response.json())
            .then((data) => {
                setThreads(data.data); // Assuming the API returns a `data` key
                setLoading(false);
            })
            .catch((error) => {
                console.error("Error fetching threads:", error);
                setLoading(false);
            });
    }, []);

    return (
        <>
            <Head title="Threads"/>
            <div className="container mx-auto py-8">
                <h1 className="text-2xl font-bold mb-4">Threads</h1>
                {loading ? (
                    <p>Loading threads...</p>
                ) : (
                    <ul className="space-y-4">
                        {threads.map((thread) => (
                            <li
                                key={thread.id}
                                className="p-4 border rounded shadow-sm"
                            >
                                <h2 className="text-xl font-semibold">
                                    {thread.title}
                                </h2>
                                <p className="text-gray-700">
                                    {thread.body.substring(0, 100)}...
                                </p>
                                <p className="text-sm text-gray-500">
                                    By {thread.user.name}
                                </p>
                            </li>
                        ))}
                    </ul>
                )}
            </div>
        </>
    );
}
