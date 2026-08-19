<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-extrabold text-green-700 tracking-tight">Pilih Bahasa Daerah</h1>
            <p class="mt-3 text-lg text-gray-600">Pilih bahasa daerah yang ingin Anda pelajari hari ini</p>
        </div>

        @if($languages->isEmpty())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl p-6 text-center text-gray-500">
                Belum ada bahasa daerah yang tersedia saat ini.
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 gap-6 px-4 sm:px-0">
                @foreach($languages as $language)
                    <div 
                        wire:click="selectLanguage('{{ $language->id }}')"
                        class="bg-white overflow-hidden shadow-sm rounded-2xl cursor-pointer transition-all duration-300 transform hover:-translate-y-1 hover:shadow-md border-2 {{ $selectedId === $language->id ? 'border-green-500 bg-green-50' : 'border-transparent hover:border-green-300' }}"
                    >
                        <div class="p-6 text-center flex flex-col items-center justify-center h-full">
                            <div class="w-16 h-16 rounded-full {{ $selectedId === $language->id ? 'bg-green-500 text-white' : 'bg-green-100 text-green-600' }} flex items-center justify-center mb-4 transition-colors">
                                <span class="text-2xl font-bold">{{ substr($language->name, 0, 1) }}</span>
                            </div>
                            <h3 class="text-xl font-bold {{ $selectedId === $language->id ? 'text-green-700' : 'text-gray-800' }}">
                                {{ $language->name }}
                            </h3>
                            @if($selectedId === $language->id)
                                <span class="mt-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Sedang Dipilih
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
