<?php

namespace App\Http\Controllers\Api;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use App\Models\Appointment;
use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;
use App\Models\User;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 

     public function showall()
{
    return Appointment::with('createdByUser')->get();
}

    public function index(Request $request)
{
    $appointments = Appointment::with('createdByUser')->where('created_by', $request->user()->id)->get();

    // Return the appointments as a non-JSON response
    return $appointments;
}
    /**
     * Store a newly created resource in storage.
     */
    public function store(AppointmentRequest $request)
    {
        $validated = $request->validated();
    
        // Check for overlapping appointments only if the areas are the same
        if (Appointment::where('event_date', $request->event_date)
            ->where('area', $request->area)
            ->where(function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('start_time', '>=', $request->start_time)
                        ->where('start_time', '<', $request->end_time)
                        ->where('end_time', '>', $request->start_time);
                })
                ->orWhere(function ($query) use ($request) {
                    $query->where('start_time', '<=', $request->start_time)
                        ->where('end_time', '>=', $request->end_time)
                        ->where('end_time', '<=', $request->end_time);
                })
                ->orWhere(function ($query) use ($request) {
                    $query->where('start_time', '<=', $request->start_time)
                        ->where('end_time', '>=', $request->end_time)
                        ->where('start_time', '>=', $request->start_time);
                });
            })
            ->exists()) {
            return response()->json(['error' => 'Area is occupied during the specified time'], 422);
        }
    
        // Create the appointment
        $appointment = new Appointment;
        $appointment->area = trim($request->area);
        $appointment->event_name = trim($request->event_name);
        $appointment->start_time = trim($request->start_time);
        $appointment->end_time = trim($request->end_time);
        $appointment->event_date = trim($request->event_date);
        $appointment->status = trim($request->status);
        $appointment->created_by = Auth::user()->id;
    
        // Save the appointment to the database
        $appointment->save();
    
        return response()->json(['message' => 'Appointment successfully created', 'appointment' => $appointment], 201);
    }
    
    
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Appointment::findOrfail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AppointmentRequest $request, string $id)
    {
        $appointment = Appointment::findOrfail($id);

        // Retrieve the validated input data...
        $validated = $request->validated();
 
        $appointment->update([
            'event_name' => $validated['event_name'],
            'area' => $validated['area'],
            'event_date' => $validated['event_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
        ]);
        
        
        $appointment->save();

        return response()->json(['message' => 'Appointment successfully Updated', 'appointment' => $appointment], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            $appointment->delete();
    
            return response()->json(['message' => 'Appointment successfully deleted'], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }
    }
    
    public function accept(Request $request, string $id)
{
    $appointment = Appointment::findOrFail($id);
    
    $appointment->status = 'accepted';
    $appointment->save();

    return response()->json(['message' => 'Appointment successfully accepted', 'appointment' => $appointment], 200);
}

/**
 * Decline the specified appointment.
 */
public function decline(Request $request, string $id)
{
    $appointment = Appointment::findOrFail($id);
    
    $appointment->status = 'declined';
    $appointment->save();

    return response()->json(['message' => 'Appointment successfully declined', 'appointment' => $appointment], 200);
}
}