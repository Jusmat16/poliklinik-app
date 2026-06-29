<x-layouts.app title="Periksa Pasien">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('periksa-pasien.index') }}" class="inline-flex items-center justify-center w-9 h-9 
                  rounded-lg bg-slate-100 text-slate-500 
                  hover:bg-slate-200 transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <h2 class="text-2xl font-bold text-slate-800">
            Periksa Pasien
        </h2>
    </div>

    {{-- Alert Error Stok Habis (dari controller) --}}
    @error('obat')
    <div class="alert alert-danger mb-4 rounded-xl shadow-sm" role="alert">
        <i class="fas fa-circle-xmark"></i>
        <span>{{ $message }}</span>
    </div>
    @enderror

    {{-- Card --}}
    <div class="card bg-base-100 shadow-sm rounded-2xl border border-slate-200">
        <div class="card-body p-8">

            <form action="{{ route('periksa-pasien.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_daftar_poli" value="{{ $id }}">

                {{-- Pilih Obat --}}
                <div class="form-control mb-5">
                    <label class="label pb-1">
                        <span class="text-sm font-semibold text-gray-700">Pilih Obat <span class="text-red-500">*</span></span>
                    </label>
                    <select id="select-obat" class="select select-bordered w-full rounded-lg border-2 px-4">
                        <option value="">-- Pilih Obat --</option>
                        @foreach ($obats as $obat)
                            @php
                                if ($obat->stok == 0) {
                                    $stokColor = '#9ca3af';        // gray-400 (disabled)
                                    $stokLabel = '⚠ HABIS — tidak bisa dipilih';
                                } elseif ($obat->stok <= 10) {
                                    $stokColor = '#ca8a04';        // yellow-600
                                    $stokLabel = '⚡ Stok: ' . $obat->stok;
                                } else {
                                    $stokColor = '#16a34a';        // green-600
                                    $stokLabel = '✓ Stok: ' . $obat->stok;
                                }
                            @endphp
                            <option value="{{ $obat->id }}"
                                data-nama="{{ $obat->nama_obat }}"
                                data-harga="{{ $obat->harga }}"
                                data-stok="{{ $obat->stok }}"
                                @if ($obat->stok == 0) disabled @endif
                                style="color: {{ $stokColor }}; {{ $obat->stok == 0 ? 'text-decoration: line-through;' : '' }}">
                                {{ $obat->nama_obat }} - Rp{{ number_format($obat->harga) }}
                                &nbsp;{{ $stokLabel }}
                            </option>
                        @endforeach
                    </select>
                    @if ($obats->where('stok', 0)->count() > 0)
                    <p class="text-xs text-slate-500 mt-2">
                        <i class="fas fa-info-circle"></i>
                        {{ $obats->where('stok', 0)->count() }} obat berstatus habis (tidak bisa dipilih).
                        Hubungi admin untuk restock.
                    </p>
                    @endif
                </div>

                {{-- Obat Terpilih --}}
                <div class="form-control mb-5">
                    <label class="label pb-1 ">
                        <span class="text-sm font-semibold text-gray-700">Obat Terpilih</span>
                    </label>

                    <ul id="obat-terpilih" class="flex flex-col gap-2 mb-2 min-h-[48px]"></ul>

                    <input type="hidden" name="biaya_periksa" id="biaya_periksa" value="0">
                    <input type="hidden" name="obat_json" id="obat_json">
                </div>

                {{-- Total Harga --}}
                <div class="form-control mb-5">
                    <label class="label pb-1">
                        <span class="text-sm font-semibold text-gray-700">Total Harga</span>
                    </label>
                    <div class="input input-bordered w-full rounded-lg flex items-center bg-slate-50 text-slate-700 font-bold" id="total-harga">
                        Rp 0
                    </div>
                </div>

                {{-- Catatan --}}
                <div class="form-control mb-8">
                    <label class="label pb-1">
                        <span class="text-sm font-semibold text-gray-700">Catatan <span class="text-slate-400 font-normal">(Opsional)</span></span>
                    </label>
                    <textarea name="catatan" id="catatan" rows="4"
                        placeholder="Masukkan catatan..."
                        class="textarea textarea-bordered w-full border-2 px-4 py-2 rounded-lg resize-none">{{ old('catatan') }}</textarea>
                </div>

                {{-- Buttons --}}
                <div class="flex gap-3">
                    <button type="submit"
                        class="btn bg-[#2d4499] hover:bg-[#1e2d6b] text-white border-none rounded-lg px-6">
                        <i class="fas fa-save"></i>
                        Simpan
                    </button>
                    <a href="{{ route('periksa-pasien.index') }}"
                        class="btn btn-ghost bg-slate-100 hover:bg-slate-200 text-slate-500 rounded-lg px-6">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

    <script>
        const selectObat = document.getElementById('select-obat');
        const listObat = document.getElementById('obat-terpilih');
        const inputBiaya = document.getElementById('biaya_periksa');
        const inputObatJson = document.getElementById('obat_json');
        const totalHargaEl = document.getElementById('total-harga');

        let daftarObat = [];

        selectObat.addEventListener('change', () => {
            const selectedOption = selectObat.options[selectObat.selectedIndex];
            const id = selectedOption.value;
            const nama = selectedOption.dataset.nama;
            const harga = parseInt(selectedOption.dataset.harga || 0);
            const stok = parseInt(selectedOption.dataset.stok || 0);

            // Abaikan: placeholder, duplikat, atau stok habis (defensive)
            if (!id || daftarObat.some(o => o.id == id)) return;
            if (stok < 1) return;

            daftarObat.push({ id, nama, harga });
            renderObat();
            selectObat.selectedIndex = 0;
        });

        function renderObat() {
            listObat.innerHTML = '';
            let total = 0;

            daftarObat.forEach((obat, index) => {
                total += obat.harga;

                const item = document.createElement('li');
                item.className = 'flex items-center justify-between px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700';
                item.innerHTML = `
                    <span>${obat.nama} — <span class="font-semibold">Rp ${obat.harga.toLocaleString()}</span></span>
                    <button type="button"
                        onclick="hapusObat(${index})"
                        class="btn btn-sm bg-red-500 hover:bg-red-600 text-white border-none rounded-lg px-3">
                        <i class="fas fa-trash"></i>
                    </button>
                `;
                listObat.appendChild(item);
            });

            inputBiaya.value = total;
            totalHargaEl.textContent = `Rp ${total.toLocaleString()}`;
            inputObatJson.value = JSON.stringify(daftarObat.map(o => o.id));
        }

        function hapusObat(index) {
            daftarObat.splice(index, 1);
            renderObat();
        }
    </script>

</x-layouts.app>