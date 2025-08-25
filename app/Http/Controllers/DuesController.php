<?php
namespace App\Http\Controllers;
use App\Models\{DuesPayment,Member};
use Illuminate\Http\Request;
class DuesController extends Controller
{
    /**
     * Display a listing of the resource.
     */

        public function index(Request $r)
    {
        $q = DuesPayment::with('member')
            ->when($r->filled('period'), fn($x)=>$x->where('period',$r->period))
            ->when($r->filled('member_id'), fn($x)=>$x->where('member_id',$r->member_id))
            ->orderByDesc('paid_at');
        $dues = $q->paginate(20)->withQueryString();
        return view('dues.index', ['dues'=>$dues,'members'=>Member::orderBy('last_name')->get()]);
    }

    public function create(){ return view('dues.create',['members'=>Member::orderBy('last_name')->get()]); }

    public function store(Request $r)
    {
        $data = $r->validate([
            'member_id'=>'required|exists:members,id',
            'period'=>'required|date_format:Y-m',
            'amount'=>'required|numeric|min:0',
            'paid_at'=>'required|date','method'=>'nullable|string','reference'=>'nullable|string'
        ]);
        DuesPayment::create($data);
        return redirect()->route('dues.index')->with('ok','Recorded');
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */

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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
