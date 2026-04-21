@extends('adminlte::page')

@section('title', 'Tambah Tamu')

@section('content_header')
    <h1>Tambah Tamu Baru</h1>
@stop

@section('content')
    <div class="card card-primary card-outline">
        <form action="{{ route('admin.guests.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Nama Tamu</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Contoh: Bpk. Budi & Kel" value="{{ old('name') }}" required>
                    @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="whatsapp_number">Nomor WhatsApp</label>
                            <input type="text" name="whatsapp_number" class="form-control" placeholder="Contoh: 628123456789" value="{{ old('whatsapp_number') }}">
                            <small class="text-muted">Gunakan format 62 (tanpa tanda +)</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pax">Jumlah Pax (Kapasitas)</label>
                        {{-- Ubah min menjadi 1 dan default value menjadi 1 --}}
                        <input type="number" name="pax" class="form-control @error('pax') is-invalid @enderror" 
                            placeholder="Contoh: 2" value="{{ old('pax', 1) }}" min="1">
                        <small class="text-muted">Minimal 1 (tamu utama)</small>
                        @error('pax') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category">Kategori</label>
                            <select name="category" class="form-control select2">
                                <option value="Teman" {{ old('category') == 'Teman' ? 'selected' : '' }}>Teman</option>
                                <option value="Keluarga" {{ old('category') == 'Keluarga' ? 'selected' : '' }}>Keluarga</option>
                                <option value="VIP" {{ old('category') == 'VIP' ? 'selected' : '' }}>VIP</option>
                                <option value="Rekan Kerja" {{ old('category') == 'Rekan Kerja' ? 'selected' : '' }}>Rekan Kerja</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Sisi Mempelai</label>
                            <div class="mt-2">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input class="custom-control-input" type="radio" id="side_groom" name="side" value="groom" {{ old('side', 'groom') == 'groom' ? 'checked' : '' }}>
                                    <label for="side_groom" class="custom-control-label font-weight-normal">Pria (Groom)</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input class="custom-control-input" type="radio" id="side_bride" name="side" value="bride" {{ old('side') == 'bride' ? 'checked' : '' }}>
                                    <label for="side_bride" class="custom-control-label font-weight-normal">Wanita (Bride)</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-right">
                <a href="{{ route('admin.guests.index') }}" class="btn btn-default float-left">Batal</a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save mr-1"></i> Simpan Tamu
                </button>
            </div>
        </form>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Jika Anda menggunakan Select2 (opsional)
            $('.select2').select2();
        });
    </script>
@stop