@extends('adminlte::page')

@section('title', 'Daftar Tamu')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Daftar Tamu</h1>
        <div>
            @php $link = url('') @endphp
            @for($i = 1; $i <= count(Request::segments()); $i++)
                @if($i < count(Request::segments()) && $i > 0)
                    @php $link .= "/" . Request::segment($i); @endphp
                    <a href="{{ $link }}">{{ ucwords(str_replace('-',' ',Request::segment($i)))}}</a> >
                @else {{ucwords(str_replace('-',' ',Request::segment($i)))}}
                @endif
            @endfor
        </div>
    </div>
@stop

@section('content')
    <section class="content">
        <div class="row mt-3 mb-3">
            <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
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

        {{-- Notifikasi --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="icon fas fa-check"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover dataTable">
                                <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama Tamu</th>
                                    <th width="20%">Link Undangan</th>
                                    <th>WhatsApp</th>
                                    <th>Sisi</th>
                                    <th>Kategori</th>
                                    <th>Tag</th>
                                    <th>Status</th>
                                    <th>Pax</th>
                                    <th class="text-center">WA</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($guests != null)
                                    @foreach($guests as $key => $value)
                                        @php
                                            // 1. Format Nomor WhatsApp
                                            $phone = $value->whatsapp_number;
                                            if (substr($phone, 0, 1) === '0') {
                                                $phone = '62' . substr($phone, 1);
                                            } elseif (substr($phone, 0, 3) === '+62') {
                                                $phone = '62' . substr($phone, 3);
                                            }

                                            // 2. Generate URL Lengkap
                                            $guestUrl = url('/' . $value->unique_code);

                                            // 3. Logika Pesan WhatsApp
                                            $pesanBawaan = "Halo *{name}*, kami mengundang Anda ke acara pernikahan kami. Silakan buka tautan berikut untuk info lengkap: {url}";
                                            $templateContent = !empty($rawMessage) ? $rawMessage : $pesanBawaan;
                                            
                                            $finalMessage = str_replace(
                                                ['{name}', '{url}'], 
                                                [$value->name, $guestUrl], 
                                                $templateContent
                                            );

                                            $waUrl = "https://wa.me/" . $phone . "?text=" . urlencode($finalMessage);
                                        @endphp
                                        <tr id="row-{{ $value->id }}">
                                            <td>{{ $key+1 }}</td>
                                            <td><strong>{{ $value->name }}</strong></td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control" value="{{ $guestUrl }}" id="url-{{ $value->id }}" readonly>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-default btn-copy" data-target="url-{{ $value->id }}" title="Salin Link">
                                                            <i class="fas fa-copy text-primary"></i>
                                                        </button>
                                                        <a href="{{ $guestUrl }}" target="_blank" class="btn btn-default" title="Buka Link">
                                                            <i class="fas fa-external-link-alt text-info"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><code>{{ $phone ?? '-' }}</code></td>
                                            <td>
                                                <span class="badge {{ $value->side == 'groom' ? 'badge-primary' : 'badge-danger' }}">
                                                    {{ ucfirst($value->side) }}
                                                </span>
                                            </td>
                                            <td><span class="badge badge-info">{{ $value->category }}</span></td>
                                            
                                            <td>
                                                @if($value->tag == 'aft')
                                                    <span class="badge badge-dark">AFT</span>
                                                @elseif($value->tag == 'mrn')
                                                    <span class="badge badge-warning">MRN</span>
                                                @else
                                                    <span class="badge badge-light border">{{ $value->tag ?? '-' }}</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if($value->rsvp_status == 'hadir')
                                                    <span class="badge badge-success">Hadir</span>
                                                @elseif($value->rsvp_status == 'tidak_hadir')
                                                    <span class="badge badge-danger">Tidak Hadir</span>
                                                @else
                                                    <span class="badge badge-warning">Pending</span>
                                                @endif
                                            </td>
                                            <td>{{ $value->pax }} Orang</td>
                                            <td class="text-center">
                                                {!! $value->is_wa_sent ? '<i class="fa fa-check text-success" title="Sudah dikirim"></i>' : '<i class="fa fa-times text-danger" title="Belum dikirim"></i>' !!}
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                                                        <i class="fas fa-cog"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="{{ route('admin.guests.edit', $value->id) }}" class="dropdown-item">
                                                            <i class="fa fa-edit mr-2 text-primary"></i> Edit
                                                        </a>
                                                        <a href="{{ $waUrl }}" target="_blank" class="dropdown-item">
                                                            <i class="fab fa-whatsapp mr-2 text-success"></i> Kirim WA
                                                        </a>
                                                        <div class="dropdown-divider"></div>
                                                        {{-- Tombol Delete menggunakan class btn-delete untuk ditangkap JS --}}
                                                        <button type="button" class="dropdown-item text-danger btn-delete" data-id="{{ $value->id }}">
                                                            <i class="fa fa-trash mr-2"></i> Hapus
                                                        </button>
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
            </div>
        </div>
    </section>

    {{-- Modal Import --}}
    <div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="modalImportLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalImportLabel">Import Data Tamu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.guests.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="file">Pilih File Excel (.xlsx, .xls)</label>
                            <input type="file" name="file" id="file" class="form-control" required accept=".xlsx, .xls, .csv">
                            <small class="text-muted">Pastikan format kolom sesuai dengan template Excel yang baru saja Anda unduh.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-flat">Import Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Delete --}}
    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDeleteLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-delete-action" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p class="mb-0">Apakah Anda yakin ingin menghapus data tamu ini?</p>
                        <small class="text-danger">Tindakan ini tidak dapat dibatalkan.</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger btn-flat">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@push('js')
    <script>
        $(document).ready(function() {
            // Inisiasi DataTable
            $(".dataTable").DataTable({
                "responsive": true,
                "autoWidth": false,
                "order": [[0, "asc"]]
            });

            // Action: Copy Link (Delegasi event agar aman di pagination)
            $(document).on('click', '.btn-copy', function(e) {
                e.preventDefault();
                let targetId = $(this).data('target');
                let copyText = document.getElementById(targetId);
                
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                navigator.clipboard.writeText(copyText.value).then(() => {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    Toast.fire({
                        icon: 'success',
                        title: 'Link berhasil disalin!'
                    });
                });
            });

            // Action: Tombol Delete (Delegasi event agar aman di pagination)
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                let url = "{{ url('admin/guests') }}/" + id;
                
                // Set action form dan tampilkan modal
                $('#form-delete-action').attr('action', url);
                $('#modalDelete').modal('show');
            });
        });
    </script>
@endpush