<?php
namespace App\Http\Controllers;
use App\Models\{Member,Diocese,Parish,SCC,DuesPayment,Contribution,Expense};
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(){ return view('reports.index'); }

    public function members(Request $r)
    {
        $by = $r->get('by','diocese'); // diocese|parish|scc|nation
        if($by==='nation'){
            $tot = Member::count();
            return response()->json([['level'=>'Taifa','total'=>$tot]]);
        }
        $map = [
            'diocese' => ['table'=>'dioceses','fk'=>'diocese_id','label'=>'Jimbo'],
            'parish'  => ['table'=>'parishes','fk'=>'parish_id','label'=>'Parokia'],
            'scc'     => ['table'=>'s_c_c_s','fk'=>'scc_id','label'=>'Kigango'],
        ];
        $m = $map[$by];
        $rows = DB::table('members')
            ->select(DB::raw($m['fk'].' as id'), DB::raw('count(*) as total'))
            ->groupBy($m['fk'])->pluck('total','id');
        $names = DB::table($m['table'])->pluck('name','id');
        $out = [];
        foreach($rows as $id=>$total){ $out[] = ['level'=>$names[$id] ?? 'N/A','total'=>$total]; }
        return response()->json($out);
    }

    public function financial(Request $r)
    {
        $from = $r->get('from'); $to = $r->get('to');
        $dues = DuesPayment::when($from, fn($x)=>$x->whereDate('paid_at','>=',$from))
                           ->when($to, fn($x)=>$x->whereDate('paid_at','<=',$to))
                           ->sum('amount');
        $contrib = Contribution::when($from, fn($x)=>$x->whereDate('contributed_at','>=',$from))
                               ->when($to, fn($x)=>$x->whereDate('contributed_at','<=',$to))
                               ->sum('amount');
        $expenses = Expense::when($from, fn($x)=>$x->whereDate('spent_at','>=',$from))
                           ->when($to, fn($x)=>$x->whereDate('spent_at','<=',$to))
                           ->sum('amount');
        return response()->json(['dues'=>$dues,'contributions'=>$contrib,'expenses'=>$expenses,'balance'=>$dues+$contrib-$expenses]);
    }
}
