<?php
//
//namespace App\Rules;
//
//use Illuminate\Contracts\Validation\InvokableRule;
//use Illuminate\Support\Facades\DB;
//
//class ExistsForUser implements InvokableRule
//{
//    public function __invoke($attribute, $value, $fail)
//    {
//        var_dump('tes123t');die;
//        $check = DB::table($this->table)
//            ->where('id', $value)
//            ->where('user_id', auth()->user()->id)
//            ->exists();
//
//        dd($check);
//    }
//}
