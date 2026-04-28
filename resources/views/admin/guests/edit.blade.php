@extends('adminlte::page')

@section('title', 'Edit Tamu')

@section('content_header')
    <h1>Edit Tamu: {{ $guest->name }}</h1>
@stop

@section('content')
    <div class="card card-info card-outline">
        {{-- Jika ada error validasi, tampilkan alert di atas agar ketahuan --}}
        @if ($errors->any())
            <div class="alert alert-danger m-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.guests.update', $guest->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Nama Tamu</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $guest->name) }}" required>
                    @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="whatsapp_number">Nomor WhatsApp</label>
                            <input type="text" name="whatsapp_number" class="form-control" value="{{ old('whatsapp_number', $guest->whatsapp_number) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pax">Jumlah Pax</label>
                            <input type="number" name="pax" class="form-control" value="{{ old('pax', $guest->pax) }}" min="1" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- 1. Kategori sekarang jadi input text --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="category">Kategori</label>
                            <input type="text" name="category" class="form-control" value="{{ old('category', $guest->category) }}" placeholder="Cth: Teman SD, VIP, dll">
                        </div>
                    </div>
                    
                    {{-- 2. Tag / Sesi --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tag">Tag (Sesi)</label>
                            <select name="tag" class="form-control">
                                <option value="" {{ old('tag', $guest->tag) == '' ? 'selected' : '' }}>-- Tidak Ada --</option>
                                <option value="mrn" {{ old('tag', $guest->tag) == 'mrn' ? 'selected' : '' }}>Sesi 1 (MRN)</option>
                                <option value="aft" {{ old('tag', $guest->tag) == 'aft' ? 'selected' : '' }}>Sesi 2 (AFT)</option>
                            </select>
                        </div>
                    </div>

                    {{-- 3. RSVP Status (Ini yang bikin gagal save kemarin!) --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="rsvp_status">Status Kehadiran</label>
                            <select name="rsvp_status" class="form-control" required>
                                <option value="pending" {{ old('rsvp_status', $guest->rsvp_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="hadir" {{ old('rsvp_status', $guest->rsvp_status) == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="tidak_hadir" {{ old('rsvp_status', $guest->rsvp_status) == 'tidak_hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                            </select>
                        </div>
                    </div>

                    {{-- 4. Sisi Mempelai --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Sisi Mempelai</label>
                            <div class="mt-2">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input class="custom-control-input" type="radio" id="side_groom" name="side" value="groom" {{ old('side', $guest->side) == 'groom' ? 'checked' : '' }} required>
                                    <label for="side_groom" class="custom-control-label font-weight-normal">Pria (Groom)</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input class="custom-control-input" type="radio" id="side_bride" name="side" value="bride" {{ old('side', $guest->side) == 'bride' ? 'checked' : '' }} required>
                                    <label for="side_bride" class="custom-control-label font-weight-normal">Wanita (Bride)</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-right">
                <a href="{{ route('admin.guests.index') }}" class="btn btn-default float-left">Batal</a>
                <button type="submit" class="btn btn-info px-4">
                    <i class="fas fa-save mr-1"></i> Update Tamu
                </button>
            </div>
        </form>
    </div>
@stop