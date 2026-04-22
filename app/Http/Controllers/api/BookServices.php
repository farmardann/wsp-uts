<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Book;

class BookServices extends Controller
{
    public function index()
    {

        if($books = Book::all()) {
            return response()->json(['status' => 'true', 'message' => 'Berhasil mengambil data buku', 'data' => $books]);
        } else {
            return response()->json(['status' => 'false', 'message' => 'Data tidak ditemukan', 'data' => null]);
        }
    }

    public function show($id)
    {

        if($book = Book::find($id)) {
            return response()->json(['status' => 'true', 'message' => 'Berhasil mengambil data buku', 'data' => $book]);
        } else {
            return response()->json(['status' => 'false', 'message' => 'Data tidak ditemukan', 'data' => null]);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'author' => 'required',
            'year' => 'required|integer|min:1900',
            'stock' => 'required|integer|min:0',
        ], [
            'title.required' => 'Judul buku wajib diisi.',
            'author.required' => 'Nama penulis wajib diisi.',
            'year.required' => 'Tahun terbit wajib diisi.',
            'year.integer' => 'Tahun terbit harus berupa angka.',
            'year.min' => 'Tahun terbit tidak valid.',
            'stock.required' => 'Stok buku wajib diisi.',
            'stock.integer' => 'Stok buku harus berupa angka.',
            'stock.min' => 'Stok buku tidak valid.',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'false', 'message' => 'Validasi gagal', 'data' => $validator->errors()], 422);
        }

        $book = Book::create($request->all());
        return response()->json(['status' => 'true', 'message' => 'Berhasil menambahkan data buku', 'data' => $book], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'author' => 'required',
            'year' => 'required|integer|min:1900',
            'stock' => 'required|integer|min:0',
        ], [
            'title.required' => 'Judul buku wajib diisi.',
            'author.required' => 'Nama penulis wajib diisi.',
            'year.required' => 'Tahun terbit wajib diisi.',
            'year.integer' => 'Tahun terbit harus berupa angka.',
            'year.min' => 'Tahun terbit tidak valid.',
            'stock.required' => 'Stok buku wajib diisi.',
            'stock.integer' => 'Stok buku harus berupa angka.',
            'stock.min' => 'Stok buku tidak valid.',
            ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'false', 'message' => 'Validasi gagal', 'data' => $validator->errors()], 422);
        }

        if(Book::find($id)) {
            $book = Book::find($id);
        } else {
            return response()->json(['status' => 'false', 'message' => 'Data tidak ditemukan', 'data' => null]);
        }
        $book->update($request->all());
        return response()->json(['status' => 'true', 'message' => 'Berhasil mengupdate data buku', 'data' => $book]);
    }

    public function destroy($id)
    {
        if (Book::find($id)) {
            Book::destroy($id);
            return response()->json(['status' => 'true', 'message' => 'Berhasil menghapus data buku', 'data' => null]);
        } else {
            return response()->json(['status' => 'false', 'message' => 'Data tidak ditemukan', 'data' => null]);
        }
    }
}
