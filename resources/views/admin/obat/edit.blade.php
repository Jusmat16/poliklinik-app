<x-layouts.app title="Edit Obat">


    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('obat.index') }}" class="flex items-center justify-center w-9 h-9 rounded-lg 
                  bg-slate-100 hover:bg-slate-200 
                  text-slate-600 transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>


        <h2 class="text-2xl font-bold text-slate-800">
            Edit Obat
        </h2>
    </div>


    {{-- Card --}}
    <div class="card bg-base-100 shadow-md rounded-2xl border border-slate-200">
        <div class="card-body p-8">


            <form action="{{ route('obat.update', $obat->id) }}" method="POST">
                @csrf
                @method('PUT')


                {{-- Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">


                    {{-- Nama Obat --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">
                            Nama Obat <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_obat" value="{{ old('nama_obat', $obat->nama_obat) }}"
                            placeholder="Masukkan nama obat..." class="w-full px-4 py-2 border-2 rounded-lg p-2
                                      focus:border-primary focus:outline-none
                                      @error('nama_obat') border-red-500 @enderror" required>
                        @error('nama_obat')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- Kemasan --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">
                            Kemasan
                        </label>
                        <input type="text" name="kemasan" value="{{ old('kemasan', $obat->kemasan) }}"
                            placeholder="Contoh: Strip, Botol, Tube..." class="w-full px-4 py-2 border-2 rounded-lg p-2
                                      focus:border-primary focus:outline-none
                                      @error('kemasan') border-red-500 @enderror">
                        @error('kemasan')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                </div>


                {{-- Harga --}}
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        Harga <span class="text-red-500">*</span>
                    </label>


                    <div class="flex items-center border-2 rounded-lg p-2 px-4 py-2
                                focus-within:border-primary">
                        <span class="text-slate-500 text-sm font-semibold mr-2">
                            Rp
                        </span>
                        <input type="number" name="harga" value="{{ old('harga', $obat->harga) }}" placeholder="0" min="0" step="1"
                            class="w-full focus:outline-none
                                      @error('harga') border-red-500 @enderror" required>
                    </div>


                    @error('harga')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Stok --}}
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        Stok <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="stok" value="{{ old('stok', $obat->stok) }}" placeholder="0" min="0" step="1"
                        class="w-full px-4 py-2 border-2 rounded-lg p-2
                                  focus:border-primary focus:outline-none
                                  @error('stok') border-red-500 @enderror" required>
                    @error('stok')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror

                    {{-- Status Indikator --}}
                    @php $currentStok = old('stok', $obat->stok); @endphp
                    @if ($currentStok == 0)
                        <div class="mt-2 inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-red-50 border border-red-300">
                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-red-500 text-white"><i class="fas fa-circle-xmark text-[10px]"></i></span>
                            <span class="text-xs font-semibold text-red-700">Stok habis - tidak bisa diresepkan ke pasien</span>
                        </div>
                    @elseif ($currentStok <= 10)
                        <div class="mt-2 inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-yellow-50 border border-yellow-300">
                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-yellow-400 text-yellow-900"><i class="fas fa-triangle-exclamation text-[10px]"></i></span>
                            <span class="text-xs font-semibold text-yellow-800">Stok menipis - pertimbangkan untuk restock</span>
                        </div>
                    @else
                        <div class="mt-2 inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-green-50 border border-green-300">
                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-green-500 text-white"><i class="fas fa-circle-check text-[10px]"></i></span>
                            <span class="text-xs font-semibold text-green-700">Stok aman</span>
                        </div>
                    @endif

                </div>


                {{-- Buttons --}}
                <div class="flex gap-3">
                    <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-[#2d4499] hover:bg-[#2d4499]/90 
                               text-white font-semibold text-sm transition">
                        <i class="fas fa-save mr-1"></i> Update
                    </button>


                    <a href="{{ route('obat.index') }}"
                        class="px-6 py-2.5 rounded-lg bg-slate-100 hover:bg-slate-200 
                               text-slate-600 font-semibold text-sm transition">
                        Batal
                    </a>
                </div>


            </form>


        </div>
    </div>


</x-layouts.app>
