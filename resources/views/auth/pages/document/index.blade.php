<x-auth-layout pageTitle="All Documents">

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <x-front.card>
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('document.upload') }}"><button type="button"
                    class="btn btn-success">Upload</button></a>
        </div>
        <table id="myTable" class="table table-hover border">
            <thead>
                <tr>
                    <th>SR#</th>
                    <th>User Name</th>
                    <th>Title</th>
                    <th>Document</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['all'] as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->users['name'] }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->document_file }}</td>
                        <td>{{ $item->status }}</td>
                        <td>
                            <a href="{{ route('document.show', $item->id) }}" title="View document detail"
                            class="btn btn-sm btn-outline-info">
                            <i class="fa fa-eye"></i>
                        </a>
                        @unlessrole('customer')
                            <a href="{{ route('document.edit', $item->id) }}" title="Edit {{ $item->title }} detail"
                                class="btn btn-sm btn-outline-warning">
                                <i class="fa fa-edit"></i>
                            </a>
                            @endunlessrole
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Modal -->
        {{-- <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal Title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Modal content goes here -->
                        <p>This is the modal content.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div> --}}
    </x-front.card>

</x-auth-layout>
