<div class="max-w-6xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-semibold mb-6">Today’s Appointments</h1>

    @if($appointments->isEmpty())
        <div class="text-center text-gray-600 py-12">
            No appointments scheduled for today.
        </div>
    @else
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clinic Location</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Total</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($appointments as $appointment)
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ optional($appointment->scheduled_at)->format('H:i') }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $appointment->patient->name ?? 'Unknown' }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $appointment->clinicLocation->name ?? 'Unknown' }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $appointment->status }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                                @if($appointment->order)
                                    £{{ number_format($appointment->order->total_price, 2) }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-indigo-600">
                                <a href="#" class="hover:underline">Manage</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
