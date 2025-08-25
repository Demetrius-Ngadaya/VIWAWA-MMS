<?php

namespace Database\Seeders;
use app\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{ public function run(): void {
    $admin = User::create(['name'=>'Admin','email'=>'admin@viwawa.tz','password'=>Hash::make('admin123'), 'role'=>'admin','status'=>'active']);

    $d = Diocese::create(['name'=>'Jimbo Kuu']);
    $p = Parish::create(['name'=>'Parokia Kuu','diocese_id'=>$d->id]);
    $s = SCC::create(['name'=>'Kigango Kuu','parish_id'=>$p->id]);

    $u2 = User::create(['name'=>'Member One','email'=>'member1@viwawa.tz','password'=>Hash::make('member123'),'role'=>'member','status'=>'active']);
    Member::create(['user_id'=>$u2->id,'first_name'=>'Member','middle_name'=>null,'last_name'=>'One','gender'=>'male','birthdate'=>'1998-01-01','status'=>'active','diocese_id'=>$d->id,'parish_id'=>$p->id,'scc_id'=>$s->id,'position'=>'Mwenyekiti']);
 }}