import React from 'react';
import {Head, useForm} from '@inertiajs/react';

export default function CreateThread() {
    const {data, setData, post, processing} = useForm({
        title: '',
        content: '',
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post('/threads');
    };

    return (
        <>
            <Head title="Create Thread"/>
            <div className="container mx-auto px-4 py-6">
                <h1 className="text-2xl font-bold mb-4">Create a New Thread</h1>
                <form onSubmit={handleSubmit} className="space-y-4">
                    <div>
                        <label className="block text-sm font-medium">Title</label>
                        <input
                            type="text"
                            value={data.title}
                            onChange={(e) => setData('title', e.target.value)}
                            className="form-control w-full"
                            required
                        />
                    </div>
                    <div>
                        <label className="block text-sm font-medium">Content</label>
                        <textarea
                            value={data.content}
                            onChange={(e) => setData('content', e.target.value)}
                            className="form-control w-full"
                            rows="5"
                            required
                        />
                    </div>
                    <button
                        type="submit"
                        disabled={processing}
                        className="bg-green-800 text-white px-4 py-2 rounded hover:bg-green-600"
                    >
                        Create Thread
                    </button>
                </form>
            </div>
        </>
    );
}
