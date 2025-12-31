{{-- TEMPLATE ENGINE --}}
@extends('layout.sidebar')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <h5 class="card-title fw-bold mb-4">Edit Data Hewan</h5>
            <hr>
            {{-- PERBAIKAN: Action mengarah ke route update hewan --}}
            <form action="/hewan/{{$data->id_hewan}}" method="POST">
                @method('PUT')
                @csrf
                
                {{-- BARIS 1: Informasi Dasar Teks --}}
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="namaHewan" class="form-label fw-medium">Nama Hewan</label>
                        {{-- Menggunakan data lama ($data->...) sebagai value default --}}
                        <input type="text" class="form-control @error('namaHewan') is-invalid @enderror" id="namaHewan" name="namaHewan" value="{{ old('namaHewan', $data->nama_hewan) }}" placeholder="Contoh: Miko">
                        @error('namaHewan')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="rasHewan" class="form-label fw-medium">Jenis / Ras Hewan</label>
                        <input type="text" class="form-control @error('rasHewan') is-invalid @enderror" id="rasHewan" name="rasHewan" value="{{ old('rasHewan', $data->ras_hewan) }}" placeholder="Contoh: Kucing Persia">
                        @error('rasHewan')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                {{-- BARIS 2: Informasi Numerik --}}
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="tahunKelahiran" class="form-label fw-medium">Tahun Kelahiran</label>
                        <input type="number" min="1990" max="{{ date('Y') }}" class="form-control @error('tahunKelahiran') is-invalid @enderror" id="tahunKelahiran" name="tahunKelahiran" value="{{ old('tahunKelahiran', $data->tahun_kelahiran) }}" placeholder="YYYY (Contoh: 2021)">
                        @error('tahunKelahiran')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="beratHewan" class="form-label fw-medium">Berat Hewan (kg)</label>
                        <div class="input-group">
                            <input type="number" step="0.1" min="0" class="form-control @error('beratHewan') is-invalid @enderror" id="beratHewan" name="beratHewan" value="{{ old('beratHewan', $data->berat_hewan) }}" placeholder="Contoh: 4.5">
                            <span class="input-group-text">kg</span>
                        </div>
                        @error('beratHewan')
                            <div class="form-text text-danger mt-1">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                {{-- BARIS 3: Jenis Kelamin (Radio Button) --}}
                <div class="row mb-3">
                    <div class="col-md-8 col-lg-6">
                        <label class="form-label d-block fw-medium">Jenis Kelamin</label>
                        <div class="border rounded p-3 @error('jenisKelamin') border-danger @enderror bg-light bg-opacity-25">
                            <div class="form-check form-check-inline me-4">
                                <input class="form-check-input" type="radio" name="jenisKelamin" id="radioJantan" value="Jantan"
                                    {{-- Logika Checked: Cek old input dulu, jika tidak ada, cek data dari database --}}
                                    {{ old('jenisKelamin', $data->jenis_kelamin) == 'Jantan' ? 'checked' : '' }}>
                                <label class="form-check-label" for="radioJantan">
                                    <i class="fa-solid fa-mars text-primary me-1"></i> Jantan
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenisKelamin" id="radioBetina" value="Betina"
                                    {{ old('jenisKelamin', $data->jenis_kelamin) == 'Betina' ? 'checked' : '' }}>
                                <label class="form-check-label" for="radioBetina">
                                    <i class="fa-solid fa-venus text-danger me-1"></i> Betina
                                </label>
                            </div>
                        </div>
                        @error('jenisKelamin')
                            <div class="form-text text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- BARIS 4: Pemilik (Select2 AJAX dengan Data Terpilih) --}}
                <div class="mb-4">
                    <label for="select-pemilik-ajax" class="form-label fw-medium">Pilih Pemilik (Ketik untuk mengganti)</label>
                    <select class="form-select @error('pemilik_id') is-invalid @enderror" id="select-pemilik-ajax" name="pemilik_id">
                        {{-- 
                            LOGIKA UNTUK OPSI TERPILIH:
                            1. Prioritas Utama: Jika ada input 'old' (karena error validasi), gunakan itu.
                            2. Prioritas Kedua: Jika tidak ada 'old', gunakan data pemilik yang berelasi saat ini ($data->pemilik).
                        --}}
                        @if(old('pemilik_id'))
                            {{-- Kasus 1: Ada error validasi, muat ulang pilihan terakhir user --}}
                            @php $oldPemilik = \App\Models\Pemilik::find(old('pemilik_id')); @endphp
                            @if($oldPemilik)
                                <option value="{{ $oldPemilik->id_pemilik }}" selected>
                                    {{ $oldPemilik->nama_lengkap }} - {{ Str::limit($oldPemilik->alamat, 50) }}
                                </option>
                            @endif
                        @elseif($data->pemilik)
                            {{-- Kasus 2: Halaman baru dimuat, tampilkan pemilik saat ini --}}
                            {{-- Asumsi: di Controller edit() sudah melakukan Eager Loading: Hewan::with('pemilik')->find($id) --}}
                            <option value="{{ $data->pemilik->id_pemilik }}" selected>
                                {{ $data->pemilik->nama_lengkap }} - {{ Str::limit($data->pemilik->alamat, 50) }}
                            </option>
                        @endif
                        {{-- Jika tidak ada keduanya, select dibiarkan kosong untuk diisi oleh AJAX --}}
                    </select>
                    @error('pemilik_id')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                    <div class="form-text text-muted small">*Pemilik saat ini sudah terpilih. Ketik untuk mencari pemilik lain.</div>
                </div>
                
                {{-- Tombol Aksi --}}
                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary px-4">Batal</a>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">
                        <i class="fa-solid fa-save me-2"></i>Update Data
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

{{-- PENTING: Tambahkan script Select2 juga di form edit agar berfungsi --}}
@push('scripts')
<script>
$(document).ready(function() {
    $('#select-pemilik-ajax').select2({
        theme: 'bootstrap-5',
        placeholder: '-- Ketik Nama atau Alamat Pemilik --',
        allowClear: true,
        minimumInputLength: 1,
        ajax: {
            url: "{{ route('api.pemilik.search') }}",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return { q: params.term };
            },
            processResults: function (data) {
                return { results: data };
            },
            cache: true
        }
    });
});
</script>
@endpush