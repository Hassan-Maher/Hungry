<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Users Page
        </h2>
    </x-slot>


<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    <div class="bg-white shadow-md rounded-xl p-6 text-center border hover:shadow-xl transition">
        <h5 class="text-gray-500 text-lg">Total Users</h5>
        <h2 class="text-4xl font-bold text-gray-800 mt-2">{{ $users_count ?? 0 }}</h2>
    </div>

    <div class="bg-white shadow-md rounded-xl p-6 text-center border hover:shadow-xl transition">
        <h5 class="text-gray-500 text-lg">Active Users</h5>
        <h2 class="text-4xl font-bold text-green-600 mt-2">{{ $active_users ?? 0 }}</h2>
    </div>

    <div class="bg-white shadow-md rounded-xl p-6 text-center border hover:shadow-xl transition">
        <h5 class="text-gray-500 text-lg">Blocked Users</h5>
        <h2 class="text-4xl font-bold text-red-600 mt-2">{{ $blocked_users ?? 0 }}</h2>
    </div>

</div>

<div class="bg-white shadow-md rounded-xl overflow-hidden">

    {{-- الهيدر + البحث --}}
    <div class="flex flex-col md:flex-row justify-between items-center px-6 py-4 bg-gray-100">

        <h5 class="text-lg font-semibold text-gray-600"> Users List</h5>

        <form action="{{ route('users.index') }}" method="GET" class="flex mt-3 md:mt-0">
            <input 
                type="text" 
                name="search" 
                class="px-4 py-2 rounded-l-full border border-gray-300 focus:ring focus:ring-indigo-300"
                placeholder="🔍 ابحث بالاسم أو الإيميل ..." 
                value="{{ request('search') }}"
            >
            <button 
                class="px-5 py-2 bg-indigo-600 text-white font-semibold rounded-r-full hover:bg-indigo-700 transition">
                بحث
            </button>
            @if(request()->search)
                <a href="{{ route('users.index') }}"
                class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                    مسح البحث
                </a>
            @endif
        </form>

    </div>

    {{-- الجدول --}}
    <div class="overflow-x-auto">
        <table class="w-full text-center">
            <thead class="bg-gray-200">
                <tr class="text-gray-700">
                    <th class="py-3 px-4 border">#</th>
                    <th class="py-3 px-4 border">Name</th>
                    <th class="py-3 px-4 border">Email</th>
                    <th class="py-3 px-4 border">address</th>
                    <th class="py-3 px-4 border">Status</th>
                    <th class="py-3 px-4 border">Operation</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($users as $index => $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-4 border">{{ $index + 1 }}</td>
                        <td class="py-3 px-4 border">{{ $user->name }}</td>
                        <td class="py-3 px-4 border">{{ $user->email }}</td>
                        <td class="py-3 px-4 border">{{ $user->address }}</td>

                        <td class="py-3 px-4 border">
                            @if(!$user->is_bolcked)
                                <span class="bg-green-200 text-green-700 px-3 py-1 rounded-full">Active</span>
                            @else
                                <span class="bg-gray-300 text-gray-700 px-3 py-1 rounded-full">Blocked</span>
                            @endif
                        </td>

                        <td class="py-3 px-4 border space-x-2">

                            <a href="{{ route('users.show' , $user->id) }}" class="px-3 py-1 border rounded-lg text-indigo-600 hover:bg-indigo-50 transition">
                                View
                            </a>

                            @if(!$user->is_bolcked)
                                <form action="{{ route('users.block',$user->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button 
                                        type="submit" 
                                        class="px-3 py-1 border border-red-500 text-red-600 rounded-lg hover:bg-red-50 transition">
                                        Block
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('users.active',$user->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button 
                                        type="submit" 
                                        class="px-3 py-1 border border-green-600 text-green-600 rounded-lg hover:bg-green-50 transition">
                                        Active
                                    </button>
                                </form>
                            @endif

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-5 text-gray-500">لا يوجد مستخدمين حاليًا</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

</x-app-layout>
