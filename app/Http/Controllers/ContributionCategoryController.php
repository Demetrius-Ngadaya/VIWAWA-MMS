<?php
namespace App\Http\Controllers;
use App\Models\ContributionCategory; 

use Illuminate\Http\Request;

class ContributionCategoryController extends Controller
{

    public function index(){
        return view('contributions.categories',['categories'=>ContributionCategory::orderBy('name')->get()]); 
    }
    public function store(Request $r){
         $d=$r->validate(['name'=>'required','description'=>'nullable']);
          ContributionCategory::create(['name'=>$d['name'],'description'=>$d['description']??null,'created_by'=>auth()->id()]); 
          return back()->with('ok','Added');
         }
    public function update(Request $r, ContributionCategory $contribution_category){
         $d=$r->validate(['name'=>'required','description'=>'nullable']);
          $contribution_category->update($d); return back()->with('ok','Updated');
         }
    public function destroy(ContributionCategory $contribution_category){
        $contribution_category->delete(); 
        return back()->with('ok','Deleted');
     }

}
