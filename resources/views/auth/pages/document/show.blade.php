<x-auth-layout pageTitle="User Detail">

    @section('head_button')
        <a href="{{ route('users.edit', $data->id) }}" class="btn btn-warning">Edit {{ $data->title }}</a>
    @endsection

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <x-front.card>
                    <div class="row mb-3">
                        {{-- <div class="col-md-12">
                            <img src="{{ $data->imageUrl() }}" alt="user profile image" srcset="">
                        </div> --}}
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for=""><strong>Title:</strong> {{ $data->title }}</label>
                        </div>
                        <div class="col-md-6">
                            <label for=""><strong>Status:</strong> {{ $data->status == 'approve' ? 'Approve' : ($data->status == 'disapprove' ? 'Disapprove' : 'Pending') }}</label>
                        </div>
                    </div>
                    <div class="row mb-3">

                        <div class="col-md-6">
                            <label for=""><strong>Document File:</strong> {{ $data->document_file }}</label>
                        </div>
                    </div>
                </x-front.card>
            </div>
        </div>
    </div>

</x-auth-layout>
