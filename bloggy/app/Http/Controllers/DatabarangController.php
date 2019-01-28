<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataBarang;

class DatabarangController extends Controller
{
    public function index(){
      return DataBarang::all();
      //return view('barang.databarang');
    }
    public function store(Request $request){
      $this->validate($request,[
      'namaBarang'=> 'required',
      'jumlah'=> 'required'
      ]);
      $data= DataBarang::create($request->all());
      return $data;
    }

    public function show($id){
      $databarang= DataBarang::find($id);
      if(count($databarang)>0)
          return response()->json($databarang);
      return response()-> json(['error' => 'barang tidak tersedia'],404);


    }

    public function update(Request $request, $id){
      $data=DataBarang::find($id);
      $data->update($request->all());
      return response()->json($data);
    }

    public function destroy($id){
      try{
        DataBarang::destroy($id);
        return response([],204);
      }catch(\Exception $e){
        return response(['Dalete Problem: ' . $e], 500);
      }
    }

    public function masuk(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'jumMasuk' => 'required']);
        $jumlah = DataBarang::find($request->id);
        $ttl = $request->jumMasuk + $jumlah->jumlah;
        $jumlah->update(['jumlah' => $ttl]);
        return $jumlah;
    }

    public function keluar(Request $request)
    {
        $this->validate($request,[
            'id' => 'required',
            'jumKeluar' => 'required']);
        $jumlah = DataBarang::find($request->id);
        $stokBaru = $jumlah->jumlah - $request->jumKeluar;
        $jumlah->update(['jumlah' => $stokBaru]);
        return $jumlah;
    }
}
