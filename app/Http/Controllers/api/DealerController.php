<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Dealers;
use App\Models\District;
use App\Models\States;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:200',
            'mobile'    => 'required|digits:10|unique:dealers,mobile',
            'address'   => 'nullable|string|max:200',
            'password'  => 'required|min:6|confirmed',
            'state'     => 'required|exists:states,id',
            'district'  => 'required|exists:districts,id',
            'area'      => 'required|string|max:200',
            'pincode'   => 'required|digits:6',
            'gst_no'    => 'nullable|string|max:200',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $dealer = Dealers::create([
            'tally_dealer_id' => NULL,
            'name' => $request->name,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'state' => $request->state,
            'district' => $request->district,
            'area' => $request->area,
            'pincode' => $request->pincode,
            'gst_no' => $request->gst_no,
            'role' => '0',
            'action' => '1',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Dealer added successfully',
            'dealer' => $dealer
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dealer = Dealers::find($id);

        if (!$dealer) {
            return response()->json(['status' => false, 'message' => 'Dealer not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'      => 'sometimes|required|string|max:200',
            'mobile'    => 'sometimes|required|digits:10',
            'address'   => 'nullable|string|max:200',
            'password'  => 'nullable|min:6|confirmed',
            'state'     => 'sometimes|required|exists:states,id',
            'district'  => 'sometimes|required|exists:districts,id',
            'area'      => 'sometimes|required|string|max:200',
            'pincode'   => 'sometimes|required|digits:6',
            'gst_no'    => 'nullable|string|max:200',
        ]);
        // return response()->json($request->all());
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $dealer->update([
            'name' => $request->name ?? $dealer->name,
            'mobile' => $request->mobile ?? $dealer->mobile,
            'address' => $request->address ?? $dealer->address,
            'password' => $request->password ? Hash::make($request->password) : $dealer->password,
            'state' => $request->state ?? $dealer->state,
            'district' => $request->district ?? $dealer->district,
            'area' => $request->area ?? $dealer->area,
            'pincode' => $request->pincode ?? $dealer->pincode,
            'gst_no' => $request->gst_no ?? $dealer->gst_no,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Dealer updated successfully',
            'dealer' => $dealer
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dealer = Dealers::find($id);

        if (!$dealer) {
            return response()->json(['status' => false, 'message' => 'Dealer not found'], 404);
        }

        $dealer->delete();

        return response()->json([
            'status' => true,
            'message' => 'Dealer deleted successfully'
        ]);
    }


    public function state()
    {
        $states = States::whereNull('deleted_at')->select('id', 'state_code', 'state_name')->get();

        if (isEmpty($states)) {
            return response()->json(['status' => false, 'message' => 'States not found'], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'States fetched successfully',
            'states' => $states
        ]);
    }

    public function getDistricts($state_id)
    {
        $districts = District::where('state_id', $state_id)->whereNull('deleted_at')->select('id', 'state_id', 'district_name')->get();
        if (isEmpty($districts)) {
            return response()->json(['status' => false, 'message' => 'Districts not found this State Id'], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Districts fetched successfully',
            'states' => $districts
        ]);
    }
}
