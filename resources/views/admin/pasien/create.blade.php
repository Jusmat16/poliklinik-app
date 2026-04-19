<x-layouts.app title="Tambah Pasien">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('pasien.index') }}" class="flex items-center justify-center w-9 h-9 rounded-lg 
                  bg-slate-100 hover:bg-slate-200 
                  text-slate-600 transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>

        <h2 class="text-2xl font-bold text-slate-800">
            Tambah Pasien
        </h2>
    </div>

    {{-- Card Form --}}
    <div class="card bg-base-100 shadow-md rounded-2xl border border-slate-200">
        <div class="card-body p-8">

            <form action="{{ route('pasien.store') }}" method="POST">
                @csrf

                {{-- Grid 2 Column --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                    {{-- Nama --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-slate-700 text-sm">
                                Nama Pasien <span class="text-red-500">*</span>
                            </span>
                        </label>
                        <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama pasien..."
                            class="input input-bordered border-2 rounded-lg p-2 w-full 
                                      focus:outline-none focus:ring-2 focus:ring-primary
                                      @error('nama') input-error @enderror" required>
                        @error('nama')
                        <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-slate-700 text-sm">
                                Email <span class="text-red-500">*</span>
                            </span>
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email..."
                            class="input input-bordered border-2 rounded-lg p-2 w-full 
                                      focus:ring-2 focus:ring-primary
                                      @error('email') input-error @enderror" required>
                        @error('email')
                        <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- No KTP --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-slate-700 text-sm">
                                No. KTP <span class="text-red-500">*</span>
                            </span>
                        </label>
                        <input type="number" name="no_ktp" value="{{ old('no_ktp') }}" placeholder="Masukkan No. KTP..."
                            class="input input-bordered border-2 rounded-lg p-2 w-full
                                      focus:ring-2 focus:ring-primary
                                      @error('no_ktp') input-error @enderror" required>
                        @error('no_ktp')
                        <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- No HP --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-slate-700 text-sm">
                                No. HP <span class="text-red-500">*</span>
                            </span>
                        </label>
                        <input type="number" name="no_hp" value="{{ old('no_hp') }}" placeholder="Masukkan No. HP..."
                            class="input input-bordered border-2 rounded-lg p-2 w-full
                                      focus:ring-2 focus:ring-primary
                                      @error('no_hp') input-error @enderror" required>
                        @error('no_hp')
                        <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                {{-- Alamat --}}
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-semibold text-slate-700 text-sm">
                            Alamat <span class="text-red-500">*</span>
                        </span>
                    </label>
                    <textarea name="alamat" rows="3" placeholder="Masukkan alamat..." class="textarea textarea-bordered border-2 rounded-lg p-2 w-full
                                     focus:ring-2 focus:ring-primary
                                     @error('alamat') textarea-error @enderror" required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                    <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-control mb-8">
                    <label class="label">
                        <span class="label-text font-semibold text-slate-700 text-sm">
                            Password <span class="text-red-500">*</span>
                        </span>
                    </label>
                    <input type="password" name="password" placeholder="Minimal 8 karakter..." class="input input-bordered border-2 rounded-lg p-2 w-full
                                  focus:ring-2 focus:ring-primary
                                  @error('password') input-error @enderror" required>
                    @error('password')
                    <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="flex items-center gap-3">
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5
                               bg-[#2d4499] hover:bg-[#2d4499]/90
                               text-white border-2 rounded-lg p-2 font-semibold text-sm transition">
                        <i class="fas fa-save text-sm"></i>
                        Simpan
                    </button>

                    <a href="{{ route('pasien.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5
                              bg-slate-100 hover:bg-slate-200
                              text-slate-600 rounded-xl font-semibold text-sm transition">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

</x-layouts.app>
