<?php
namespace App\Http\Controllers;
use App\Models\{Contribution,ContributionCategory,Member}; 
use Illuminate\Http\Request;

class ContributionController extends Controller
{
    public function index(Request $r)
    {
        $q = Contribution::with(['member','category'])
            ->when($r->filled('category_id'), fn($x)=>$x->where('contribution_category_id',$r->category_id))
            ->when($r->filled('member_id'), fn($x)=>$x->where('member_id',$r->member_id))
            ->when($r->filled('from'), fn($x)=>$x->whereDate('contributed_at','>=',$r->from))
            ->when($r->filled('to'), fn($x)=>$x->whereDate('contributed_at','<=',$r->to))
            ->orderByDesc('contributed_at');
        $contributions = $q->paginate(20)->withQueryString();
        return view('contributions.index', [
            'contributions'=>$contributions,
            'members'=>Member::orderBy('last_name')->get(),
            'categories'=>ContributionCategory::orderBy('name')->get()
        ]);
    }

    public function create(){ return view('contributions.create',[ 'members'=>Member::orderBy('last_name')->get(), 'categories'=>ContributionCategory::orderBy('name')->get() ]); }

    public function store(Request $r)
    {
        $d = $r->validate([
            'member_id'=>'required|exists:members,id',
            'contribution_category_id'=>'required|exists:contribution_categories,id',
            'amount'=>'required|numeric|min:0',
            'contributed_at'=>'required|date','reference'=>'nullable','notes'=>'nullable'
        ]);
        Contribution::create($d);
        return redirect()->route('contributions.index')->with('ok','Recorded');
    }

    public function destroy(Contribution $contribution){ $contribution->delete(); return back()->with('ok','Deleted'); }
}