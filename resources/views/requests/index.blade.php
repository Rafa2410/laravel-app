@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex mb-2">
            <div class="col-lg-10">
                <h2>{{ __('Requests') }}</h2>
            </div>
            <div class="col-lg-2">
                @can('request-create')
                <a class="btn btn-outline-primary" href="{{ route('requests.create') }}">{{ __('Create New Request') }}</a>
                @endcan
            </div>
        </div>
    </div>

    <div class="alert alert-success d-none" id="delete-alert">
        <p>{{ __('Request deleted successfully') }}</p>
    </div>

    <input type="text" class="d-none" value="{{ csrf_token() }}" id="token">

    <table class="table table-hover">
        <thead>
            <tr>
                <th>{{ __('Company') }}</th>
                <th>{{ __('Request Num') }}</th>
                <th>{{ __('Requestor') }}</th>
                <th>{{ __('Room') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Date') }}</th>
                <th>{{ __('Services') }}</th>
                <th>{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
            @if (count($data) === 0)
                <tr class="text-center">
                    <td colspan="8">{{ __('Not any request yet') }}</td>
                </tr>
            @else
                @foreach ($data as $key => $req)
                    <tr class="{{ $req->getStatus($req->status_id)->name !== 'Draft' && $req->getStatus($req->status_id)->name !== 'Pending' ? 'managed' : '' }}">
                        <td>{{ $req->getCompany($req->company_id)->name }}</td>
                        <td>{{ $req->request_num }}</td>
                        <td>{{ $req->getUser($req->user_id)->name }}</td>
                        <td>{{ $req->getRoom($req->room_id)->name }}</td>
                        <td>{{ __($req->getStatus($req->status_id)->name) }}</td>
                        <td>{{ $req->start_date }}</td>
                        <td class="truncate">{{ $req->getServices($req->id) }}</td>
                        <td style="max-width: 200px;">
                            @can('request-edit')
                                @if ($req->getStatus($req->status_id)->name === 'Draft' && !@Auth::user()->hasRole('Approver'))
                                    <a class="btn btn-outline-primary" href="{{ route('requests.edit',$req->id) }}">{{ __('Edit') }}</a>
                                @elseif ($req->getStatus($req->status_id)->name === 'Pending' && @Auth::user()->hasRole('Approver'))
                                    <a class="btn btn-outline-primary" href="{{ route('manage-request',$req->id) }}">{{ __('Manage') }}</a>
                                @endif
                            @endcan
                            @can('request-delete')
                                <a class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteRequestModal_{{$req->id}}"
                                    data-action="{{ route('requests.destroy', $req->id) }}">{{ __('Delete') }}</a>
                            @endcan
                        </td>
                    </tr>
                    @can('request-delete')
                        <!-- Delete Request Modal -->
                        <div class="modal fade" id="deleteRequestModal_{{$req->id}}" data-backdrop="static" tabindex="-1" role="dialog"
                        aria-labelledby="deleteRequestModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteRequestModalLabel">{{ __('This action is irreversible.') }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h5 class="text-center">{{ __('Are you sure you want to delete the request') }}
                                            {{ $req->request_num }} {{ __('from') }} {{ $req->getUser($req->user_id)->name }}?</h5>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancel_{{$req->id}}">{{ __('Cancel') }}</button>
                                        <button type="button" onclick="deleteRequest( {{ $req->id }} );" class="btn btn-danger">{{ __('Yes') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan
                @endforeach
            @endif
        </tbody>
    </table>

    <script type="application/javascript">
        function deleteRequest(id) {
            $.ajax({
                url: `/requests/${id}`,
                type: 'POST',
                data: {
                    'id': id,
                    '_method': 'DELETE',
                    '_token': $('#token').val()
                },
                success: () => {
                    $(`#cancel_${id}`).click();
                    document.getElementById('delete-alert').classList.remove('d-none');
                    setTimeout(() => {
                        document.getElementById('delete-alert').classList.add('d-none');
                        window.location.reload();
                    }, 1000);
                }
            })
        };
    </script>

@endsection