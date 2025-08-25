<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Hierarchy;
use App\Models\SCC;
use App\Models\Parish;
use App\Models\Diocese;
use App\Models\Member;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{ public function run(): void {
    $admin = User::create(['name'=>'Admin','email'=>'admin6@viwawa.tz','password'=>Hash::make('admin123'), 'role'=>'admin','status'=>'active']);

    $d = Diocese::create(['name'=>'Jimbo Kuu']);
    $p = Parish::create(['name'=>'Parokia Kuu','diocese_id'=>$d->id]);
    $s = SCC::create(['name'=>'Kigango Kuu','parish_id'=>$p->id]);

    $u2 = User::create(['name'=>'Member One','email'=>'member6@viwawa.tz','password'=>Hash::make('member123'),'role'=>'member','status'=>'active']);
    Member::create(['user_id'=>$u2->id,'first_name'=>'Member','middle_name'=>null,'last_name'=>'One','gender'=>'male','birthdate'=>'1998-01-01','status'=>'active','diocese_id'=>$d->id,'parish_id'=>$p->id,'scc_id'=>$s->id,'position'=>'Mwenyekiti']);
 }}
