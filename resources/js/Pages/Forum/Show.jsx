import React, {useEffect, useState} from 'react';
import {Head, Link, useForm} from '@inertiajs/react';

export default function ThreadShow({thread, posts, sidebarThreads}) {
    const {data, setData, post, processing, reset} = useForm({body: ''});
    const [livePosts, setLivePosts] = useState(posts);

    useEffect(() => {
        const channel = window.Echo.channel(`thread.${thread.id}`);
        channel.listen('PostCreated', e => {
            setLivePosts(prev => [...prev, e]);
        });

        return () => {
            window.Echo.leaveChannel(`thread.${thread.id}`);
        };
    }, [thread.id]);


    const submit = (e) => {
        e.preventDefault();
        post(route('threads.posts.store', thread.id));
    };

    return (
        <>
            <Head title={thread.title}/>
            {/* Header */}
            <header className="bg-green-800 text-white py-4">
                <div className="container mx-auto flex justify-between items-center">
                    <h1 className="text-2xl font-bold">Forum</h1>
                    <nav>
                        <ul className="flex space-x-4">
                            <li><Link href="/" className="hover:underline">Home</Link></li>
                            <li><Link href="#" className="hover:underline">Forum</Link></li>
                            <li><Link href="#" className="hover:underline">About</Link></li>
                        </ul>
                    </nav>
                </div>
            </header>

            <div className="flex h-screen">
                {/* Sidebar */}
                <aside className="w-1/4 bg-gray-100 p-4 overflow-auto">
                    <h6 className="font-bold mb-2">Active Threads</h6>
                    <ul>
                        {sidebarThreads.map(t => (
                            <li key={t.id} className="mb-1">
                                <Link
                                    href={route('threads.show', t.id)}
                                    className={t.id === thread.id ? 'text-white bg-green-700 p-2 rounded block' : 'p-2 block hover:bg-gray-200 rounded'}
                                >{t.title}</Link>
                            </li>
                        ))}
                    </ul>
                    <Link href={route('threads.create')} className="mt-4 block text-green-600">+ New Thread</Link>
                </aside>

                {/* Main Chat Area */}
                <div className="flex-1 flex flex-col">
                    <header className="flex justify-between items-center p-4 border-b">
                        <h4 className="font-semibold">{thread.title}</h4>
                        <div>
                            <button className="mx-1"><i className="fas fa-video"/></button>
                            <button className="mx-1"><i className="fas fa-phone"/></button>
                        </div>
                    </header>

                    <div className="flex-1 overflow-auto p-4 space-y-4">
                        {livePosts.map(p => (
                            <div key={p.id} className="flex items-start space-x-3">
                                <img
                                    src={p.author.avatar || '/images/default-avatar.png'}
                                    alt="avatar"
                                    className="w-10 h-10 rounded-full"
                                />
                                <div>
                                    <div className="flex items-center space-x-2">
                                        <span className="font-bold">{p.author.name}</span>
                                        <span className="text-xs text-gray-500">{p.created_at}</span>
                                    </div>
                                    <p className="mt-1 text-gray-800">{p.body}</p>
                                </div>
                            </div>
                        ))}
                    </div>

                    {/* New Post Form */}
                    <form onSubmit={submit} className="p-4 border-t">
                        <div className="flex items-center space-x-3">
                            <textarea
                                value={data.body}
                                onChange={e => setData('body', e.target.value)}
                                placeholder="Type your programming query here..."
                                className="flex-1 rounded border-gray-300 p-2"
                                rows={3}
                            />
                            <button
                                type="submit"
                                disabled={processing}
                                className="bg-green-600 text-white px-4 py-2 rounded"
                            >
                                Send
                                <i className="fas fa-paper-plane"/>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </>
    );
}
