<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexToday()
    {
        $today = Carbon::today(config('app.timezone'));

        $appointments = Appointment::with(['patient', 'clinicLocation', 'order'])
            ->whereDate('scheduled_at', $today)
            ->orderBy('scheduled_at')
            ->get();

        return view('admin.appointments.today', [
            'appointments' => $appointments,
        ]);
    }
}
