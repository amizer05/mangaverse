@extends('layouts.app')

@section('title', 'Contact Message Details')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-purple-900 to-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-500/20 border border-green-500/50 rounded-lg text-green-400">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6">
            <a href="{{ route('admin.contacts.index') }}" class="text-purple-400 hover:text-purple-300 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Messages
            </a>
        </div>

        <div class="bg-gray-800/50 backdrop-blur rounded-xl p-6 border border-gray-700/50">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-white mb-2">{{ $contact->subject }}</h1>
                <p class="text-gray-400">Received: {{ $contact->created_at->format('F j, Y g:i A') }}</p>
            </div>

            <div class="space-y-6 mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-white mb-2">From</h3>
                    <p class="text-gray-300">{{ $contact->name }} &lt;{{ $contact->email }}&gt;</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-white mb-2">Message</h3>
                    <p class="text-gray-300 whitespace-pre-wrap leading-relaxed">{{ $contact->message }}</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-white mb-2">Status</h3>
                    <form method="POST" action="{{ route('admin.contacts.update-status', $contact) }}" class="inline">
                        @csrf
                        @method('PATCH')
                        <select name="status" onchange="this.form.submit()" 
                                class="bg-gray-900/50 border border-gray-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-purple-500 transition-colors">
                            <option value="new" {{ ($contact->status === 'new' || !$contact->is_read) ? 'selected' : '' }}>New</option>
                            <option value="read" {{ $contact->status === 'read' ? 'selected' : '' }}>Read</option>
                            <option value="answered" {{ $contact->status === 'answered' ? 'selected' : '' }}>Answered</option>
                        </select>
                    </form>
                </div>

                @if($contact->admin_reply)
                <div>
                    <h3 class="text-lg font-semibold text-white mb-2">Admin Reply</h3>
                    <div class="bg-green-500/10 border border-green-500/30 rounded-lg p-4">
                        <p class="text-gray-300 whitespace-pre-wrap leading-relaxed">{{ $contact->admin_reply }}</p>
                        @if($contact->replied_at)
                        <p class="text-sm text-gray-400 mt-3">
                            Replied by {{ $contact->replier->name ?? 'Admin' }} on {{ $contact->replied_at->format('F j, Y g:i A') }}
                        </p>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <!-- Reply Form -->
            @if(!$contact->admin_reply)
            <div class="mt-6 p-6 bg-gray-900/50 rounded-lg border border-gray-700">
                <h3 class="text-lg font-semibold text-white mb-4">Reply to Message</h3>
                <form method="POST" action="{{ route('admin.contacts.reply', $contact) }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-300 mb-2">Your Reply</label>
                        <textarea name="admin_reply" rows="5" required
                                  class="w-full bg-gray-900/50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-purple-500 transition-colors resize-none @error('admin_reply') border-red-500 @enderror"
                                  placeholder="Type your reply here..."></textarea>
                        @error('admin_reply')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500 text-white font-semibold rounded-lg transition-all">
                        Send Reply
                    </button>
                </form>
            </div>
            @endif

            <div class="mt-6 flex gap-4 pt-6 border-t border-gray-700">
                <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-500 text-white font-semibold rounded-lg transition-all" onclick="return confirm('Delete this message?')">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
