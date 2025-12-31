{{-- TEMPLATE ENGINE --}}
@extends('layout.sidebar')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <h5 class="card-title fw-bold mb-4">Tambah Data Hewan Baru</h5>
            <hr>
            <form action="/hewan" method="POST">
                @csrf
                
                {{-- BARIS 1: Informasi Dasar Teks --}}
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="namaHewan" class="form-label fw-medium">Nama Hewan</label>
                        <input type="text" class="form-control @error('namaHewan') is-invalid @enderror" id="namaHewan" name="namaHewan" value="{{old('namaHewan')}}" placeholder="Contoh: Miko">
                        @error('namaHewan')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="rasHewan" class="form-label fw-medium">Jenis / Ras Hewan</label>
                        <input type="text" class="form-control @error('rasHewan') is-invalid @enderror" id="rasHewan" name="rasHewan" value="{{old('rasHewan')}}" placeholder="Contoh: Kucing Persia">
                        @error('rasHewan')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                {{-- BARIS 2: Informasi Numerik --}}
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="tahunKelahiran" class="form-label fw-medium">Tahun Kelahiran</label>
                        <input type="number" min="1990" max="{{ date('Y') }}" class="form-control @error('tahunKelahiran') is-invalid @enderror" id="tahunKelahiran" name="tahunKelahiran" value="{{old('tahunKelahiran')}}" placeholder="YYYY (Contoh: 2021)">
                        @error('tahunKelahiran')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="beratHewan" class="form-label fw-medium">Berat Hewan (kg)</label>
                        <div class="input-group">
                            <input type="number" step="0.1" min="0" class="form-control @error('beratHewan') is-invalid @enderror" id="beratHewan" name="beratHewan" value="{{old('beratHewan')}}" placeholder="Contoh: 4.5">
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
                                    {{ old('jenisKelamin') == 'Jantan' ? 'checked' : '' }}>
                                <label class="form-check-label" for="radioJantan">
                                    <i class="fa-solid fa-mars text-primary me-1"></i> Jantan
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenisKelamin" id="radioBetina" value="Betina"
                                    {{ old('jenisKelamin') == 'Betina' ? 'checked' : '' }}>
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

                {{-- BARIS 4: Pemilik (Select2 AJAX) --}}
                <div class="mb-4">
                    <label for="select-pemilik-ajax" class="form-label fw-medium">Pilih Pemilik (Ketik untuk mencari)</label>
                    <select class="form-select @error('pemilik_id') is-invalid @enderror" id="select-pemilik-ajax" name="pemilik_id">
                        @if(old('pemilik_id'))
                            @php
                                $oldPemilik = \App\Models\Pemilik::find(old('pemilik_id'));
                            @endphp
                            @if($oldPemilik)
                                 <option value="{{ $oldPemilik->id_pemilik }}" selected>
                                    {{ $oldPemilik->nama_lengkap }} - {{ Str::limit($oldPemilik->alamat, 50) }}
                                </option>
                            @endif
                        @endif
                    </select>
                    @error('pemilik_id')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                    <div class="form-text text-muted small">*Ketik minimal 1 huruf untuk mencari nama atau alamat pemilik.</div>
                </div>
                
                {{-- Tombol Aksi --}}
                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary px-4">Batal</a>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">
                        <i class="fa-solid fa-save me-2"></i>Simpan Data
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

{{-- PENTING: @push DITANGKAP OLEH @stack DI LAYOUT UTAMA --}}
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