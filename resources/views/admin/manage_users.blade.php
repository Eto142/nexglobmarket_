@include('admin.header')
@include('admin.navbar')

<div class="content-wrapper-scroll">

    <div class="main-header d-flex align-items-center justify-content-between position-relative">
        <div class="d-flex align-items-center justify-content-center"></div>
        <ul class="updates d-flex align-items-end flex-column overflow-hidden" id="updates"></ul>
    </div>

    <div class="content-wrapper">

        @if(session('message'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row gx-3">
            <div class="col-sm-12 col-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="card-title">All Users</div>
                        <form method="GET" action="" class="d-flex gap-2 align-items-center mb-0">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search by name or email" class="form-control w-auto">
                            <button type="submit" class="btn btn-primary btn-sm">Search</button>
                            @if(request('search'))
                                <a href="{{ request()->url() }}" class="btn btn-secondary btn-sm">Clear</a>
                            @endif
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Date Registered</th>
                                        <th>View</th>
                                        <th>Send Mail</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($user as $index => $u)
                                    <tr>
                                        <td>{{ $user->firstItem() + $index }}</td>
                                        <td>{{ $u->name }}</td>
                                        <td>{{ $u->email }}</td>
                                        <td>
                                            @if($u->user_status == '1')
                                                <span class="badge shade-green">Active</span>
                                            @else
                                                <span class="badge shade-red">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($u->created_at)->format('D, M j, Y g:i A') }}</td>
                                        <td><a href="{{ url('admin/profile/' . $u->id) }}"><span class="badge shade-blue">View User</span></a></td>
                                        <td><a href="{{ url('admin/send-user-mail/' . $u->id) }}"><span class="badge shade-green">Send Mail</span></a></td>
                                        <td><a href="{{ url('admin/delete/' . $u->id) }}" onclick="return confirm('Are you sure you want to delete this user?')"><span class="badge shade-red">Delete</span></a></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No users found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                            <small class="text-muted">
                                Showing {{ $user->firstItem() }} to {{ $user->lastItem() }} of {{ $user->total() }} users
                            </small>
                            {{ $user->appends(request()->query())->links() }}
                        </div>

                    </div>{{-- card-body --}}
                </div>{{-- card --}}
            </div>{{-- col --}}
        </div>{{-- row --}}

    </div>{{-- content-wrapper --}}
</div>{{-- content-wrapper-scroll --}}

@include('admin.footer')
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@include('admin.footer')