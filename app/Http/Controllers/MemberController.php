<?php
namespace App\Http\Controllers;
use App\Models\{Member,Diocese,Parish,SCC,User};
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */


        public function index(Request $request)
    {
        $q = Member::with(['scc','parish','diocese','user'])
            ->when($request->filled('name'), fn($x)=>$x->where(function($y) use($request){
                $y->where('first_name','like','%'.$request->name.'%')
                  ->orWhere('middle_name','like','%'.$request->name.'%')
                  ->orWhere('last_name','like','%'.$request->name.'%');
            }))
            ->when($request->filled('gender'), fn($x)=>$x->where('gender',$request->gender))
            ->when($request->filled('status'), fn($x)=>$x->where('status',$request->status))
            ->when($request->filled('diocese_id'), fn($x)=>$x->where('diocese_id',$request->diocese_id))
            ->when($request->filled('parish_id'), fn($x)=>$x->where('parish_id',$request->parish_id))
            ->when($request->filled('scc_id'), fn($x)=>$x->where('scc_id',$request->scc_id))
            ->orderBy('last_name');
        $members = $q->paginate(20)->withQueryString();
        $dioceses = Diocese::all(); $parishes = Parish::all(); $sccs = SCC::all();
        return view('members.index', compact('members','dioceses','parishes','sccs'));
    }

    public function create()
    {
        return view('members.create',[ 'dioceses'=>Diocese::all(), 'parishes'=>Parish::all(), 'sccs'=>SCC::all() ]);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'first_name'=>'required','middle_name'=>'nullable','last_name'=>'required',
            'gender'=>'required|in:male,female','birthdate'=>'nullable|date',
            'status'=>'required|in:active,inactive',
            'diocese_id'=>'required|exists:dioceses,id',
            'parish_id'=>'required|exists:parishes,id',
            'scc_id'=>'required|exists:s_c_c_s,id',
            'position'=>'nullable|string',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6'
        ]);

        $user = User::create([
            'name' => $data['first_name'].' '.($data['last_name'] ?? ''),
            'email'=> $data['email'],
            'password'=> Hash::make($data['password']),
            'role'=>'member','status'=>'active'
        ]);

        Member::create([
            'user_id'=>$user->id,
            'first_name'=>$data['first_name'],
            'middle_name'=>$data['middle_name'] ?? null,
            'last_name'=>$data['last_name'],
            'gender'=>$data['gender'],
            'birthdate'=>$r->birthdate,
            'status'=>$data['status'],
            'diocese_id'=>$data['diocese_id'],
            'parish_id'=>$data['parish_id'],
            'scc_id'=>$data['scc_id'],
            'position'=>$data['position'] ?? null
        ]);

        return redirect()->route('members.index')->with('ok','Member created');
    }

    public function show(Member $member){ return view('members.show', compact('member')); }

    public function edit(Member $member)
    {
        return view('members.edit',[ 'member'=>$member, 'dioceses'=>Diocese::all(), 'parishes'=>Parish::all(), 'sccs'=>SCC::all() ]);
    }

    public function update(Request $r, Member $member)
    {
        $data = $r->validate([
            'first_name'=>'required','middle_name'=>'nullable','last_name'=>'required',
            'gender'=>'required|in:male,female','birthdate'=>'nullable|date',
            'status'=>'required|in:active,inactive',
            'diocese_id'=>'required|exists:dioceses,id',
            'parish_id'=>'required|exists:parishes,id',
            'scc_id'=>'required|exists:s_c_c_s,id',
            'position'=>'nullable|string'
        ]);
        $member->update($data);
        return back()->with('ok','Updated');
    }

    public function destroy(Member $member)
    {   
        $member->user()?->delete();
        $member->delete();
        return redirect()->route('members.index')->with('ok','Deleted');
    }



}
