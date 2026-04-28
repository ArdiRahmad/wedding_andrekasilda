@extends('adminlte::page')

@section('title', 'Tambah Tamu')

@section('content_header')
    <h1>Tambah Tamu Baru</h1>
@stop

@section('content')
    <div class="card card-primary card-outline">
        {{-- Alert Error Validasi Global --}}
        @if ($errors->any())
            <div class="alert alert-danger m-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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
                            <small class="text-muted">Gunakan awalan 62 (tanpa tanda +)</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pax">Jumlah Pax (Kapasitas)</label>
                            <input type="number" name="pax" class="form-control @error('pax') is-invalid @enderror" 
                                placeholder="Contoh: 2" value="{{ old('pax', 1) }}" min="1" required>
                            <small class="text-muted">Minimal 1 (tamu utama)</small>
                            @error('pax') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- 1. Kategori diubah jadi text input --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="category">Kategori</label>
                            <input type="text" name="category" class="form-control" placeholder="Cth: Teman SD, VIP, Rekan Kerja" value="{{ old('category') }}">
                        </div>
                    </div>
                    
                    {{-- 2. Tag (Sesi) --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tag">Tag (Sesi)</label>
                            <select name="tag" class="form-control @error('tag') is-invalid @enderror">
                                <option value="" {{ old('tag') == '' ? 'selected' : '' }}>-- Pilih Sesi --</option>
                                <option value="mrn" {{ old('tag') == 'mrn' ? 'selected' : '' }}>Sesi 1 (MRN)</option>
                                <option value="aft" {{ old('tag') == 'aft' ? 'selected' : '' }}>Sesi 2 (AFT)</option>
                            </select>
                            @error('tag') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                    {{-- 3. Sisi Mempelai --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Sisi Mempelai</label>
                            <div class="mt-2">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input class="custom-control-input" type="radio" id="side_groom" name="side" value="groom" {{ old('side', 'groom') == 'groom' ? 'checked' : '' }} required>
                                    <label for="side_groom" class="custom-control-label font-weight-normal">Pria (Groom)</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input class="custom-control-input" type="radio" id="side_bride" name="side" value="bride" {{ old('side') == 'bride' ? 'checked' : '' }} required>
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