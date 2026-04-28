@extends('adminlte::page')

@section('title', 'WhatsApp Templates')

@section('content_header')
    <h1>Kelola Template WhatsApp</h1>
@stop

@section('content')

    {{-- Notifikasi Error & Success --}}
    <div class="pt-2">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="icon fas fa-check mr-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="icon fas fa-ban mr-2"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>

    <div class="row pt-2">
        {{-- Form Buat Template Baru --}}
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
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Simpan Template
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Daftar Template --}}
        <div class="col-md-8">
            <div class="card card-outline card-info">
                <div class="card-header"><h3 class="card-title">Daftar Template</h3></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="15%">Status</th>
                                    <th>Template</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($templates as $item)
                                <tr>
                                    <td>
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
                                        <small class="text-muted" style="white-space: pre-wrap;">{{ Str::limit($item->message, 150) }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            {{-- Tombol Edit (Memicu Modal Edit) --}}
                                            <button class="btn btn-info btn-xs edit-template" 
                                                    data-toggle="modal" 
                                                    data-target="#modalEdit"
                                                    data-id="{{ $item->id }}"
                                                    data-title="{{ $item->title }}"
                                                    data-message="{{ $item->message }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>

                                            {{-- Tombol Hapus (Memicu Modal Delete) --}}
                                            <button type="button" class="btn btn-danger btn-xs ml-1 delete-template" 
                                                    data-toggle="modal" 
                                                    data-target="#modalDelete" 
                                                    data-id="{{ $item->id }}">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">Belum ada template WhatsApp yang dibuat.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit Template --}}
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" id="form-edit-template" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Template</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close text-white">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Judul Template</label>
                            <input type="text" name="title" id="edit-title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Isi Pesan</label>
                            <textarea name="message" id="edit-message" class="form-control" rows="8" required></textarea>
                            <small class="text-muted">Gunakan placeholder: <code>{name}</code> dan <code>{url}</code></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Delete Template --}}
    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="form-delete-template" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDeleteLabel">Konfirmasi Hapus</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-0">Apakah Anda yakin ingin menghapus template ini?</p>
                        <small class="text-danger">Tindakan ini tidak dapat dibatalkan.</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash mr-1"></i> Ya, Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop

@push('js')
<script>
    $(document).ready(function() {
        // 1. Logika Mengisi Data ke Modal Edit
        $('.edit-template').on('click', function() {
            const id = $(this).data('id');
            const title = $(this).data('title');
            const message = $(this).data('message');
            
            // Set data ke dalam inputan modal
            $('#edit-title').val(title);
            $('#edit-message').val(message);
            
            // Set URL Action Form Edit
            const url = "{{ url('admin/wa-templates') }}/" + id;
            $('#form-edit-template').attr('action', url);
        });

        // 2. Logika Mengisi Data ke Modal Delete
        $('.delete-template').on('click', function() {
            const id = $(this).data('id');
            
            // Jika Anda menggunakan route manual sebelumnya, ubah URL ini menjadi:
            // const url = "{{ url('admin/wa-templates') }}/" + id + "/hapus";
            
            // Jika menggunakan resource standar Laravel:
            const url = "{{ url('admin/wa-templates') }}/" + id;
            
            // Set URL Action Form Delete
            $('#form-delete-template').attr('action', url);
        });
    });
</script>
@endpush