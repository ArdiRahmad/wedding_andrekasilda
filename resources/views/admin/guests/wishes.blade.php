@extends('adminlte::page')

@section('title', 'Moderasi Ucapan')

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
        <div class="card card-outline card-info mt-3">
            <div class="card-header">
                <h3 class="card-title">Daftar Ucapan Tamu (Wishes)</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table dataTable">
                        <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Tamu</th>
                            <th>Info</th>
                            <th>Pesan / Ucapan</th>
                            <th width="10%" class="text-center">Tampilkan?</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($wishes as $key => $value)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        <strong>{{ $value->name }}</strong><br>
                                        <code>{{ $value->unique_code }}</code>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ $value->category }}</span><br>
                                        <small class="text-{{ $value->side == 'groom' ? 'primary' : 'danger' }}">
                                            Sisi: {{ ucfirst($value->side) }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="p-2 border rounded bg-light" style="font-style: italic;">
                                            "{{ $value->message }}"
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                            <input type="checkbox" 
                                                   class="custom-control-input toggle-wishes" 
                                                   id="switch-{{ $value->id }}" 
                                                   data-id="{{ $value->id }}"
                                                   {{ $value->is_wishes ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="switch-{{ $value->id }}"></label>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@stop

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@push('js')
    <script>
        $(".dataTable").DataTable();

        $(document).on('change', '.toggle-wishes', function() {
            let id = $(this).data('id');
            let checkbox = $(this);
            
            $.ajax({
                url: `{{ url('admin/guests') }}/${id}/toggle-wishes`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000
                    });

                    Toast.fire({
                        icon: 'success',
                        title: response.new_status ? 'Pesan ditampilkan!' : 'Pesan disembunyikan!'
                    });
                },
                error: function() {
                    checkbox.prop('checked', !checkbox.prop('checked'));
                    alert('Gagal mengubah status.');
                }
            });
        });
    </script>
@endpush