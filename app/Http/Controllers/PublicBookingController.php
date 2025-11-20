<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\ClinicLocation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PatientProfile;
use App\Models\TestPanel;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PublicBookingController extends Controller
{
    /**
     * Display available test panels with their tests.
     */
    public function indexTests(): View
    {
        $testPanels = TestPanel::with('tests')->get();

        return view('public.tests.index', compact('testPanels'));
    }

    /**
     * Show the public booking form.
     */
    public function showBookingForm(Request $request): View
    {
        $panelId = $request->input('test_panel_id');
        $clinicLocations = ClinicLocation::all();
        $selectedPanel = $panelId ? TestPanel::with('tests')->find($panelId) : null;

        return view('public.bookings.form', [
            'clinicLocations' => $clinicLocations,
            'selectedPanel' => $selectedPanel,
        ]);
    }

    /**
     * Store a new booking request.
     */
    public function storeBooking(Request $request): View|RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'clinic_location_id' => ['required', 'exists:clinic_locations,id'],
            'scheduled_date' => ['required', 'date'],
            'scheduled_time' => ['required'],
            'test_panel_id' => ['required', 'exists:test_panels,id'],
        ]);

        $user = User::firstOrCreate(
            ['email' => $validated['email']],
            [
                'name' => $validated['name'],
                'password' => Hash::make(Str::random(16)),
            ],
        );

        if (!$user->wasRecentlyCreated && $user->name !== $validated['name']) {
            $user->name = $validated['name'];
            $user->save();
        }

        PatientProfile::firstOrCreate(['user_id' => $user->id]);

        $scheduledAt = Carbon::parse($validated['scheduled_date'] . ' ' . $validated['scheduled_time']);
        $panel = TestPanel::with('tests')->findOrFail($validated['test_panel_id']);

        $appointment = Appointment::create([
            'clinic_location_id' => $validated['clinic_location_id'],
            'room_id' => null,
            'patient_id' => $user->id,
            'scheduled_at' => $scheduledAt,
            'status' => 'scheduled',
        ]);

        $order = Order::create([
            'patient_id' => $user->id,
            'appointment_id' => $appointment->id,
            'total_price' => $panel->price ?? 0,
            'status' => 'pending_payment',
        ]);

        foreach ($panel->tests as $test) {
            OrderItem::create([
                'order_id' => $order->id,
                'test_id' => $test->id,
                'price' => $test->default_price ?? 0,
            ]);
        }

        $appointment->setRelation('order', $order);

        return view('public.bookings.confirmation', [
            'appointment' => $appointment->load(['clinicLocation', 'room', 'patient', 'order.orderItems.test']),
        ]);
    }
}
