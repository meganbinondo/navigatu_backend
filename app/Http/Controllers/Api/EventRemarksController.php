<?php

namespace App\Http\Controllers\Api;

use App\Models\EventRemarks;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventRemarksRequest;



class EventRemarksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return EventRemarks::all();
    } 

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return EventRemarks::findOrfail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventRemarksRequest $request, string $id)
    {
        $validated = $request->validated();

        $eventremarks = EventRemarks::findOrFail($id);

        $eventremarks->update($validated);

        return $eventremarks;
    }
}