@extends('adminlte::page')

@section('title', 'Broadcast Undangan')

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
        <div class="row mt-3">
            <div class="col-12">
                <div class="card card-outline card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fab fa-whatsapp mr-2"></i> Antrean Broadcast WhatsApp</h3>
                        <div class="card-tools">
                            <span class="badge badge-info">{{ $guests->count() }} Tamu Tersisa</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover dataTable">
                                <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Tamu</th>
                                    <th>WhatsApp</th>
                                    <th>Kategori</th>
                                    <th>Preview Pesan</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($guests as $key => $value)
                                        @php
                                            // Generate Pesan Dinamis dari Template
                                            $finalMessage = str_replace(
                                                ['{name}', '{url}'], 
                                                [$value->name, url('/guest/' . $value->unique_code)], 
                                                $rawMessage
                                            );
                                            $waUrl = "https://wa.me/" . $value->whatsapp_number . "?text=" . urlencode($finalMessage);
                                        @endphp
                                        <tr id="row-{{ $value->id }}">
                                            <td>{{ $key+1 }}</td>
                                            <td>
                                                <strong>{{ $value->name }}</strong><br>
                                                <small class="text-muted">{{ ucfirst($value->side) }}</small>
                                            </td>
                                            <td><code>{{ $value->whatsapp_number }}</code></td>
                                            <td><span class="badge badge-secondary">{{ $value->category }}</span></td>
                                            <td>
                                                <small class="text-muted d-block" style="max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                    {{ $finalMessage }}
                                                </small>
                                            </td>
                                            <td>
                                                <a href="{{ $waUrl }}" 
                                                   target="_blank" 
                                                   class="btn btn-success btn-sm btn-block btn-broadcast" 
                                                   data-id="{{ $value->id }}">
                                                    <i class="fab fa-whatsapp"></i> Kirim
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@push('js')
    <script>
        $(document).ready(function() {
            $(".dataTable").DataTable({
                "responsive": true,
                "autoWidth": false,
            });

            $(document).on('click', '.btn-broadcast', function() {
                let id = $(this).data('id');
                let row = $(`#row-${id}`);

                // Mark as sent via AJAX
                $.ajax({
                    url: `{{ url('admin/guests') }}/${id}/mark-sent`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Animasi hapus baris setelah kirim
                        row.addClass('bg-light').fadeOut(800, function() {
                            $(this).remove();
                        });

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });

                        Toast.fire({
                            icon: 'success',
                            title: 'Status diperbarui: Terkirim'
                        });
                    }
                });
            });
        });
    </script>
@endpush