<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('FAQ Category Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <a href="{{ route('admin.faq-categories.index') }}" class="text-indigo-600 hover:underline">
                            ← Back to Categories
                        </a>
                    </div>

                    <div class="mb-6">
                        <h1 class="text-3xl font-bold">{{ $faqCategory->name }}</h1>
                        @if($faqCategory->description)
                            <p class="text-gray-600 mt-2">{{ $faqCategory->description }}</p>
                        @endif
                    </div>

                    <div class="mb-4">
                        <h3 class="text-lg font-semibold mb-2">{{ __('FAQ Items') }}</h3>
                        @forelse($faqCategory->faqItems as $item)
                            <div class="mb-4 p-4 border border-gray-200 rounded">
                                <h4 class="font-semibold">{{ $item->question }}</h4>
                                <p class="text-gray-700 mt-2">{{ $item->answer }}</p>
                            </div>
                        @empty
                            <p class="text-gray-500 italic">{{ __('No items in this category.') }}</p>
                        @endforelse
                    </div>

                    <div class="mt-6 flex gap-4">
                        <a href="{{ route('admin.faq-categories.edit', $faqCategory) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            {{ __('Edit') }}
                        </a>
                        <form action="{{ route('admin.faq-categories.destroy', $faqCategory) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700" onclick="return confirm('Delete this category?')">
                                {{ __('Delete') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>










