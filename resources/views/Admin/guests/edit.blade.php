@extends('adminlte::page')

@section('title', 'Edit Tamu')

@section('content_header')
    <h1>Edit Data Tamu</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-warning card-outline">
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
                                    <small class="text-muted">Gunakan format 62 (contoh: 628123456789)</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pax">Jumlah Pax (Kapasitas)</label>
                                    <input type="number" name="pax" class="form-control @error('pax') is-invalid @enderror" value="{{ old('pax', $guest->pax) }}" min="1">
                                    @error('pax') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category">Kategori</label>
                                    <select name="category" class="form-control">
                                        <option value="Teman" {{ old('category', $guest->category) == 'Teman' ? 'selected' : '' }}>Teman</option>
                                        <option value="Keluarga" {{ old('category', $guest->category) == 'Keluarga' ? 'selected' : '' }}>Keluarga</option>
                                        <option value="VIP" {{ old('category', $guest->category) == 'VIP' ? 'selected' : '' }}>VIP</option>
                                        <option value="Rekan Kerja" {{ old('category', $guest->category) == 'Rekan Kerja' ? 'selected' : '' }}>Rekan Kerja</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Sisi Mempelai</label>
                                    <div class="mt-2">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input class="custom-control-input" type="radio" id="side_groom" name="side" value="groom" {{ old('side', $guest->side) == 'groom' ? 'checked' : '' }}>
                                            <label for="side_groom" class="custom-control-label font-weight-normal">Pria (Groom)</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input class="custom-control-input" type="radio" id="side_bride" name="side" value="bride" {{ old('side', $guest->side) == 'bride' ? 'checked' : '' }}>
                                            <label for="side_bride" class="custom-control-label font-weight-normal">Wanita (Bride)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label>Status RSVP (Update Manual)</label>
                            <select name="rsvp_status" class="form-control">
                                <option value="pending" {{ old('rsvp_status', $guest->rsvp_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="hadir" {{ old('rsvp_status', $guest->rsvp_status) == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="tidak_hadir" {{ old('rsvp_status', $guest->rsvp_status) == 'tidak_hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                            </select>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('admin.guests.index') }}" class="btn btn-default float-left">Batal</a>
                        <button type="submit" class="btn btn-warning px-4">
                            <i class="fas fa-save mr-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-link mr-1"></i> Info Undangan</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Unique Code</label>
                        <div class="input-group">
                            <input type="text" class="form-control" value="{{ $guest->unique_code }}" readonly id="uniqueCodeInput">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="copyCode()">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <p class="text-sm text-muted">
                        Link Undangan:<br>
                        <a href="{{ url('/undangan/' . $guest->unique_code) }}" target="_blank" class="text-primary">
                            {{ url('/undangan/' . $guest->unique_code) }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        function copyCode() {
            var copyText = document.getElementById("uniqueCodeInput");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");
            
            Swal.fire({
                icon: 'success',
                title: 'Copied!',
                text: 'Kode unik berhasil disalin',
                timer: 1500,
                showConfirmButton: false
            });
        }
    </script>
@stop