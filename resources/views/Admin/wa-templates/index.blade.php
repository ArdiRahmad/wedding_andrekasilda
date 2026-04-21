@extends('adminlte::page')

@section('title', 'WhatsApp Templates')

@section('content')
<div class="row pt-4">
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-header"><h3 class="card-title">Buat Template Baru</h3></div>
            <form action="{{ route('admin.wa-templates.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>Judul Template</label>
                        <input type="text" name="title" class="form-control" placeholder="Contoh: Undangan Formal" required>
                    </div>
                    <div class="form-group">
                        <label>Isi Pesan</label>
                        <textarea name="message" class="form-control" rows="6" placeholder="Halo {name}, kami mengundang Anda..." required></textarea>
                        <small class="text-muted">Gunakan placeholder: <code>{name}</code> dan <code>{url}</code></small>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="is_active" class="custom-control-input" id="isActive" value="1">
                        <label class="custom-control-label" for="isActive">Set sebagai template aktif</label>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-block">Simpan Template</button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card card-outline card-info">
            <div class="card-header"><h3 class="card-title">Daftar Template</h3></div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Template</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($templates as $item)
                        <tr>
                            <td width="15%">
                                @if($item->is_active)
                                    <span class="badge badge-success"><i class="fas fa-check-circle"></i> Digunakan</span>
                                @else
                                    <form action="{{ route('admin.wa-templates.set-active', $item->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-xs btn-outline-secondary">Gunakan</button>
                                    </form>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $item->title }}</strong><br>
                                <small>{{ Str::limit($item->message, 100) }}</small>
                            </td>
                            <td>
                                <form action="{{ route('admin.wa-templates.destroy', $item->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-xs" onclick="return confirm('Hapus?')"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop