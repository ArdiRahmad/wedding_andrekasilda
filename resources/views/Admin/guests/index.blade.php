@extends('adminlte::page')

@section('title', 'Daftar Tamu')

@section('content_header')
    @php $link = url('') @endphp
    @for($i = 1; $i <= count(Request::segments()); $i++)
        @if($i < count(Request::segments()) && $i > 0)
            @php $link .= "/" . Request::segment($i); @endphp
            <a href="{{ $link }}">{{ ucwords(str_replace('-',' ',Request::segment($i)))}}</a> >
        @else {{ucwords(str_replace('-',' ',Request::segment($i)))}}
        @endif
    @endfor
@stop

@section('content')
    <section class="content">
        <div class="table-header mt-3 mb-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div>
                    <a href="{{ route('admin.guests.create') }}" class="btn btn-info btn-flat">
                        <i class="fa fa-plus mr-1"></i> Tambah Tamu
                    </a>
                </div>

                <div class="btn-group">
                    <a href="{{ route('admin.guests.download-template') }}" class="btn btn-default btn-flat text-primary" title="Unduh format Excel">
                        <i class="fa fa-download mr-1"></i> Template
                    </a>
                    <button type="button" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modalImport">
                        <i class="fa fa-upload mr-1"></i> Import
                    </button>
                    <a href="{{ route('admin.guests.export') }}" class="btn btn-success btn-flat">
                        <i class="fa fa-file-excel mr-1"></i> Export
                    </a>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalImport" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <form action="{{ route('admin.guests.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Import Data Tamu</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>File Excel (.xlsx)</label>
                                <input type="file" name="file" class="form-control" required>
                                <small class="text-muted">Heading kolom: nama, whatsapp, kategori, sisi, pax</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Upload</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table dataTable">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Tamu</th>
                            <th>Code</th>
                            <th>WhatsApp</th>
                            <th>Sisi</th>
                            <th>Kategori</th>
                            <th>Status RSVP</th>
                            <th>Pax</th>
                            <th>WA Sent</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($guests != null)
                            @foreach($guests as $key => $value)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        {{ $value->name }} <br>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control form-control-navbar" value="{{ $value->unique_code }}" id="code-{{ $value->id }}" readonly>
                                            <div class="input-group-append">
                                                <button class="btn btn-default btn-sm" onclick="copyToClipboard('code-{{ $value->id }}')" title="Salin Kode">
                                                    <i class="fas fa-copy text-primary"></i>
                                                </button>
                                                <a href="{{ url('/guest/' . $value->unique_code) }}" target="_blank" class="btn btn-default btn-sm" title="Buka Link">
                                                    <i class="fas fa-external-link-alt text-info"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <small class="text-muted">Link: http://yourdomain.com/guest/{{ $value->unique_code }}</small>
                                    </td>
                                    <td>{{ $value->whatsapp_number ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $value->side == 'groom' ? 'badge-primary' : 'badge-danger' }}">
                                            {{ ucfirst($value->side) }}
                                        </span>
                                    </td>
                                    <td><span class="badge badge-info">{{ $value->category }}</span></td>
                                    <td>
                                        @if($value->rsvp_status == 'hadir')
                                            <span class="text-success">Hadir</span>
                                        @elseif($value->rsvp_status == 'tidak_hadir')
                                            <span class="text-danger">Tidak Hadir</span>
                                        @else
                                            <span class="text-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ $value->pax }}</td>
                                    <td class="text-center">
                                        {!! $value->is_wa_sent ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' !!}
                                    </td>
                                    <td>
                                        <div class="dropdown dropleft">
                                            <button class="btn btn-secondary btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-bars"></i>
                                            </button>
                                            <div class="dropdown-menu bg-success" aria-labelledby="dropdownMenuButton">
                                                <a href="{{ route('admin.guests.edit', $value->id) }}" class="btn dropdown-item text-dark btn-success btn-sm"><i class="fa fa-cog mr-2"></i>Edit</a>
                                                
                                                <button data-toggle="modal" data-target="#modalDelete" data-id="{{ $value->id }}" class="btn dropdown-item text-dark btn-success delete btn-sm"><i class="fa fa-trash mr-2"></i>Delete</button>
                                                
                                                <a href="https://wa.me/{{ $value->whatsapp_number }}?text=Halo%20{{ urlencode($value->name) }},%20kami%20mengundang%20Anda%20di:%20{{ url('/invitation/'.$value->unique_code) }}" target="_blank" class="btn dropdown-item text-dark btn-success btn-sm">
                                                    <i class="fab fa-whatsapp mr-2"></i>Kirim Undangan
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">Apakah anda yakin ingin menghapus tamu ini?</div>
                    <div class="modal-footer">
                        <form action="{{ route('admin.guests.destroy', ['^']) }}" class="form-delete" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                        </form>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('plugins.Datatables', true)

@push('js')
    <script>
        $(".dataTable").DataTable({
            "responsive": true,
            "autoWidth": false,
        });

        $(".table").on('click','.delete',function() {
            var act = $(".form-delete").attr('action');
            var split = act.split("/");
            // Logika replace ID ala kodingan Anda
            var link = act.replace(split[split.length-1], $(this).attr('data-id'));
            $(".form-delete").attr('action', link);
        });
    </script>
@endpush