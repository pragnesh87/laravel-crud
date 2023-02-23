<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Phone</th>
            <th scope="col">Gender</th>
            <th scope="col">Image</th>
            <th scope="col">File</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($users as $i => $user)
            <tr>
                <th scope="row">{{ $i + 1 }}</th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ ucfirst($user->gender) }}</td>
                <td>
                    <img src='{{ asset('storage/' . $user->image) }}' alt='{{ $user->name }}' width='100px'>
                </td>
                <td>
                    @if (!empty($user->file))
                        <a href="{{ asset('storage/' . $user->file) }}" download>Download</a>
                    @endif
                </td>
                <td>
                    <button class="btn btn-sm btn-primary edit-user" data-id="{{ $user->id }}">Edit</button>
                    <button class="btn btn-sm btn-danger delete-user" data-id="{{ $user->id }}">Delete</button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">data not found</td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="8">
                {{ $users->links() }}
            </td>
        </tr>
    </tfoot>
</table>
