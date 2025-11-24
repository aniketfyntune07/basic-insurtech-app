<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Policy;

class PolicyController extends Controller
{
    //

    public function index(){
        $policies = Policy::orderBy('id','desc')->get();

        return view('policies.index', compact('policies'));
    }

    public function create(){
        return view('policies.create');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'policy_number'  => 'required|string|max:255|unique:policies,policy_number',
            'customer_name'  => 'required|string|max:255',
            'type'           => 'required|string|max:50',
            'premium_amount' => 'required|numeric|min:0',
            'start_date'     => 'required|date',
            'end_date'       => 'nullable|date|after_or_equal:start_date',
            'status'         => 'required|string|max:50',
        ]);
        Policy::create($validated);

        return redirect ()
            ->route('policies.index')
            ->with('success', 'Policy created successfully.');
    }

    public function edit(Policy $policy){
        return view('policies.edit', compact('policy'));
    }

    public function update(Request $request, Policy $policy){
         $validated = $request->validate([
            'policy_number'  => 'required|string|max:255|unique:policies,policy_number,' . $policy->id,
            'customer_name'  => 'required|string|max:255',
            'type'           => 'required|string|max:50',
            'premium_amount' => 'required|numeric|min:0',
            'start_date'     => 'required|date',
            'end_date'       => 'nullable|date|after_or_equal:start_date',
            'status'         => 'required|string|max:50',
        ]);

        $policy->update($validated);
        
        return redirect ()
            ->route('policies.index')
            ->with('success', 'Policy updated successfully.');

    }

    public function destroy(Policy $policy){
        $policy->delete();

        return redirect ()
            ->route('policies.index')
            ->with('success', 'Policy deleted successfully.');
    }
}