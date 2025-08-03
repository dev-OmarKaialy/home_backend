<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JoinRequest;
use Illuminate\Http\Request;

class JoinRequestController extends Controller
{
    // Show all join requests
    public function index()
    {
        $requests = JoinRequest::latest()->get();
        return view('join-requests.index', compact('requests'));
    }

    // Accept a join request
    public function accept($id)
    {
        $request = JoinRequest::findOrFail($id);

        if ($request->status !== 'pending') {
            return redirect()->back()->with('error', 'This request has already been handled.');
        }

        $request->status = 'accepted';
        $request->save();

        return redirect()->back()->with('success', 'Request accepted successfully.');
    }

    // Delete a join request
    public function destroy($id)
    {
        $request = JoinRequest::findOrFail($id);

        try {
            $request->delete();
            return redirect()->back()->with('success', 'Request deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete the request.');
        }
    }
}
