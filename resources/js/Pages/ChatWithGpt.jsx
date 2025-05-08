import React, {useState} from 'react';
import axios from 'axios';

export default function ChatWithGpt() {
    const [msgs, setMsgs] = useState([]);
    const [text, setText] = useState('');

    const send = async () => {
        if (!text.trim()) return;
        const userMsg = {from: 'you', text};
        setMsgs(ms => [...ms, userMsg]);
        setText('');

        try {
            const {data} = await axios.post(route('chat.gpt'), {message: userMsg.text});
            setMsgs(ms => [...ms, {from: 'gpt', text: data.reply}]);
        } catch (e) {
            setMsgs(ms => [...ms, {from: 'gpt', text: '😵‍💫 Oops, something went wrong.'}]);
        }
    };

    return (
        <div className="border p-4 rounded shadow-lg max-w-md mx-auto bg-white">
            <div className="h-64 overflow-auto mb-4 space-y-2">
                {msgs.map((m, i) => (
                    <div key={i} className={m.from === 'you' ? 'text-right' : 'text-left'}>
            <span className={`inline-block p-2 rounded ${m.from === 'you' ? 'bg-green-100' : 'bg-gray-200'}`}>
              {m.text}
            </span>
                    </div>
                ))}
            </div>

            <div className="flex w-full">
                <input
                    value={text}
                    onChange={e => setText(e.target.value)}
                    onKeyDown={e => e.key === 'Enter' && send()}
                    placeholder="Ask ChatGPT…"
                    className="flex-1 min-w-0 border rounded-l px-3 py-2 focus:outline-none"
                />
                <button
                    onClick={send}
                    disabled={!text.trim()}
                    className="bg-green-600 text-white px-4 py-2 rounded-r"
                >
                    Send
                </button>
            </div>
        </div>
    );
}
