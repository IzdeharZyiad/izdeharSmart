<x-layouts.users>

    <table id="myTable">
        <thead>
            <tr>
                <th></th>
                <th>اسم الموظف</th>
                <th></th>
            </tr>
        </thead>

        <tbody>

            @foreach ($users as $user)
                <tr class="border-b border-gray-200">
                    <td></td>
                    <td>{{ $user->name }}</td>
                    <td class="space-x-2"><x-link class="text-green-900"
                            href="{{ route('users.updateUser', ['userId' => $user->id]) }}" value="عرض" />
                        <x-link class="text-green-900" href="{{ route('users.attendances', ['userId' => $user->id]) }}"
                            value="الدوام اليومي" />
                        <x-link class="text-green-900" href="{{ route('users.salary', ['userId' => $user->id]) }}"
                            value="الراتب" />
                        <x-link class="text-green-900" href="{{ route('users.advance', ['userId' => $user->id]) }}"
                            value="السلف" />

                    </td>
                </tr>
            @endforeach


        </tbody>


    </table>


</x-layouts.users>
