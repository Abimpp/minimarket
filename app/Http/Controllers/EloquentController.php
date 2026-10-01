<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;

class EloquentController extends Controller
{
    public function createData()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => bcrypt('password'),
        ]);

        return $user;
    }

    public function saveData()
    {
        $user = new User;

        $user->name = 'Jane Doe';
        $user->email = 'jane@example.com';
        $user->password = bcrypt('password');

        $user->save();

        return $user;
    }

    public function getAllData()
    {
        $users = User::all();
        return $users;
    }

    public function getById()
    {
        $user = User::find(1);
        return $user;
    }

    public function getByEmail()
    {
        $users = User::where('email', 'johndoe@example.com')->get();
        return $users;
    }

    public function getFirstOrFail()
    {
        $user = User::where('email', 'johndoe@example.com')->firstOrFail();
        return $user;
    }

    public function updateData()
    {
        User::where('email', 'johndoe@example.com')
            ->update([
                'name' => 'John Updated',
            ]);

        return 'Data berhasil diperbarui';
    }

    public function updateWithSave()
    {
        $user = User::find(1);

        $user->name = 'John Updated Again';

        $user->save();

        return $user;
    }

    public function deleteData()
    {
        $user = User::where('email', 'johndoe@example.com')->first();

        if ($user) {
            $user->delete();
        }
        return 'Data berhasil dihapus';
    }

    public function destroyData()
    {
        User::destroy(2);
        return 'Data berhasil dihapus menggunakan destroy';
    }

    public function whereData()
    {
        $users = User::where('role', 'admin')->get();
        return $users;
    }


    public function orWhereData()
    {
        $users = User::where('role', 'admin')
            ->orWhere('role', 'guru')
            ->get();
        return $users;
    }

    public function whereBetweenData()
    {
        $users = User::whereBetween('id', [1, 5])->get();
        return $users;
    }

    public function categoryProducts()
    {
        $category = Category::find(1);
        return $category->products;
    }

    public function mutatorData()
    {
        $user = User::find(1);

        $user->password = 'password123';
        $user->save();

        return 'Password berhasil diperbarui';
    }

    public function accessorData()
    {
        $user = User::find(1);
        return $user->upper_name;
    }
}