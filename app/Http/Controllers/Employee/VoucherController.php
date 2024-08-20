<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('employee.voucher.index', [
            'vouchers' => Voucher::paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('employee.voucher.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255|unique:vouchers',
            "code" => "required|string|max:15|unique:vouchers",
            "description" => "required|string|max:2048",
            "discount_type" => "required|string|in:percentage,fixed",
            "value" => "required|numeric|min:1",
            "usage_limit" => "required|min:1",
            "start_date" => "required|date",
            "end_date" => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($request) {
                    $startDate = Carbon::parse($request->input('start_date'));
                    $endDate = Carbon::parse($value);

                    if ($endDate < $startDate) {
                        $fail('The end date must be after or equal to the start date.');
                    }
                }
            ],
        ]);

        // "name" => "Summer sales"
        //   "code" => "SUMMER20"
        //   "description" => "Summer sales voucher 20% off"
        //   "discount_type" => "percentage"
        //   "value" => "16"
        //   "start_date" => "2024-08-20"
        //   "end_date" => "2024-08-22"
        //   "usage_limit" => "1"

        Voucher::create([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'discount_type' => $request->discount_type,
            'value' => $request->value,
            'start_date' => Carbon::parse($request->start_date)->setTime(0, 0, 0),
            'end_date' => Carbon::parse($request->end_date)->setTime(23, 59, 59),
            'usage_limit' => $request->usage_limit,
        ]);

        $request->session()->flash('status', 'Voucher "' . $request->name . '" successfully created!');
        return redirect('/employee/vouchers');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Voucher  $Voucher
     * @return \Illuminate\Http\Response
     */
    public function show(Voucher $Voucher)
    {
        return redirect()->route('vouchers.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Voucher $voucher
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Voucher $voucher)
    {
        return view('employee.voucher.edit', [
            'voucher' => $voucher
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Voucher $voucher
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Voucher $voucher)
    {
        if (!$voucher) {
            return response()->json(['status' => 'fail', 'message' => 'Voucher not found!']);
        }

        if ($voucher->name == $request->name) {
            return response()->json([
                'status' => 'success',
                'message' => 'Nothing to update!'
            ], 200);
        }


        $rules = [
            'name' => 'required|string|max:255|unique:vouchers'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'message' => json_encode($validator->errors()->toArray(), true),
            ], 422);
        }


        $voucher->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Voucher successfully updated!'
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Voucher $voucher
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        Session()->flash('status', 'Voucher "' . $voucher->name . '" successfully updated!');
        return redirect('/employee/voucher');
    }
}
