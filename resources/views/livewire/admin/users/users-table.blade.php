<div class="overflow-x-auto w-full mt-3">
    <div class="max-w-xs mb-3">
        @include('livewire.admin.form.input', [
            'name' => 'Пошук',
            'model' => 'searchText',
            'isLive' => true,
        ])
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Імʼя</th>
                <th>Прізвище</th>
                <th>Роль</th>
                <th>Email</th>
                <th>Номер телефону</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach ($this->users as $user)
            <tr class="{{ $user->role === 'admin' ? 'bg-blue-100' : '' }}">
                <th>{{ $user->id }}</th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->last_name }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>
                    <div class="flex justify-end items-center">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary">
                            <i class="ri-pencil-line"></i>
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
      </tbody>
    </table>

    <div class="mt-3 p-3">
        {{ $this->users->links('vendor.livewire.tailwind') }}
    </div>
</div>