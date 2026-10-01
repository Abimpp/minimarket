<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class QueryBuilderController extends Controller
{
    public function insert()
    {
        DB::table('users')->insert([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => bcrypt('password123'),
            'point' => 100
        ]);

        return 'Data berhasil ditambahkan';
    }

    public function getUser()
    {
        $user = DB::table('users')
            ->where('email', 'johndoe@example.com')
            ->first();

        return $user;
    }

    public function selectData()
    {
        $users = DB::table('users')
            ->select('id', 'name')
            ->get();

        return $users;
    }

    public function multipleWhere()
    {
        $users = DB::table('users')
            ->where('status', 'active')
            ->where('role', 'admin')
            ->get();

        return $users;
    }

    public function updateData()
    {
        DB::table('users')
            ->where('email', 'johndoe@example.com')
            ->update([
                'name' => 'Jane Doe',
            ]);

        return 'Data berhasil diperbarui';
    }

    public function incrementData()
    {
        DB::table('users')
            ->where('id', 1)
            ->increment('phone', 10);

        return 'nomor telepon berhasil ditambahkan';
    }

    public function decrementData()
    {
        DB::table('users')
            ->where('id', 1)
            ->decrement('phone', 5);

        return 'nomor telepon berhasil dikurangi';
    }

    public function deleteData()
    {
        DB::table('users')
            ->where('email', 'janedoe@example.com')
            ->delete();

        return 'Data berhasil dihapus';
    }

    public function pluckName()
    {
        $names = DB::table('users')->pluck('name');

        return $names;
    }

    public function pluckEmailName()
    {
        $users = DB::table('users')->pluck('name', 'email');

        return $users;
    }

    public function sumPoints()
    {
        $totalPoints = DB::table('users')->sum('point');
        return $totalPoints;
    }

    public function averagePoints()
    {
        $averagePoints = DB::table('users')->avg('point');
        return $averagePoints;
    }

    public function maxPoints()
    {
        $maxPoints = DB::table('users')->max('point');
        return $maxPoints;
    }

    public function minPoints()
    {
        $minPoints = DB::table('users')->min('point');
        return $minPoints;
    }

    public function limitData()
    {
        $users = DB::table('users')
            ->limit(1)
            ->get();

        return $users;
    }

    public function subqueryData()
    {
        $users = DB::table('users')
            ->whereIn('id', function ($query) {
                $query->from('users')
                    ->select('id')
                    ->where('id', '>', 2);
            })
            ->get();

        return $users;
    }

    public function selectRawData()
    {
        $users = DB::table('users')
            ->selectRaw('COUNT(*) as total_users')
            ->get();

        return $users;
    }
}

